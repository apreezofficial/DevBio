<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    $stmt->close();
}
?>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <nav class="bg-white/90 dark:bg-[#0D0D0D]/90 backdrop-blur-sm border-b border-gray-100 dark:border-gray-800 px-6 py-3.5 flex items-center justify-between">
  <!-- Logo -->
  <a href="./" class="flex items-center space-x-3 group">
    <div class="p-1.5 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 group-hover:rotate-12 transition-transform duration-300">
      <img src="/assets/logo.svg" alt="Logo" class="w-6 h-6">
    </div>
    <span class="text-xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight"><?php echo $appName; ?></span>
  </a>

  <!-- Navigation Links -->
  <div class="hidden md:flex space-x-1">
    <a href="#" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-800/50">
      Dashboard
    </a>
    <a href="#" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-800/50">
      Projects
    </a>
    <a href="#" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-800/50">
      Settings
    </a>
  </div>

  <!-- Right Side Controls -->
  <div class="flex items-center space-x-3">
    <!-- Theme Toggle -->
    <button id="theme-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all" aria-label="Toggle theme">
      <svg id="theme-icon" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24">
        <path class="hidden dark:block" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 16a4 4 0 100-8 4 4 0 000 8z"/>
        <path class="dark:hidden" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4V3m0 18v-1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M5.636 5.636l-.707.707M16.364 5.636l.707.707M5.636 18.364l.707.707"/>
      </svg>
    </button>

    <!-- User Menu -->
    <div class="relative">
      <button onclick="toggleUserMenu()" class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-transparent hover:ring-purple-400/30 transition-all focus:outline-none">
        <?php if ($user && !empty($user['avatar'])): ?>
          <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="object-cover w-full h-full">
        <?php else: ?>
          <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-600 text-white font-medium">
            <?= strtoupper(substr($user['email'], 0, 1)) ?>
          </div>
        <?php endif; ?>
      </button>

      <!-- Dropdown Menu -->
      <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl py-1.5 z-20 hidden border border-gray-100 dark:border-gray-700">
        <div class="px-4 py-2.5 border-b border-gray-100 dark:border-gray-700">
          <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?= htmlspecialchars($user['name'] ?? 'User') ?></p>
          <p class="text-xs text-gray-500 dark:text-gray-400 truncate"><?= htmlspecialchars($user['email']) ?></p>
        </div>
        <a href="profile.php" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
          <i class="fas fa-user mr-3 text-gray-400 dark:text-gray-500 w-4 text-center"></i> Profile
        </a>
        <a href="settings.php" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
          <i class="fas fa-cog mr-3 text-gray-400 dark:text-gray-500 w-4 text-center"></i> Settings
        </a>
        <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-gray-700/50">
          <i class="fas fa-sign-out-alt mr-3 text-red-400 w-4 text-center"></i> Logout
        </a>
      </div>
    </div>
  </div>
</nav>

<script>
  function toggleUserMenu() {
    const menu = document.getElementById("userMenu");
    menu.classList.toggle("hidden");
  }

  // Close menu when clicking outside
  document.addEventListener("click", function(e) {
    const menu = document.getElementById("userMenu");
    if (!e.target.closest("#userMenu") && !e.target.closest("button[onclick='toggleUserMenu()']")) {
      menu.classList.add("hidden");
    }
  });

  // Theme toggle functionality
  const themeToggle = document.getElementById("theme-toggle");
  themeToggle.addEventListener("click", () => {
    document.documentElement.classList.toggle("dark");
    localStorage.theme = document.documentElement.classList.contains("dark") ? "dark" : "light";
  });
</script>