const inputs = document.querySelectorAll('.otp-input');
  const form = document.getElementById('otp-form');

  inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
      const val = input.value;

      // Allow only digits (0-9)
      if (!/^\d$/.test(val)) {
        input.value = '';
        return;
      }

      // Move to next input if not last
      if (val.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }

      // If all inputs filled, submit form
      const allFilled = [...inputs].every(i => i.value.length === 1);
      if (allFilled) {
        const code = [...inputs].map(i => i.value).join('');
        // Add hidden code input insidebthe  PHP form
        const hiddenCode = document.createElement('input');
        hiddenCode.type = 'hidden';
        hiddenCode.name = 'code';
        hiddenCode.value = code;
        form.appendChild(hiddenCode);

        // Added hidden verify_code input to trigger PHP check
        const verifyInput = document.createElement('input');
        verifyInput.type = 'hidden';
        verifyInput.name = 'verify_code';
        verifyInput.value = '1';
        form.appendChild(verifyInput);

        form.submit();
      }
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && index > 0) {
        inputs[index - 1].focus();
      }
    });

    input.addEventListener('paste', (e) => {
      e.preventDefault();
      const paste = e.clipboardData.getData('text').trim().slice(0, inputs.length);
      [...paste].forEach((char, i) => {
        if (/\d/.test(char) && inputs[i]) {
          inputs[i].value = char;
        }
      });
      // Focus next empty input or last input
      let focusIndex = paste.length < inputs.length ? paste.length : inputs.length -1;
      inputs[focusIndex].focus();
    });
  });

  // Auto focus first input on load
  inputs[0].focus();