<?php
session_start();
require '../includes/conn.php';

// Redirect if not coming from a verified reset request
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot_password.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if (empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        // Update password and clear reset fields
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user_id = $_SESSION['reset_user_id'];
        
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_code = NULL, code_expires = NULL WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            // Clear session and cookie
            unset($_SESSION['reset_user_id']);
            setcookie('reset_code', '', time() - 3600, '/');
            $success = 'Password reset successfully!';
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-white dark:bg-[#111]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="h-full flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Reset Password</h1>
            <p class="text-gray-500 dark:text-gray-400">Create a new password</p>
        </div>
        
        <?php if ($error): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
                <?php echo $success; ?>
                <div class="mt-2">
                    <a href="login.php" class="text-green-700 hover:underline">Go to Login</a>
                </div>
            </div>
        <?php else: ?>
            <form method="post" class="space-y-6" autocomplete="off">
                <!-- Password Input with Toggle -->  
                <div class="relative">  
                    <input  
                        type="password"  
                        name="password"  
                        id="password-input"  
                        placeholder="New Password"  
                        minlength="6"  
                        class="w-full pl-14 pr-14 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-400 transition"  
                        required
                    />  
                    <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-indigo-400 dark:text-indigo-500 pointer-events-none"></i>  
                    <button  
                        type="button"  
                        id="toggle-password"  
                        class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition"  
                        aria-label="Toggle Password Visibility"  
                    >  
                        <i class="fas fa-eye"></i>  
                    </button>  
                </div>
                
                <!-- Confirm Password Input -->  
                <div class="relative">  
                    <input  
                        type="password"  
                        name="confirm_password"  
                        id="confirm-password-input"  
                        placeholder="Confirm New Password"  
                        minlength="6"  
                        class="w-full pl-14 pr-14 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-400 transition"  
                        required
                    />  
                    <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-indigo-400 dark:text-indigo-500 pointer-events-none"></i>  
                </div>
                
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-purple-700 hover:to-indigo-600 text-white font-extrabold rounded-xl shadow-lg hover:shadow-2xl transition">
                    Reset Password
                </button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>