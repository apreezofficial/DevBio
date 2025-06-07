<?php
declare(strict_types=1);
error_reporting(0); // Disable error display (log errors in production)
session_start();

header('Content-Type: application/json');

// ========== MAIN REQUEST HANDLER ========== //
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST requests allowed!", 405);
    }

    // Get input data (supports both JSON and form-data)
    $input = getRequestData();

    if (isset($input['ajax'])) {
        // Handle CODE GENERATION request
        $response = handleCodeGeneration($input);
    } else {
        // Handle PROJECTS DATA request
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

// ========== HELPER FUNCTIONS ========== //

/**
 * Get and sanitize request data (JSON or form-data)
 */
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

/**
 * Handle CODE GENERATION request
 */
function handleCodeGeneration(array $data): array {
    // Sanitize ALL inputs
    $input = [
        'dev_name'            => sanitizeString($data['dev_name'] ?? ''),
        'dev_email'           => sanitizeEmail($data['dev_email'] ?? ''),
        'tech_role'           => sanitizeString($data['tech_role'] ?? ''),
        'frontend_tech'       => sanitizeString($data['frontend_tech'] ?? ''),
        'styling'             => sanitizeString($data['styling'] ?? ''),
        'additional_components' => sanitizeComponents($data['additional_components'] ?? []),
        'project_name'        => sanitizeString($data['project_name'] ?? ''),
        'github'              => sanitizeString($data['github'] ?? ''),
        'live_url'            => sanitizeUrl($data['live_url'] ?? ''),
        'description'         => sanitizeString($data['description'] ?? ''),
        'avatar_url'          => sanitizeUrl($data['avatar_url'] ?? ''),
        'project_image'       => sanitizeUrl($data['project_image'] ?? ''),
        'additional_images'   => sanitizeString($data['additional_images'] ?? '')
    ];

    // Validate required fields
    validateRequiredFields($input);

    // Generate AI prompt & call API
    $prompt = buildPrompt($input);
    $apiResponse = callAIApi($prompt);
    $files = parseApiResponse($apiResponse);

    // Store in session
    $_SESSION['generated_files'] = $files;

    return [
        'status'  => 'success',
        'message' => 'Project files generated!',
        'files'   => $files
    ];
}

/**
 * Handle PROJECTS DATA request
 */
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
            'image'      => sanitizeUrl($project['image'] ?? ''),
            'github'     => sanitizeUrl($project['github'] ?? '')
        ];

        // Validate required fields
        if (empty($sanitized['name'])) {
            throw new Exception("Project name is required for project #" . ($index + 1), 400);
        }

        $projects[] = $sanitized;
    }

    // Store in session
    $_SESSION['projects'] = $projects;

    return [
        'status'  => 'success',
        'message' => 'Projects saved successfully!',
        'projects' => $projects
    ];
}

// ========== SANITIZATION & VALIDATION ========== //

function sanitizeString(string $value): string {
    return htmlspecialchars(stripslashes(trim($value)), ENT_QUOTES, 'UTF-8');
}

function sanitizeUrl(string $value): string {
    $clean = filter_var(trim($value), FILTER_SANITIZE_URL);
    return $clean ?: '';
}

function sanitizeEmail(string $value): string {
    $clean = filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    return $clean ?: '';
}

/**
 * Sanitize components (handles both arrays and strings)
 */
function sanitizeComponents($components): array {
    if (is_string($components)) {
        return array_filter(
            array_map('trim', explode(',', $components)),
            function($item) { return !empty($item); }
        );
    }
    return is_array($components) ? array_filter($components, 'is_string') : [];
}

/**
 * Validate required fields for code generation
 */
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

// ========== AI PROMPT & API CALL ========== //

function buildPrompt(array $input): string {
    $components = !empty($input['additional_components']) ? 
        implode(", ", $input['additional_components']) : 'None';

    $projectsSection = '';
    if (!empty($_SESSION['projects'])) {
        $projectsSection = "\n\nPROJECTS SHOWCASE:\n";
        foreach ($_SESSION['projects'] as $project) {
            $projectsSection .= "- {$project['name']}: {$project['description']}";
            if ($project['url']) $projectsSection .= " | Live: {$project['url']}";
            if ($project['github']) $projectsSection .= " | GitHub: {$project['github']}";
            if ($project['image']) $projectsSection .= " | Image: {$project['image']}";
            $projectsSection .= "\n";
        }
    }

    return <<<EOD
You are a top-tier developer assistant. Generate a complete, error-free, and highly professional project for a personal portfolio based on the input below.

CRITICAL REQUIREMENTS:
- Every file must be properly named and formatted. Missing or incorrect file names are not allowed.
- Use Font Awesome icons by default unless the user specifically says otherwise.
- Make the portfolio super clean, visually appealing, modern, fast, and job-ready.
- Code must follow best practices, correct structure, and clean naming conventions.
- Final result should look like it was built by a senior developer aiming to impress a top-tier company.

Developer Details:

The Developer Name: $dev_name  
The developer Email: $dev_email  
His/Her Role/Title in tech(detect gender from developer name): $tech_role  
Programming Language/Framework to be used to build the app: $frontend_tech  
Styling Method: $styling  
Additional Libraries needed: $components
User Avatar URL: $avatar_url  

User past Projects Info:
- Project Name: $project_name  
- GitHub Username: $github  
- Live Project URL: $live_url  
- Project Description: $description  
- Main Project Image: $project_image  
- Additional Images: $additional_images

YOUR TASK:

1. Start with a full Project File Tree — show the folder structure clearly.

2. For every file, output it using this exact format:  
   <name>filename<name>  
   ...file contents here...  
   <name>filename<name>  
   Make sure the file name is correct and complete. No mistakes or placeholders.

3. Include only files relevant to the selected framework/language, such as:
   - Entry point (e.g., index.html, App.js, App.vue)
   - CSS or styling setup (e.g., style.css, tailwind.config.js)
   - JS/Component scripts (e.g., main.js, Header.jsx)
   - .gitignore, LICENSE, and README.md
   - Config files (e.g., vite.config.js, webpack.config.js)
   - Any assets/ used (e.g., image files, favicon)
   - public/ content like robots.txt if referenced

4. Every code block must be:
   - Fully valid and working
   - Free from errors
   - Neatly formatted and styled
   - Styled and structured with the mad clean, modern, and responsive design expected of a production-ready portfolio.

5. Do NOT include any explanation, commentary, or notes outside the <name>filename<name> tags.

GOAL:
Deliver a blazingly fast, production-grade, and beautifully coded portfolio with correct file names, full structure, modern UI, and Font Awesome icons (unless told otherwise).
EOD;
}

function callAIApi(string $prompt): string {
    $apiUrl = "https://text.pollinations.ai/" . rawurlencode($prompt);

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => 30000
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