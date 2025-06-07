 const counters = document.querySelectorAll('.counter');
  let started = false;

  function runCounters() {
    const duration = 700; // total animation time in ms
    const startTime = performance.now();

    function update() {
      const now = performance.now();
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1); // from 0 to 1

      counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        // Calculate current count based on progress
        counter.innerText = Math.floor(progress * target);
      });

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        // To ensure that all counters show their exact target value at the end
        counters.forEach(counter => {
          counter.innerText = counter.getAttribute('data-target');
        });
      }
    }

    requestAnimationFrame(update);
  }

  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return rect.top <= (window.innerHeight || document.documentElement.clientHeight);
  }

  window.addEventListener('scroll', () => {
    const statsSection = document.getElementById('stats');
    if (!started && isInViewport(statsSection)) {
      started = true;
      runCounters();
    }
  });