     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<nav class="fixed top-0 inset-x-0 z-50 bg-white/80 dark:bg-[#0a0a0a]/80 backdrop-blur-lg border-b border-zinc-200/50 dark:border-zinc-800/50 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
    <!-- Logo + Mobile Menu Button -->
    <div class="flex items-center space-x-4">
      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="md:hidden p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-transform active:scale-95">
        <svg class="w-6 h-6 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      
      <!-- Logo -->
      <a href="#" class="text-xl font-bold text-black dark:text-white hover:opacity-80 transition">
        <?php echo htmlspecialchars($appName); ?>
      </a>
    </div>

    <!-- Desktop Nav Links -->
    <div class="hidden md:flex space-x-6 text-sm font-medium items-center">
      <a href="/" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition hover:-translate-y-0.5">Home</a>
      <a href="/dashboard/new.php" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition hover:-translate-y-0.5">Generate</a>
      <a href="/docs" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition hover:-translate-y-0.5">Docs</a>
            <a href="/dashboard/login.php" class="text-zinc-700 dark:text-zinc-300 hover:text-black dark:hover:text-white transition hover:-translate-y-0.5">Client Area</a>
      
      <!-- Theme Toggle -->
      <button id="theme-toggle" class="ml-4 p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-transform active:scale-95">
        <svg id="theme-icon" class="w-5 h-5 text-black dark:text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M12 8.25V5.25" class="block dark:hidden"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" class="hidden dark:block"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Theme Toggle (hidden on desktop) -->
    <div class="md:hidden">
      <button id="mobile-theme-toggle" class="p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-transform active:scale-95">
        <svg class="w-5 h-5 text-black dark:text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M12 8.25V5.25" class="block dark:hidden"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" class="hidden dark:block"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Sidebar -->
  <div id="mobile-sidebar" class="fixed left-0 z-50 w-64 bg-white dark:bg-[#111] shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden border-r border-zinc-200 dark:border-zinc-800">
    <div class="flex flex-col h-full p-4">
      <!-- Close Button -->
      <div class="flex justify-end p-2">
        <button id="close-sidebar" class="p-2 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-800 transition">
          <svg class="w-6 h-6 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      
      <!-- Mobile Navigation Links -->
      <nav class="flex-1 space-y-2 mt-4">
        <a href="/" class="block px-4 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition flex items-center">
          <i class="fas fa-home mr-3 text-indigo-500"></i> Home
        </a>
        <a href="/dashboard/new.php" class="block px-4 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition flex items-center">
          <i class="fas fa-bolt mr-3 text-indigo-500"></i> Generate
        </a>
        <a href="/docs" class="block px-4 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition flex items-center">
          <i class="fas fa-book mr-3 text-indigo-500"></i> Docs
        </a>
                <a href="/dashboard/login.php" class="block px-4 py-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition flex items-center">
          <i class="fa fa-person mr-3 text-indigo-500"></i> Client Area
        </a>
      </nav>
      
      <!-- Bottom Area -->
      <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center justify-between text-sm text-zinc-500 dark:text-zinc-400">
          <span>Dark Mode</span>
          <button id="sidebar-theme-toggle" class="relative inline-flex h-6 w-11 items-center rounded-full bg-zinc-200 dark:bg-zinc-700 transition-colors">
            <span class="sr-only">Toggle theme</span>
            <span class="inline-block h-4 w-4 transform rounded-full bg-white dark:bg-indigo-400 translate-x-1 dark:translate-x-6 transition-transform"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Overlay -->
  <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>
</nav>

<script>
  // Mobile sidebar toggle
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const closeSidebar = document.getElementById('close-sidebar');
  const mobileSidebar = document.getElementById('mobile-sidebar');
  const sidebarOverlay = document.getElementById('sidebar-overlay');
  
  mobileMenuButton.addEventListener('click', () => {
    mobileSidebar.classList.remove('-translate-x-full');
    sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
    document.body.classList.add('overflow-hidden');
  });
  
  closeSidebar.addEventListener('click', () => {
    mobileSidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
    document.body.classList.remove('overflow-hidden');
  });
  
  sidebarOverlay.addEventListener('click', () => {
    mobileSidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
    document.body.classList.remove('overflow-hidden');
  });
  
  // Theme toggle functionality (works for all three toggle buttons)
  const themeToggleButtons = ['theme-toggle', 'mobile-theme-toggle', 'sidebar-theme-toggle'];
  
  themeToggleButtons.forEach(id => {
    const button = document.getElementById(id);
    if (button) {
      button.addEventListener('click', toggleTheme);
    }
  });
  
  function toggleTheme() {
    const html = document.documentElement;
    const newTheme = html.classList.contains('dark') ? 'light' : 'dark';
    html.classList.toggle('dark');
    localStorage.setItem('theme', newTheme);
  }
  
  // Initialize theme
  if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
</script>