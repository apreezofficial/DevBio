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
<nav class="bg-white dark:bg-[#0D0D0D] border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between shadow-sm">
  <!-- Left: Logo -->
  <a href="./" class="flex items-center space-x-2">
    <img src="/assets/logo.svg" alt="Logo" class="w-8 h-8">
    <span class="text-xl font-bold text-gray-800 dark:text-gray-100"><?php echo $appName;?></span>
  </a>
  <div class="hidden md:flex space-x-6">
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-primary transition">Dashboard</a>
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-primary transition">Projects</a>
    <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-primary transition">Settings</a>
  </div>

  <!-- Right: User / Theme Switch -->
  <div class="flex items-center space-x-4">
        <button id="theme-toggle" class="p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
      <svg id="theme-icon" class="w-5 h-5 text-black dark:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <!-- Sun Icon as default -->
        <path d="M12 3v2m0 14v2m9-9h-2M5 1" />
      </svg>
    </button>
   <!-- User Initial Circle -->
<div class="relative group">
  <button onclick="toggleUserMenu()" class="w-10 h-10 rounded-full overflow-hidden shadow-lg ring-2 ring-purple-500 transition-transform hover:scale-105 focus:outline-none">
    <?php if ($user && !empty($user['avatar'])): ?>
      <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="object-cover w-full h-full">
    <?php else: ?>
      <div class="w-full h-full flex items-center justify-center bg-purple-600 text-white font-semibold text-lg">
        <?= strtoupper(substr($user['email'], 0, 1)) ?>
      </div>
    <?php endif; ?>
  </button>

  <!-- Dropdown Menu -->
  <div id="userMenu" class="absolute right-0 mt-2 w-44 bg-white dark:bg-[#1f1f1f] text-sm rounded-md shadow-lg p-2 z-20 hidden">
    <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
    <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
    <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
  </div>
</div>
  </div>
</nav>
<script>
  function toggleUserMenu() {
    const menu = document.getElementById("userMenu");
    menu.classList.toggle("hidden");
  }
  document.addEventListener("click", function(e) {
    const menu = document.getElementById("userMenu");
    const trigger = e.target.closest("button");

    if (!e.target.closest("#userMenu") && !trigger) {
      menu.classList.add("hidden");
    }
  });
</script>