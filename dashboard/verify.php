<?php
session_start();
require '../includes/pdo.php';

$token = $_GET['token'] ?? '';
if (!$token) die("Invalid token");

$stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token=?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("Token not found.");
}

if ($user['verified']) {
    echo "Account already verified. <a href='login.php'>Login</a>";
} else {
    $stmt = $pdo->prepare("UPDATE users SET verified=1, verification_token=NULL, verification_code=NULL, code_expires=NULL WHERE id=?");
    $stmt->execute([$user['id']]);
    echo "Account verified successfully! <a href='login.php'>Login here</a>";
}