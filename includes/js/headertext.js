document.addEventListener("DOMContentLoaded", () => {
  const elements = document.querySelectorAll('#headertext');

  elements.forEach(el => {
    const originalText = el.textContent.trim();
    el.textContent = "";

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          el.classList.add("visible");
          let i = 0;

          function typeLetter() {
            if (i < originalText.length) {
              el.textContent += originalText[i];
              i++;
              setTimeout(typeLetter, 35); // speed per letter
            }
          }

          typeLetter();
          obs.unobserve(el); // Only run once per element
        }
      });
    });

    observer.observe(el);
  });
});