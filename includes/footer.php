<footer class="bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 transition-colors duration-500">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
    
    <!-- About -->
    <div>
      <h3 class="text-xl font-semibold mb-4 text-indigo-600 dark:text-indigo-400"><?php echo $appName;?></h3>
      <p class="text-sm leading-relaxed">
        Empowering developers worldwide to build their portfolios with simplicity and style.
        Join us to create, share, and shine.
      </p>
    </div>
    
    <!-- Quick Links -->
    <div>
      <h4 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-400">Quick Links</h4>
      <ul class="space-y-2">
        <li><a href="/" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Home</a></li>
        <li><a href="/dashboard/new" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Generate Portfolio</a></li>
        <li><a href="/docs/" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Docs</a></li>
        <li><a href="/#contact" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Contact</a></li>
      </ul>
    </div>
        <div>
      <h4 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-400">More Links</h4>
      <ul class="space-y-2">
        <li><a href="/dashboard/login.php" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Login</a></li>
        <li><a href="/dashboard/register.php" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Register</a></li>
        <li><a href="/support" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Support</a></li>
      </ul>
    </div>
    
    <!-- Connect -->
    <div>
      <h4 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-400">Connect with Us</h4>
      <div class="flex space-x-6 text-indigo-600 dark:text-indigo-400">
        <a href="https://twitter.com/apcodesphere" aria-label="Twitter" target="_blank" rel="noopener" class="hover:text-indigo-500 transition animate-pulse">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14.86 5.48 5.48 0 002.4-3.02 10.94 10.94 0 01-3.47 1.33 5.44 5.44 0 00-9.28 4.96A15.44 15.44 0 012 4.15a5.44 5.44 0 001.69 7.26 5.42 5.42 0 01-2.47-.68v.07a5.44 5.44 0 004.37 5.33 5.45 5.45 0 01-2.46.09 5.44 5.44 0 005.07 3.78A10.9 10.9 0 012 19.54 15.36 15.36 0 008.29 21c9.14 0 14.14-7.72 14.14-14.42 0-.22 0-.44-.02-.66A10.18 10.18 0 0023 3z"/></svg>
        </a>
        <a href="https://github.com/apreezofficial" aria-label="GitHub" target="_blank" rel="noopener" class="hover:text-indigo-500 transition animate-pulse">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.58 2 12.2c0 4.53 2.87 8.37 6.84 9.73.5.1.68-.22.68-.48 0-.24-.01-1.03-.02-1.86-2.78.62-3.37-1.37-3.37-1.37-.45-1.16-1.1-1.47-1.1-1.47-.9-.62.07-.61.07-.61 1 .07 1.53 1.04 1.53 1.04.89 1.54 2.34 1.1 2.9.84.09-.66.35-1.1.63-1.35-2.22-.26-4.56-1.15-4.56-5.1 0-1.13.39-2.05 1.03-2.77-.1-.26-.45-1.3.1-2.7 0 0 .84-.27 2.75 1.05A9.43 9.43 0 0112 7.62c.85.004 1.71.11 2.51.32 1.9-1.32 2.74-1.05 2.74-1.05.56 1.4.21 2.44.11 2.7.64.72 1.02 1.64 1.02 2.77 0 3.96-2.34 4.83-4.57 5.08.36.32.67.95.67 1.92 0 1.39-.01 2.51-.01 2.86 0 .27.18.59.69.48A10.22 10.22 0 0022 12.2C22 6.58 17.52 2 12 2z"/></svg>
        </a>
        <a href="mailto:apreezofficial@gmail.com" aria-label="Email" class="hover:text-indigo-500 transition animate-pulse">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 2l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"/></svg>
        </a>
      </div>
    </div>

  </div>
  <div class="border-t border-zinc-300 dark:border-zinc-700 mt-8 pt-6 text-center text-sm text-zinc-500 dark:text-zinc-400 select-none">
    &copy; 2025 <?php echo $appName;?>. All rights reserved.
  </div>
  <div style="height:20px;"></div>
</footer>
<?php include 'scripts.php';?>