 <!-- Script.php -->
 
   <script>
    
    const profileToggle = document.getElementById('profile-toggle');
    const profileMenu = document.getElementById('profile-menu');

    profileToggle.addEventListener('click', () => {
      profileMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
      if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add('hidden');
      }
    });
  </script>
  <script>
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const resultContainer = document.getElementById('resultContainer');
    const loadingShimmer = document.getElementById('loadingShimmer');
    const infoText = document.getElementById('infoText');
    const wordEl = document.getElementById('word');
    const phoneticEl = document.getElementById('phonetic');
    const partOfSpeechEl = document.getElementById('partOfSpeech');
    const definitionsEl = document.getElementById('definitions');
    const examplesEl = document.getElementById('examples');
    const synonymsEl = document.getElementById('synonyms');
    const speakBtn = document.getElementById('speakBtn');

    // Preload audio for faster response
    let audio = new Audio();
    
    function fetchWord(word) {
      if (!word) return;

      // Show loading shimmer and hide results
      loadingShimmer.classList.remove("hidden");
      resultContainer.classList.add("hidden");
      
      // Remove "Searching for..." text after a short delay
      setTimeout(() => {
        infoText.textContent = "";
      }, 500);

      fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${word}`)
        .then(res => res.json())
        .then(data => {
          if (data.title === "No Definitions Found") {
            Swal.fire({
    icon: 'warning',
    toast: true,
    text: "No word found",
    background: 'var(--swal-bg)',
    color: 'var(--swal-text)',
    iconColor: 'var(--swal-icon)',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    progressBarColor: 'var(--swal-progress)',
    position: 'top',
    width: '400px',
    padding: '0.75rem',
    backdrop: false
});
           setTimeout(() => {
        loadingShimmer.classList.add("hidden");
      }, 1000); 
            return;
          }

          loadingShimmer.classList.add("hidden");
          resultContainer.classList.remove("hidden");

          const entry = data[0];
          wordEl.textContent = entry.word;
          phoneticEl.textContent = entry.phonetics[0]?.text || '';
          partOfSpeechEl.textContent = entry.meanings[0]?.partOfSpeech || '';

          definitionsEl.innerHTML = '';
          entry.meanings[0]?.definitions?.forEach(def => {
            definitionsEl.innerHTML += `<li>${def.definition}</li>`;
          });

          examplesEl.innerHTML = '';
          entry.meanings[0]?.definitions?.forEach(def => {
            if (def.example) {
              examplesEl.innerHTML += `<li>"${def.example}"</li>`;
            }else {
            examplesEl.innerHTML = "<p>No Examples found.</p>";
          }
          });

          synonymsEl.innerHTML = '';
          const synonyms = entry.meanings[0]?.definitions[0]?.synonyms || [];
          if (synonyms.length) {
            synonyms.forEach(s => {
              synonymsEl.innerHTML += `<span class="bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">${s}</span>`;
            });
          } else {
            synonymsEl.innerHTML = "<p>No synonyms found.</p>";
          }

          // Pre-fetch audio for faster playback
          const audioUrl = entry.phonetics[0]?.audio;
          if (audioUrl) {
            audio.src = audioUrl;
            audio.load();
          }

          speakBtn.onclick = () => {
            if (audioUrl) {
              audio.play().catch(e => {
                // Fallback to speech synthesis if audio playback fails
                const utterance = new SpeechSynthesisUtterance(entry.word);
                speechSynthesis.speak(utterance);
              });
            } else {
              const utterance = new SpeechSynthesisUtterance(entry.word);
              speechSynthesis.speak(utterance);
            }
          };
        })
        .catch(err => {
          Swal.fire({
    icon: 'warning',
    text: "Error Loading Word Info",
    toast: true,
    background: 'var(--swal-bg)',
    color: 'var(--swal-text)',
    iconColor: 'var(--swal-icon)',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    progressBarColor: 'var(--swal-progress)',
    position: 'top',
    width: '400px',
    padding: '0.75rem',
    backdrop: false
});
        });
        setTimeout(() => {
        loadingShimmer.classList.add("hidden");
      }, 1000); 
    }

    searchBtn.onclick = () => {
      const word = searchInput.value.trim();
      if (word) {
        infoText.textContent = `Searching for: ${word}`;
        window.location.href = `?word=${encodeURIComponent(word)}`;
      }
    };

    searchInput.addEventListener("keypress", e => {
      if (e.key === "Enter") searchBtn.click();
    });

    document.getElementById('themeToggle').addEventListener('click', () => {
      const root = document.documentElement;
      const isDark = root.classList.toggle('dark');
      document.cookie = `darkMode=${isDark}; path=/; max-age=31536000`;
      document.getElementById('themeToggle').innerHTML = `<i class="fas ${isDark ? 'fa-sun' : 'fa-moon'}"></i>`;
    });

    // Load word on page load if passed via PHP
    const initialWord = "<?php echo $default_word; ?>";
    if (initialWord) fetchWord(initialWord);
  </script>