<?php
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
require '../includes/conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = 'No account found with that email address';
        } else {
            $user = $result->fetch_assoc();
            $verification_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $token = bin2hex(random_bytes(32));

            // Update database with token and code
            $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_code = ?, code_expires = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE id = ?");
            $stmt->bind_param("ssi", $token, $verification_code, $user['id']);
            $stmt->execute();

            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = $_ENV['MAIL_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['MAIL_USERNAME'];
                $mail->Password   = $_ENV['MAIL_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
                $mail->Port       = 587;

                // Fix SSL error
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ];

                $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_NAME']);
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';

                $reset_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/dashboard/verify_forgot.php?token=$token";

                $mail->Body = "
                    <h2>Password Reset Request</h2>
                    <p>We received a request to reset your password. Here's your verification code:</p>
                    <h3 style='font-size: 24px; letter-spacing: 5px; color: #6366f1; margin: 20px 0;'>$verification_code</h3>
                    <p><em>This code will expire in 10 minutes.</em></p>
                    <p>Or click this link to reset your password:</p>
                    <p><a href='$reset_link' style='color: #6366f1; text-decoration: underline;'>Reset Password</a></p>
                    <p>If you didn't request this, please ignore this email.</p>
                ";

                $mail->AltBody = "Password Reset Request\n\nVerification Code: $verification_code (expires in 10 minutes)\n\nOr use this link: $reset_link";

                $mail->send();

                setcookie('reset_code', $verification_code, time() + 600, '/');
                header("Location: verify_code.php?email=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-white dark:bg-[#111]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="h-full flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Forgot Password</h1>
            <p class="text-gray-500 dark:text-gray-400">Enter your email to reset your password</p>
        </div>
        
        <?php if ($error): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="space-y-6" autocomplete="off">
            <div class="relative">
                <input  
                    type="text"  
                    name="email"  
                    placeholder="Email"  
                    class="w-full pl-14 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-400 transition"  
                />
                <i  
                    class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-indigo-400 dark:text-indigo-500 pointer-events-none"  
                ></i>
            </div>
            
            <button class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-purple-700 hover:to-indigo-600 text-white font-extrabold rounded-xl shadow-lg hover:shadow-2xl transition">
                Send Reset Instructions
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="login.php" class="text-indigo-600 dark:text-indigo-400 hover:underline">Back to Login</a>
        </div>
    </div>
</body>
</html>