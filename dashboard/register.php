<?php
session_start();
require '../vendor/autoload.php';
require '../includes/pdo.php';
require '../includes/settings.php';
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendVerificationEmail($email, $code, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['MAIL_PORT'];

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        // Recipients
        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_NAME']);
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = '🔒 Verify your DevBio Account';

        $link = "http://{$_SERVER['HTTP_HOST']}/dashboard/verify.php?token=$token";

        $mail->Body = "
        <html>
        <body style='font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 30px;'>
            <div style='max-width: 600px; margin: auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);'>
                <div style='background: #8A2BE2; color: white; padding: 20px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 28px;'>Verify Your DevBio Account</h1>
                </div>
                <div style='padding: 30px; color: #333;'>
                    <p style='font-size: 16px;'>Hi there,</p>
                    <p style='font-size: 16px;'>Use the following code to verify your DevBio account:</p>
                    <div style='font-size: 32px; font-weight: bold; letter-spacing: 4px; background: #f0f0f0; padding: 15px; text-align: center; border-radius: 8px; margin: 20px 0;'>$code</div>
                    <p style='font-size: 16px;'>Or click the button below to verify instantly:</p>
                    <p style='text-align: center;'>
                        <a href='$link' style='display: inline-block; background: #8A2BE2; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;'>Verify Now</a>
                    </p>
                    <p style='font-size: 14px; color: #666;'>This code will expire in 10 minutes. If you didn’t request this, you can ignore this email.</p>
                    <br/>
                    <p style='font-size: 14px;'>Cheers,<br/><strong>The DevBio Team</strong></p>
                </div>
                <div style='background: #f0f0f0; padding: 10px; text-align: center; font-size: 12px; color: #999;'>
                    &copy; " . date('Y') . " DevBio. All rights reserved.
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
// Initialization
$errors = [];
$success = '';
$email = '';
$showVerification = false;
$codeSentTime = $_SESSION['code_sent_time'] ?? 0;

// Handle Signup Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if (!$email) $errors[] = "Enter a valid email.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $user['verified']) {
            $errors[] = "This email is already registered and verified. Please login.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $code = random_int(100000, 999999);
            $token = bin2hex(random_bytes(16));
            $now = time();

            if ($user) {
                // Update unverified
                $stmt = $pdo->prepare("UPDATE users SET password=?, verification_code=?, code_expires=?, verification_token=?, verified=0 WHERE email=?");
                $stmt->execute([$hashed, $code, $now + 600, $token, $email]);
            } else {
                // New user
                $stmt = $pdo->prepare("INSERT INTO users (email, password, verification_code, code_expires, verification_token, verified, avatar) VALUES (?, ?, ?, ?, ?, 0, ?)");
                $stmt->execute([$email, $hashed, $code, $now + 600, $token, "https://ui-avatars.com/api/?name=$email&background=2563eb&color=fff"
                ]);
            }

            if (sendVerificationEmail($email, $code, $token)) {
                $_SESSION['pending_email'] = $email;
                $_SESSION['code_sent_time'] = $now;
                $showVerification = true;
            } else {
                $errors[] = "Failed to send verification email.";
            }
        }
    }
}
// To Handle Code Verification
if (isset($_POST['verify_code'])) {
    $codeInput = trim($_POST['code']);
    $email = $_SESSION['pending_email'] ?? '';

    if (!$email) {
        $errors[] = "No pending email. Please signup first!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = "User not found.";
        } elseif ($user['verified']) {
            $errors[] = "Account already verified.";
        } elseif (time() > $user['code_expires']) {
            $errors[] = "Code expired. Please resend.";
            $showVerification = true;
        } elseif ($codeInput == $user['verification_code']) {
            $stmt = $pdo->prepare("UPDATE users SET verified=1, verification_token=NULL, verification_code=NULL, code_expires=NULL WHERE email=?");
            $stmt->execute([$email]);
            unset($_SESSION['pending_email']);
            unset($_SESSION['code_sent_time']);
            $success = "Account verified! You may now login.";
        } else {
            $errors[] = "Invalid code.";
            $showVerification = true;
        }
    }
}
// Handle Resend
if (isset($_GET['resend']) && isset($_SESSION['pending_email'])) {
    $email = $_SESSION['pending_email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && !$user['verified']) {
        $code = random_int(100000, 999999);
        $token = bin2hex(random_bytes(16));
        $now = time();

        $stmt = $pdo->prepare("UPDATE users SET verification_code=?, code_expires=?, verification_token=? WHERE email=?");
        $stmt->execute([$code, $now + 600, $token, $email]);

        if (sendVerificationEmail($email, $code, $token)) {
            $_SESSION['code_sent_time'] = $now;
            $showVerification = true;
        } else {
            $errors[] = "Failed to resend email.";
        }
    }
}
$codeSentTime = $_SESSION['code_sent_time'] ?? 0;
$timeLeft = max(0, 600 - (time() - $codeSentTime));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?php echo $appName;?> Signup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="../tailwind.js"></script>  <script src="../includes/js/theme.js"></script>
        <link rel="stylesheet" href="../includes/font-awesome/css/all.css">
            <link rel="stylesheet" href="../includes/css/body.css">
  <script>
  tailwind.config = { darkMode: 'class' }
