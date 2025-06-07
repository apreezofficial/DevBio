<?php
session_start();
require '../includes/settings.php';
require '../includes/pdo.php';
if (isset($_COOKIE['user_id'])) {
  $_SESSION['user_id'] = $_COOKIE['user_id'];
  $_SESSION['email'] = $_COOKIE['email'];
}
if (isset($_SESSION['user_id'])) {
    if (!empty($_SESSION['redirect_url'])) {
        $url = $_SESSION['redirect_url'];
        unset($_SESSION['redirect_url']);
        header("Location: $url");
    } else {
        header("Location: /dashboard/");
    }
    exit;
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        $errors[] = "Invalid credentials.";
    } elseif (!$user['verified']) {
        $errors[] = "Please verify your email first.";
    } elseif (!password_verify($password, $user['password'])) {
        $errors[] = "Wrong password.";
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        setcookie('user_id', $_SESSION['user_id'] , time() + 60 * 60 * 24 * 30); // 30 days cookie
  setcookie('email', $_SESSION['email'] , time() + 60 * 60 * 24 * 30); // 30 days cookie
        if (!empty($_SESSION['redirect_url'])) {
    $url = $_SESSION['redirect_url'];
    unset($_SESSION['redirect_url']); // Optional: clear after use
    header("Location: $url");
} else {
    header("Location: /dashboard/new.php");
}
exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title><?php echo $appName;?> Logib</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="../tailwind.js"></script>  <script src="../includes/ts/theme.ts"></script>
        <link rel="stylesheet" href="../includes/font-awesome/css/all.css">
            <link rel="stylesheet" href="../includes/css/body.css">
  <script>
  tailwind.config = { darkMode: 'class' }
</script>
</head>
<body class="bg-gray-50 dark:bg-[#0D0D0D] text-gray-900 dark:text-white min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md mx-auto mt-16 p-8 rounded-3xl glass-effect shadow-xl transition-colors duration-500">
        <?php foreach ($errors as $err): ?>
            <div class="bg-red-500 text-white p-2 mb-2 rounded"><?= $err ?></div>
        <?php endforeach; ?>
          <div class="flex justify-between items-center mb-8">
    <h2
      class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 select-none"
    >
      Login to Your <?php echo $appName;?> Account
    </h2>
  </div>
        <form method="post" class="space-y-6" autocomplete="false">
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
            <button class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-purple-700 hover:to-indigo-600 text-white font-extrabold rounded-xl shadow-lg hover:shadow-2xl transition">Login</button>
        </form>
         <!-- Login and Social Signup Section -->
<div class="mt-6 space-y-4 text-center">

  <!-- Login redirect -->
  <p class="text-sm text-gray-600 dark:text-gray-400">
    New Here?
    <a href="register.php" class="text-indigo-600 hover:text-purple-600 font-bold transition">
      Register
    </a>
  </p>

  <!-- OR Divider -->
  <div class="relative my-4">
    <hr class="border-gray-300 dark:border-gray-700" />
    <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-white dark:bg-[#111] px-1 text-sm text-gray-500 dark:text-gray-400 select-none">
      or sign in with
    </span>
  </div>

  <!-- Social Login Buttons -->
  <div class="flex flex-col sm:flex-row gap-4">
    <!-- GitHub -->
    <a
      href="github-auth.php"
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
</body>
    <script src="../includes/ts/password.ts"></script>
</html>