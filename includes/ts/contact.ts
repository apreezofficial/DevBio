document.getElementById('contactForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const form = e.target;
  const formMessage = document.getElementById('formMessage');
  formMessage.textContent = '';
  formMessage.className = '';

  // Simple client-side validation (HTML5 will also validate)
  const name = form.name.value.trim();
  const email = form.email.value.trim();
  const message = form.message.value.trim();

  if (!name || !email || !message) {
    formMessage.textContent = 'Please fill in all fields.';
    formMessage.className = 'text-red-600 dark:text-red-400';
    return;
  }

  formMessage.textContent = 'Sending...';
  formMessage.className = 'text-gray-700 dark:text-gray-300';

  try {
    const response = await fetch('/ajax/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ name, email, message })
    });

    const result = await response.json();

    if (result.status === 'success') {
      formMessage.textContent = result.message;
      formMessage.className = 'text-green-600 dark:text-green-400';
      form.reset();
    } else {
      formMessage.textContent = result.message || 'Something went wrong.';
      formMessage.className = 'text-red-600 dark:text-red-400';
    }
  } catch (error) {
    formMessage.textContent = 'An error occurred. Please try again later.';
    formMessage.className = 'text-red-600 dark:text-red-400';
  }
});