</script>
</head>
<body class="bg-gray-50 dark:bg-[#0D0D0D] text-gray-900 dark:text-white min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md p-6 rounded-xl bg-white dark:bg-[#111] shadow-lg">
  <?php if (!empty($success)) : ?>
    <div class="bg-green-600 text-white px-4 py-2 mb-4 rounded text-center font-semibold">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>
  <?php foreach ($errors as $error): ?>
    <div class="bg-red-500 text-white px-4 py-2 mb-2 rounded"><?= htmlspecialchars($error) ?></div>
  <?php endforeach; ?>
  <?php if ($showVerification && isset($_SESSION['pending_email'])): ?>
    <!-- Verification Code Form -->
    <div class="max-w-md mx-auto mt-16 p-8 rounded-3xl glass-effect shadow-xl transition-colors duration-500">
    <h2 class="text-2xl font-bold mb-4 text-indigo-600 dark:text-indigo-400">Verify Your Email</h2>
    <p class="mb-4">We sent a code to <strong><?= htmlspecialchars($_SESSION['pending_email']) ?></strong><br>If you can't enter the code now.We also sent a link along side, use that at your convenuence to verify your mail</p>
    <?php if ($timeLeft > 0): ?>
      <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
        Code expires in: <span id="timer" class="font-mono"><?= gmdate("i:s", $timeLeft) ?></span>
      </p>
    <?php else: ?>
      <p class="text-sm text-red-500 mb-2">Code expired. <a href="?resend=1" class="text-blue-600 underline">Resend code</a></p>
    <?php endif; ?>
