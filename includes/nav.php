<nav class="fixed top-0 inset-x-0 z-50 bg-white/75 dark:bg-black/50 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
    <!-- Logo -->
    <div class="text-xl font-semibold text-black dark:text-white">
      <?php echo htmlspecialchars($appName); ?>
    </div>
    <!-- Nav Links -->
    <div class="hidden md:flex space-x-6 text-sm font-medium">
      <a href="#" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition">Home</a>
      <a href="#" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition">Generate</a>
      <a href="#" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition">Docs</a>
    </div>
    <!-- Theme Toggle -->
    <button id="theme-toggle" class="p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
      <svg id="theme-icon" class="w-5 h-5 text-black dark:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <!-- Sun Icon as default -->
<path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
      </svg>
    </button>
  </div>
</nav>