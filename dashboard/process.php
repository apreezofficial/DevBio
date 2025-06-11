<?php
header('Content-Type: application/json');
error_reporting(0);

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST allowed']);
    exit;
}

// Helper for sanitizing input
function sanitize(string $v): string {
    return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}

// Collect and sanitize form fields
$full   = sanitize($_POST['fullname'] ?? '');
$pos    = sanitize($_POST['position'] ?? '');
$email  = sanitize($_POST['email'] ?? '');
$phone  = sanitize($_POST['phone'] ?? '');
$loc    = sanitize($_POST['location'] ?? '');
$sum    = sanitize($_POST['summary'] ?? '');

// Validate required fields
foreach (['fullname' => $full, 'position' => $pos, 'email' => $email, 'phone' => $phone, 'summary' => $sum] as $name => $val) {
    if (!$val) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => ucfirst($name) . ' is required']);
        exit;
    }
}

// Build prompt text
$prompt = "Generate a strong modern resume:\n";
$prompt .= "Dont say anything apart fron the resume itself:\n";
$prompt .= "Name: $full\nPosition: $pos\nEmail: $email\nPhone: $phone\nLocation: $loc\nSummary: $sum\n";
// add education entries
if (!empty($_POST['school'])) {
    $prompt .= "Education:\n";
    foreach ($_POST['school'] as $i => $school) {
        $sch = sanitize($school);
        $deg = sanitize($_POST['degree'][$i] ?? '');
        $yr  = sanitize($_POST['edu_year'][$i] ?? '');
        $prompt .= "- $deg at $sch ($yr)\n";
    }
}

// add work entries
if (!empty($_POST['company'])) {
    $prompt .= "Work Experience:\n";
    foreach ($_POST['company'] as $i => $company) {
        $co = sanitize($company);
        $ro = sanitize($_POST['role'][$i] ?? '');
        $du = sanitize($_POST['duration'][$i] ?? '');
        $prompt .= "- $ro at $co ($du)\n";
    }
}

// add project entries
if (!empty($_POST['project_title'])) {
    $prompt .= "Projects:\n";
    foreach ($_POST['project_title'] as $i => $pt) {
        $ptitle = sanitize($pt);
        $pdesc  = sanitize($_POST['project_description'][$i] ?? '');
        $prompt .= "- $ptitle: $pdesc\n";
    }
}

// add skills list
if (!empty($_POST['skills'])) {
    $skills = array_map('sanitize', $_POST['skills']);
    $prompt .= "Skills: " . implode(', ', $skills) . "\n";
}

// add external links
if (!empty($_POST['platform'])) {
    $prompt .= "Links:\n";
    foreach ($_POST['platform'] as $i => $pf) {
        $plat = sanitize($pf);
        $url  = sanitize($_POST['url'][$i] ?? '');
        $prompt .= "- $plat: $url\n";
    }
}

// Encode and call Pollinations text endpoint with GET
$url = 'https://text.pollinations.ai/' . rawurlencode($prompt);
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_TIMEOUT => 60,
]);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Return API result
if ($response !== false && $code === 200) {
    echo json_encode(['success' => true, 'resume' => $response]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch from Pollinations',
        'api_code' => $code,
        'api_response' => $response
    ]);
}