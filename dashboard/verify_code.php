<?php
session_start();
require '../includes/conn.php';

$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';
$error = '';

if (empty($email)) {
    header("Location: forgot.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = implode('', $_POST['code']);
    
    // Check if code matches
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND reset_code = ? AND code_expires > NOW()");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['reset_user_id'] = $user['id'];
        header("Location: reset_password.php");
        exit();
    } else {
        $error = 'Invalid or expired verification code';
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
  <script src="../tailwind.js"></script>  <script src="../includes/js/theme.js"></script>
        <link rel="stylesheet" href="../includes/font-awesome/css/all.css">
            <link rel="stylesheet" href="../includes/css/body.css">
     <script>
  tailwind.config = { darkMode: 'class' }
</script>
    <style>
        .code-input {
            -moz-appearance: textfield;
        }
        .code-input::-webkit-outer-spin-button,
        .code-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gray-50 dark:bg-[#0d0d0d]">
    <div class="w-full max-w-md bg-white dark:bg-[#1a1a1a] rounded-2xl shadow-xl dark:shadow-gray-900/30 p-8 border border-gray-100 dark:border-gray-800/50">
        <!-- Verification Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-indigo-100 dark:border-indigo-800/30">
                <i class="fas fa-shield-check text-2xl text-indigo-500 dark:text-indigo-400"></i>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Verify Your Identity</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-4">We sent a 6-digit code to <span class="font-medium text-indigo-600 dark:text-indigo-400"><?php echo htmlspecialchars($email); ?></span></p>
            
            <div class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-50/80 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30 backdrop-blur-sm">
                <i class="fas fa-envelope-open-text mr-2 text-indigo-500 dark:text-indigo-300"></i>
                <span class="text-sm text-indigo-600 dark:text-indigo-300">You can use the link in your verification mail too</span>
            </div>
        </div>
        
<?php if ($error): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'error',
                title: <?php echo json_encode($error); ?>,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-300 border border-red-400 dark:border-red-700 rounded-lg p-4'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        });
    </script>
<?php endif; ?>
        
        <!-- Verification Form -->
        <form method="post" class="space-y-6" autocomplete="off">
            <div class="flex justify-center space-x-3">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <input
                        type="text"
                        name="code[]"
                        maxlength="1"
                        pattern="[0-9]"
                        inputmode="numeric"
                        class="code-input w-10 md:w-14 h-14 text-center text-3xl font-bold rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-[#222] text-gray-800 dark:text-gray-100 focus:outline-none focus:border-indigo-400 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-900/50 transition-all duration-150"
                        oninput="moveToNext(this, <?php echo $i; ?>)"
                        onkeydown="moveToPrevious(event, <?php echo $i; ?>)"
                        onpaste="handlePaste(event)"
                    />
                <?php endfor; ?>
            </div>
            
            <!-- Action Links -->
            <div class="space-y-4 text-center">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>Didn't receive a code? <a href="forgot.php?email=<?php echo urlencode($email); ?>" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Resend code</a></p>
                    <p class="mt-1 text-xs opacity-80">Code expires in 10 minutes</p>
                </div>
                
                <div class="pt-2 border-t border-gray-100 dark:border-gray-800/50">
                    <a href="forgot.php" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                        <i class="fas fa-arrow-left mr-1"></i> Use different email
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Auto-focus first input on page load
        document.addEventListener('DOMContentLoaded', () => {
            const firstInput = document.querySelector('input[name="code[]"]');
            if (firstInput) {
                firstInput.focus();
                firstInput.select();
            }
        });

        function moveToNext(input, index) {
            // Only allow numeric input
            input.value = input.value.replace(/[^0-9]/g, '');
            
            if (input.value.length === 1) {
                if (index < 5) {
                    const nextInput = input.form.elements['code[]'][index + 1];
                    nextInput.focus();
                    nextInput.select();
                } else {
                    // Last input - submit form
                    input.form.submit();
                }
            }
        }
        
        function moveToPrevious(event, index) {
            if (event.key === 'Backspace' && index > 0 && event.target.value === '') {
                const prevInput = event.target.form.elements['code[]'][index - 1];
                prevInput.focus();
                prevInput.select();
            }
        }
        
        function handlePaste(event) {
            event.preventDefault();
            const pasteData = event.clipboardData.getData('text').replace(/[^0-9]/g, '');
            const inputs = document.querySelectorAll('input[name="code[]"]');
            
            for (let i = 0; i < Math.min(pasteData.length, 6); i++) {
                inputs[i].value = pasteData[i];
                inputs[i].classList.add('animate-pulse');
                setTimeout(() => inputs[i].classList.remove('animate-pulse'), 200);
            }
            
            if (pasteData.length >= 6) {
                event.target.form.submit();
            } else if (pasteData.length > 0) {
                inputs[Math.min(pasteData.length, 5)].focus();
            }
        }
    </script>
</body>
</html>