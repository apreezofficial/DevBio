 const items = document.querySelectorAll('.animate-slide img');
  function adjustVisibility() {
    const container = document.querySelector('.animate-slide');
    const containerRect = container.getBoundingClientRect();
    items.forEach((item) => {
      const rect = item.getBoundingClientRect();
      const center = containerRect.left + containerRect.width / 2;
      const distance = Math.abs(rect.left + rect.width / 2 - center);

      const maxDistance = containerRect.width / 2;
      const visibility = 1 - Math.min(distance / maxDistance, 1);
      item.style.opacity = 0.4 + 0.6 * visibility;
      item.style.transform = `scale(${0.95 + 0.05 * visibility})`;
    });
  }
  adjustVisibility();
  setInterval(adjustVisibility, 100);