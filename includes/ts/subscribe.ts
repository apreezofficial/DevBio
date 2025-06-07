const form = document.getElementById('subscribeForm');
    const emailInput = document.getElementById('email');
    const message = document.getElementById('subscribeMessage');
    const submitButton = document.getElementById('subscribeButton');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = emailInput.value.trim();

      if (!email) {
        message.textContent = 'Please enter your email address.';
        message.className = 'mt-3 text-xs text-red-500 dark:text-red-400';
        emailInput.focus();
        return;
      }

      // Simple email pattern validation (optional)
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        message.textContent = 'Please enter a valid email address.';
        message.className = 'mt-3 text-xs text-red-500 dark:text-red-400';
        emailInput.focus();
        return;
      }

      message.textContent = 'Submitting...';
      message.className = 'mt-3 text-xs text-gray-500 dark:text-gray-400';

      submitButton.disabled = true;
      submitButton.textContent = 'Submitting...';

      try {
        const response = await fetch('/ajax/subscribe.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ email })
        });

        const result = await response.json();

        if (result.status === 'success') {
          message.textContent = result.message || 'Subscription successful!';
          message.className = 'mt-3 text-xs text-green-600 dark:text-green-400';
          form.reset();
        } else {
          message.textContent = result.message || 'Subscription failed. Please try again.';
          message.className = 'mt-3 text-xs text-red-500 dark:text-red-400';
        }
      } catch (error) {
        message.textContent = 'An error occurred. Please try again later.';
        message.className = 'mt-3 text-xs text-red-500 dark:text-red-400';
      } finally {
        submitButton.disabled = false;
        submitButton.textContent = 'Subscribe';
      }
    });