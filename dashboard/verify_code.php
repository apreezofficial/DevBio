<?php
session_start();
require '../includes/conn.php';

$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';
$error = '';

if (empty($email)) {
    header("Location: forgot_password.php");
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
<html lang="en" class="h-full bg-white dark:bg-[#111]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
<body class="h-full flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Verify Your Email</h1>
            <p class="text-gray-500 dark:text-gray-400">Enter the 6-digit code sent to <?php echo htmlspecialchars($email); ?></p>
        </div>
        
        <?php if ($error): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="space-y-6" autocomplete="off">
            <div class="flex justify-center space-x-3">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <input
                        type="text"
                        name="code[]"
                        maxlength="1"
                        pattern="[0-9]"
                        inputmode="numeric"
                        class="code-input w-12 h-12 text-center text-2xl font-bold rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#222] text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-4 focus:ring-indigo-400 transition"
                        oninput="moveToNext(this, <?php echo $i; ?>)"
                        onkeydown="moveToPrevious(event, <?php echo $i; ?>)"
                        onpaste="handlePaste(event)"
                    />
                <?php endfor; ?>
            </div>
            
            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                <p>Didn't receive a code? <a href="forgot_password.php?email=<?php echo urlencode($email); ?>" class="text-indigo-600 dark:text-indigo-400 hover:underline">Resend code</a></p>
                <p class="mt-2">Code expires in 10 minutes</p>
            </div>
            
            <div class="text-center">
                <a href="forgot_password.php" class="text-indigo-600 dark:text-indigo-400 hover:underline">Use a different email</a>
            </div>
        </form>
    </div>

    <script>
        // Auto-focus first input on page load
        document.addEventListener('DOMContentLoaded', () => {
            const firstInput = document.querySelector('input[name="code[]"]');
            if (firstInput) {
                firstInput.focus();
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