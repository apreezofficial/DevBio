<?php
session_start();
require '../includes/conn.php';

if (!isset($_GET['token'])) {
    header("Location: forgot.php?error=invalid_token");
    exit();
}

$token = $_GET['token'];
$error = '';

// Verify token exists and get user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['reset_user_id'] = $user['id']; // Store user ID in session
    header("Location: reset_password.php");
    exit();
} else {
    // Token invalid or already used
    header("Location: forgot.php?error=invalid_token");
    exit();
}
?>