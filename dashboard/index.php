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
 <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

    <!-- Welcome Section -->
    <header class="mb-10">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
        Welcome back, <span class="animate-floated" style="animation: floated 2s ease-in-out infinite, spin 4s linear infinite">👋</span>
<style>
  @keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
</style>
      </h1>
      <p class="mt-3 text-lg text-gray-500 dark:text-gray-400">
        Let's craft your perfect developer portfolio. Where would you like to start?
      </p>
    </header>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
      <a href="new.php" class="group relative block p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md">
        <div class="absolute inset-0 bg-indigo-50 dark:bg-indigo-900/20 opacity-0 group-hover:opacity-100 rounded-xl transition-opacity duration-300"></div>
        <div class="relative z-10">
          <div class="w-12 h-12 mb-4 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Create New Portfolio</h3>
          <p class="text-gray-500 dark:text-gray-400">Build a stunning portfolio to showcase your projects</p>
        </div>
      </a>
      
      <a href="resume.php" class="group relative block p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md">
        <div class="absolute inset-0 bg-indigo-50 dark:bg-indigo-900/20 opacity-0 group-hover:opacity-100 rounded-xl transition-opacity duration-300"></div>
        <div class="relative z-10">
          <div class="w-12 h-12 mb-4 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Create Resume</h3>
          <p class="text-gray-500 dark:text-gray-400">Design a professional resume that gets you hired</p>
        </div>
      </a>
    </div>

    <!-- Coming Soon Section -->
    <section class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
      <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Exciting Updates Coming Soon</h2>
      </div>
      
      <ul class="space-y-3">
        <li class="flex items-start">
          <span class="flex items-center justify-center w-5 h-5 mt-0.5 mr-3 text-indigo-600 dark:text-indigo-400">
            •
          </span>
          <span class="text-gray-600 dark:text-gray-300">Advanced Resume Builder with AI suggestions</span>
        </li>
        <li class="flex items-start">
          <span class="flex items-center justify-center w-5 h-5 mt-0.5 mr-3 text-indigo-600 dark:text-indigo-400">
            •
          </span>
          <span class="text-gray-600 dark:text-gray-300">Connect social accounts (GitHub, Twitter, LinkedIn)</span>
        </li>
        <li class="flex items-start">
          <span class="flex items-center justify-center w-5 h-5 mt-0.5 mr-3 text-indigo-600 dark:text-indigo-400">
            •
          </span>
          <span class="text-gray-600 dark:text-gray-300">Live portfolio preview mode</span>
        </li>
        <li class="flex items-start">
          <span class="flex items-center justify-center w-5 h-5 mt-0.5 mr-3 text-indigo-600 dark:text-indigo-400">
            •
          </span>
          <span class="text-gray-600 dark:text-gray-300">Visitor analytics dashboard</span>
        </li>
      </ul>
      
      <div class="mt-6 pt-5 border-t border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Have suggestions? <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">We'd love to hear them</a>
        </p>
      </div>
    </section>

</div>
</main>
</body>
</html>
<?php
include '../includes/dash_footer.php';
?>
