<?php
session_start();
require '../vendor/autoload.php';
require '../includes/pdo.php';
error_reporting(1);

// HTML head with required SweetAlert assets
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
HTML;

$token = $_GET['token'] ?? '';
if (!$token) {
    echo <<<JS
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid verification token',
            didClose: () => {
                window.location.href = 'login.php';
            }
        });
    </script>
    </body>
    </html>
    JS;
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    echo <<<JS
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid verification token',
            didClose: () => {
                window.location.href = 'login.php';
            }
        });
    </script>
    </body>
    </html>
    JS;
    exit;
}

if ($user['verified']) {
    echo <<<JS
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            toast: true,
            position: 'top',
            icon: 'success',
            title: 'Your account is already verified, kindly login',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            customClass: {
                popup: 'bg-green-500 text-white dark:bg-green-700 dark:text-gray-200 p-2 mb-2 rounded shadow-lg'
            },
            didClose: () => {
                window.location.href = 'login.php';
            }
        });
    </script>
    </body>
    </html>
    JS;
} else {
    $stmt = $pdo->prepare("UPDATE users SET verified = 1, verification_token = NULL, verification_code = NULL, code_expires = NULL WHERE id = ?");
    $stmt->execute([$user['id']]);
    
    echo <<<JS
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            toast: true,
            position: 'top',
            icon: 'success',
            title: 'Your account has been verified successfully!',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            customClass: {
                popup: 'bg-green-500 text-white dark:bg-green-700 dark:text-gray-200 p-2 mb-2 rounded shadow-lg'
            },
            didClose: () => {
                window.location.href = 'login.php';
            }
        });
    </script>
    </body>
    </html>
    JS;
}
?>