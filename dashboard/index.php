<?php
include '../includes/settings.php';
if (isset($_COOKIE['user_id'])) {
  $_SESSION['user_id'] = $_COOKIE['user_id'];
  $_SESSION['email'] = $_COOKIE['email'];
}


if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You have to login to access this feature.";

    // Store the full current URL in session
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $current_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['redirect_url'] = $current_url;

    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
      <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="/tailwind.js"></script>
      <link rel="stylesheet" href="./includes/font-awesome/css/all.css">
            <link rel="stylesheet" href="./includes/css/animation.css">
                <script src="/includes/js/theme.js"></script>
  <script>
  tailwind.config = { darkMode: 'class' }
</script>
</head>
<body class="bg-white text-gray-800 dark:bg-[#0D0D0D] dark:text-gray-100 transition-colors duration-300">
  <?php include '../includes/dashnav.php';?>
  
<main class="flex-1 p-6 bg-gray-50 dark:bg-[#111827] text-gray-800 dark:text-white min-h-screen transition-all">
  <div class="max-w-7xl mx-auto">

    <!-- Welcome Section -->
    <div class="mb-6">
      <h1 class="text-2xl md:text-3xl font-bold">Welcome back, <?= htmlspecialchars($user['username']) ?> 👋</h1>
      <p class="text-gray-600 dark:text-gray-400 mt-1">Ready to build your dev portfolio?</p>
    </div>
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <a href="new.php" class="bg-white dark:bg-[#1f2937] hover:shadow-xl transition p-5 rounded-xl border border-gray-200 dark:border-gray-700">
        <h2 class="font-semibold text-lg mb-2">🎯 Create New Portfolio</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Add a new Portfolio to your List.</p>
      </a>
      
      <a href="resume.php" class="bg-white dark:bg-[#1f2937] hover:shadow-xl transition p-5 rounded-xl border border-gray-200 dark:border-gray-700">
        <h2 class="font-semibold text-lg mb-2">📝 Create Resume</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Update your developer bio and skills.</p>
      </a>
      
      <a href="theme-customizer.php" class="bg-white dark:bg-[#1f2937] hover:shadow-xl transition p-5 rounded-xl border border-gray-200 dark:border-gray-700">
        <h2 class="font-semibold text-lg mb-2">🎨 Customize Theme</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Choose colors, fonts, and layout.</p>
      </a>
    </div>

    <!-- Coming Soon -->
    <div class="mt-10">
      <h2 class="text-xl font-semibold mb-4">📢 Coming Soon</h2>
      <ul class="list-disc ml-5 text-sm text-gray-500 dark:text-gray-400">
        <li>Connect social accounts (GitHub, X, LinkedIn)</li>
        <li>Live portfolio preview mode</li>
        <li>Analytics dashboard</li>
      </ul>
    </div>

  </div>
</main>
</body>
</html>
<?php
include '../includes/dash_footer.php';
?>
