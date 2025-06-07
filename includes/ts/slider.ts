 document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.testimonial-item');
    const dots = document.querySelectorAll('.testimonial-dot');
    let currentIndex = 0;

    function showTestimonial(index) {
      items.forEach((item, i) => {
        if (i === index) {
          item.classList.remove('opacity-0', 'pointer-events-none', 'hidden');
          item.classList.add('opacity-100', 'relative');
          dots[i].classList.add('opacity-100');
          dots[i].classList.remove('opacity-40');
        } else {
          item.classList.add('opacity-0', 'pointer-events-none', 'hidden');
          item.classList.remove('opacity-100', 'relative');
          dots[i].classList.remove('opacity-100');
          dots[i].classList.add('opacity-40');
        }
      });
      currentIndex = index;
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        showTestimonial(i);
      });
    });

    // Auto rotate every 6s
    setInterval(() => {
      let nextIndex = (currentIndex + 1) % items.length;
      showTestimonial(nextIndex);
    }, 6000);
  });
  
  