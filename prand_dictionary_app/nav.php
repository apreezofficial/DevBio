<?php
session_start();
$_SESSION['user']= 'ap';
  $app_name = "Prand";
$default_word = isset($_GET['word']) ? htmlspecialchars($_GET['word']) : '';
$dark_mode = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true';
  ?>
  <header class="w-full px-6 py-4 bg-gray-100 dark:bg-gray-800 shadow-md flex justify-between items-center fixed top-0 z-50">
  <!-- Left: Logo & App Name -->
  <div class="flex items-center gap-3">
    <i class="fas fa-book text-2xl text-primary-light dark:text-primary-dark"></i>
    <a class="text-2xl sm:text-3xl font-bold text-primary-light dark:text-primary-dark" href="./index.php"><?php echo $app_name; ?></a>
  </div>

  <!-- Right: Theme toggle + Profile -->
  <div class="relative w-full h-6">
    <!-- Theme Toggle with Tooltip -->
    <div class="relative group">
      <button id="themeToggle" class="absolute right-4 top-2 text-gray-800 dark:text-gray-200 hover:text-blue-500 dark:hover:text-blue-400 transition text-xl">
        <i class="fas <?php echo $dark_mode ? 'fa-sun' : 'fa-moon'; ?>"></i>
      </button>
    </div>
</header>
<?php echo '<div style="height:60px;"></div>';?>