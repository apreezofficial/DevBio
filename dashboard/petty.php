<?php
declare(strict_types=1);
error_reporting(0);
session_start();

header('Content-Type: application/json');

// MAIN HANDLER
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST requests allowed!", 405);
    }

    $input = getRequestData();

    if (isset($input['ajax'])) {
        $response = handleCodeGeneration($input);
    } else {
        $response = handleProjectsData($input);
    }

    echo json_encode($response);
} catch (Throwable $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}

// ========== HELPERS ==========

function getRequestData(): array {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (strpos($contentType, 'application/json') !== false) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON data!", 400);
        }
        return $data;
    }

    return $_POST;
}

function handleCodeGeneration(array $data): array {
    $input = [
        'dev_name'              => sanitizeString($data['dev_name'] ?? ''),
        'dev_email'             => sanitizeEmail($data['dev_email'] ?? ''),
        'tech_role'             => sanitizeString($data['tech_role'] ?? ''),
        'frontend_tech'         => sanitizeString($data['frontend_tech'] ?? ''),
        'styling'               => sanitizeString($data['styling'] ?? ''),
        'additional_components' => sanitizeComponents($data['additional_components'] ?? []),
        'project_name'          => sanitizeString($data['project_name'] ?? ''),
        'github'                => sanitizeString($data['github'] ?? ''),
        'live_url'              => sanitizeUrl($data['live_url'] ?? ''),
        'description'           => sanitizeString($data['description'] ?? ''),
        'avatar_url'            => sanitizeUrl($data['avatar_url'] ?? ''),
        'project_image'         => sanitizeUrl($data['project_image'] ?? ''),
        'additional_images'     => sanitizeString($data['additional_images'] ?? ''),
                'projects'     => sanitizeString($data['projects'] ?? 'No project Yet')
    ];

    validateRequiredFields($input);

    $prompt = buildPrompt($input);
    $apiResponse = callAIApi($prompt);
    $files = parseApiResponse($apiResponse);

    $_SESSION['generated_files'] = $files;

    return [
        'status' => 'success',
        'message' => 'Project files generated!',
        'files' => $files
    ];
}

function handleProjectsData(array $data): array {
    if (!isset($data['projects']) || !is_array($data['projects'])) {
        throw new Exception("No projects data received!", 400);
    }

    $projects = [];
    foreach ($data['projects'] as $index => $project) {
        $sanitized = [
            'name'        => sanitizeString($project['name'] ?? ''),
            'url'         => sanitizeUrl($project['url'] ?? ''),
            'description' => sanitizeString($project['description'] ?? ''),
            'image'       => sanitizeUrl($project['image'] ?? ''),
            'github'      => sanitizeUrl($project['github'] ?? '')
        ];

        if (empty($sanitized['name'])) {
            throw new Exception("Project name is required for project #" . ($index + 1), 400);
        }

        $projects[] = $sanitized;
    }

    $_SESSION['projects'] = $projects;

    return [
        'status' => 'success',
        'message' => 'Projects saved successfully!',
        'projects' => $projects
    ];
}

// ========== SANITIZATION ==========

function sanitizeString(string $value): string {
    return htmlspecialchars(stripslashes(trim($value)), ENT_QUOTES, 'UTF-8');
}

function sanitizeUrl(string $value): string {
    return filter_var(trim($value), FILTER_SANITIZE_URL) ?: '';
}

function sanitizeEmail(string $value): string {
    return filter_var(trim($value), FILTER_SANITIZE_EMAIL) ?: '';
}

function sanitizeComponents($components): array {
    if (is_string($components)) {
        return array_filter(
            array_map('trim', explode(',', $components)),
            fn($item) => !empty($item)
        );
    }
    return is_array($components) ? array_filter($components, 'is_string') : [];
}

function validateRequiredFields(array $input): void {
    $required = [
        'dev_name'      => 'Developer name is required!',
        'dev_email'     => 'Valid email is required!',
        'tech_role'     => 'Tech role is required!',
        'frontend_tech' => 'Frontend tech is required!',
        'styling'       => 'Styling method is required!'
    ];

    foreach ($required as $field => $message) {
        if (empty($input[$field])) {
            throw new Exception($message, 400);
        }
    }

    if (!filter_var($input['dev_email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format!", 400);
    }
}

// ========== PROMPT GENERATION ==========

function buildPrompt(array $input): string {
    extract($input); // imports all keys as variables

    $components = !empty($additional_components) ? implode(', ', $additional_components) : 'None';

    $projectsSection = '';
    if (!empty($_SESSION['projects'])) {
        $projectsSection = "\n\nPROJECTS SHOWCASE:\n";
        foreach ($_SESSION['projects'] as $project) {
            $projectsSection .= "- {$project['name']}: {$project['description']}";
            if ($project['url'])    $projectsSection .= " | Live: {$project['url']}";
            if ($project['github']) $projectsSection .= " | GitHub: {$project['github']}";
            if ($project['image'])  $projectsSection .= " | Image: {$project['image']}";
            $projectsSection .= "\n";
        }
    }

    return <<<EOD
You are a top-tier developer assistant. Generate a complete, error-free, and professional portfolio project based on this:

Developer Name: $dev_name  
Email: $dev_email  
Role/Title: $tech_role  
Frontend Tech: $frontend_tech  
Styling: $styling  
Additional Components: $components  
Avatar URL: $avatar_url

Previous Projects details of the Developer( $dev_name ):
$projects

Format each file like:
<name>filename<name>
...file content...
<name>filename<name>
on no condition mist your file formatting be differnt from tgat wbich i have given you, let me say ut again,
<name>filename<name>
...file content...
<name>filename<name>

CURLOPT_SSL_VERIFYPEER
Use Font Awesome icons unless told otherwise. Code must be production-ready, fast, modern, and properly structured.
EOD;
}

// ========== API CALL & PARSE ==========

function callAIApi(string $prompt): string {
    $apiUrl = "https://text.pollinations.ai/" . rawurlencode($prompt);

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => 200
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        throw new Exception("API Error: " . curl_error($ch), 500);
    }
    curl_close($ch);

    return $response;
}

function parseApiResponse(string $response): array {
    $files = [];
    preg_match_all('/<name>([^<]+)<name>\s*(.*?)\s*<name>\1<name>/s', $response, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $files[] = [
            'filename' => trim($match[1]),
            'code' => trim($match[2])
        ];
    }

    return $files ?: [['filename' => 'output.txt', 'code' => $response]];
}