<form method="POST" id="otp-form" class="space-x-2 flex justify-center">
  <input type="text" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*" class="otp-input w-8 md:w-12 h-12 text-center border rounded text-xl dark:bg-[#222] dark:border-gray-600" />
  <input type="text" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*" class="otp-input w-8 md:w-12 h-12 text-center border rounded text-xl dark:bg-[#222] dark:border-gray-600" />
  <input type="text" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*" class="otp-input w-8 md:w-12 h-12 text-center border rounded text-xl dark:bg-[#222] dark:border-gray-600" />
  <input type="text" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*" class="otp-input w-8 md:w-12 h-12 text-center border rounded text-xl dark:bg-[#222] dark:border-gray-600" />
  <input type="text" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*" class="otp-input w-8 md:w-12 h-12 text-center border rounded text-xl dark:bg-[#222] dark:border-gray-600" />
  <input type="text" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*" class="otp-input w-8 md:w-12 h-12 text-center border rounded text-xl dark:bg-[#222] dark:border-gray-600" />
</form>
<div class="text-sm text-center mt-4">
  Didn’t receive it?
  <a href="#" id="resend-link" class="text-blue-600 underline">Resend Code</a>
  <span id="resend-status" class="ml-2 text-xs text-gray-500"></span>
</div>
</div>
<script>
document.getElementById("resend-link").addEventListener("click", function(e) {
    e.preventDefault();
    
    const status = document.getElementById("resend-status");
    status.textContent = "Sending...";
    
    fetch(window.location.pathname + '?resend=1', {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
            
        }
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("resend_success")) {
            status.textContent = "Code resent!";
            status.classList.remove("text-red-500");
            status.classList.add("text-green-600");
        } else if (data.includes("resend_failed")) {
            status.textContent = "Failed to resend.";
            status.classList.remove("text-green-600");
            status.classList.add("text-red-500");
        } else {
            status.textContent = "Unexpected response.";
            status.classList.remove("text-green-600");
            status.classList.add("text-red-500");
        }
    })
    .catch(() => {
        status.textContent = "Network error.";
        status.classList.remove("text-green-600");
        status.classList.add("text-red-500");
    });
});
</script>
  <?php else: ?>
<div
  class="max-w-md mx-auto mt-16 p-8 rounded-3xl glass-effect shadow-xl transition-colors duration-500"
>
  <div class="flex justify-between items-center mb-8">
    <h2
      class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 select-none"
    >
      Create Your <?php echo $appName;?> Account
    </h2>
  </div>

  <form method="POST" autocomplete="off" class="space-y-6">
    <!-- Email Input -->
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

    <!-- Password Input with Toggle -->
    <div class="relative">
      <input
        type="password"
        name="password"
        id="password-input"
        placeholder="Password"
        minlength="6"
        class="w-full pl-14 pr-14 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-400 transition"
      />
      <i
        class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-indigo-400 dark:text-indigo-500 pointer-events-none"
      ></i>
      <button
        type="button"
        id="toggle-password"
        class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition"
        aria-label="Toggle Password Visibility"
      >
        <i class="fas fa-eye"></i>
      </button>
    </div>
    <button
      type="submit"
      name="signup"
      class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-purple-700 hover:to-indigo-600 text-white font-extrabold rounded-xl shadow-lg hover:shadow-2xl transition"
    >
      Sign Up
    </button>
  </form>
  <!-- Login and Social Signup Section -->
<div class="mt-6 space-y-4 text-center">

  <!-- Login redirect -->
  <p class="text-sm text-gray-600 dark:text-gray-400">
    Already have an account?
    <a href="login.php" class="text-indigo-600 hover:text-purple-600 font-bold transition">
      Login
    </a>
  </p>

  <!-- OR Divider -->
  <div class="relative my-4">
    <hr class="border-gray-300 dark:border-gray-700" />
    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-white dark:bg-[#111] px-1 text-sm text-gray-500 dark:text-gray-400 select-none">
      or sign up with
    </span>
  </div>

  <!-- Social Login Buttons -->
  <div class="flex flex-col sm:flex-row gap-4">
    <!-- GitHub -->
    <a
      href="./github-auth.php"
      class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] hover:bg-gray-100 dark:hover:bg-[#333] text-gray-800 dark:text-gray-200 font-semibold transition"
    >
      <i class="fab fa-github text-xl"></i> GitHub
    </a>

    <!-- Google -->
    <a
      href="./google-auth.php"
      class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] hover:bg-gray-100 dark:hover:bg-[#333] text-gray-800 dark:text-gray-200 font-semibold transition"
    >
      <i class="fab fa-google text-xl text-red-500"></i> Google
    </a>
  </div>
</div>
</div>
  <?php endif; ?>
</div>
</body>

<script>
// Timer Countdown
let seconds = <?= $timeLeft ?>;
const timerEl = document.getElementById('timer');
if (timerEl) {
  const countdown = setInterval(() => {
    seconds--;
    if (seconds <= 0) {
      clearInterval(countdown);
      timerEl.innerText = '00:00';
      return;
    }
    const min = String(Math.floor(seconds / 60)).padStart(2, '0');
    const sec = String(seconds % 60).padStart(2, '0');
    timerEl.innerText = `${min}:${sec}`;
  }, 1000);
}
</script>
  <script src="../includes/js/otp.js"></script>
    <script src="../includes/js/password.js"></script>
</html>