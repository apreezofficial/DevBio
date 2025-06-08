<?php
$data = json_decode(file_get_contents("php://input"), true);
$content = $data['content'] ?? '';
$ext = $data['ext'] ?? 'txt';
$filename = $data['filename'] ?? ('resume_' . time() . '.' . $ext);

// Save into the PUBLIC /resumes folder at root level
$publicDir = realpath(__DIR__ . '/../resumes'); // Adjust path if your PHP script is in /api or /scripts
if (!$publicDir) {
    mkdir(__DIR__ . '/../resumes', 0777, true);
    $publicDir = realpath(__DIR__ . '/../resumes');
}

$path = $publicDir . '/' . basename($filename);
file_put_contents($path, $content);

// Generate full URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$url = "$protocol://$host/resumes/" . basename($filename);

echo json_encode(['success' => true, 'url' => $url]);