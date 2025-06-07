<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto">
      <div class="relative flex items-center bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <input type="text" id="searchInput" value="<?php echo $default_word; ?>" placeholder="Search for a word..."
          class="flex-grow px-4 py-3 bg-transparent text-black dark:text-white outline-none" />
        <button id="searchBtn" class="px-4 py-3 bg-primary-light dark:bg-primary-dark text-white">
          <i class="fas fa-search"></i>
        </button>
      </div>
      <div id="suggestions" class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700"></div>
    </div>

    <p id="infoText" class="text-center mt-4"><?php echo $default_word ? 'Searching for: ' . $default_word : 'Type a word and press Enter'; ?></p>

    <!-- Shimmer loading effect -->
    <div id="loadingShimmer" class="hidden mt-10 max-w-3xl mx-auto">
      <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
          <div class="w-full">
            <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded shimmer mb-2 w-3/4"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer mb-2 w-1/2"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer w-1/3"></div>
          </div>
          <div class="h-8 w-8 bg-gray-200 dark:bg-gray-700 rounded-full shimmer"></div>
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
          <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded shimmer mb-4 w-1/3"></div>
          <div class="space-y-3">
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer w-full"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer w-5/6"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer w-4/6"></div>
          </div>
        </div>
        <div class="space-y-6">
          <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded shimmer mb-4 w-1/4"></div>
            <div class="space-y-3">
              <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer w-full"></div>
              <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded shimmer w-5/6"></div>
            </div>
          </div>
          <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded shimmer mb-4 w-1/3"></div>
            <div class="flex flex-wrap gap-2">
              <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded shimmer w-16"></div>
              <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded shimmer w-20"></div>
              <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded shimmer w-14"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="resultContainer" class="mt-10 max-w-3xl mx-auto hidden">
      <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
          <div>
            <h2 id="word" class="text-3xl font-bold">_</h2>
            <p id="phonetic" class="italic text-secondary-light dark:text-secondary-dark">_</p>
            <p id="partOfSpeech" class="font-semibold text-sm">_</p>
          </div>
          <div>
            <button id="speakBtn" class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full">
              <i class="fas fa-volume-up"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
          <h3 class="text-xl font-bold mb-2">Definitions</h3>
          <ul id="definitions" class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300"></ul>
        </div>
        <div class="space-y-6">
          <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold mb-2">Examples</h3>
            <ul id="examples" class="space-y-2 text-gray-700 dark:text-gray-300"></ul>
          </div>
          <div class="word-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold mb-2">Synonyms</h3>
            <div id="synonyms" class="flex flex-wrap gap-2 text-primary-light dark:text-primary-dark"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>