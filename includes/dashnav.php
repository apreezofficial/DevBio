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
      <img src="/assets/logo.png" alt="Logo" class="w-6 h-6">
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
      <button id="theme-toggle" class="ml-4 p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-transform active:scale-95">
        <svg id="theme-icon" class="w-5 h-5 text-black dark:text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M12 8.25V5.25" class="block dark:hidden"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" class="hidden dark:block"/>
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
        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
          <i class="fas fa-user mr-3 text-gray-400 dark:text-gray-500 w-4 text-center"></i> Profile
        </a>
        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
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
</script>