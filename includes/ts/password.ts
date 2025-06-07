 const passwordInput = document.getElementById("password-input");
  const togglePasswordBtn = document.getElementById("toggle-password");
  // Toggle password visibility
  togglePasswordBtn.addEventListener("click", () => {
    const type = passwordInput.type === "password" ? "text" : "password";
    passwordInput.type = type;
    togglePasswordBtn.querySelector("i").classList.toggle("fa-eye");
    togglePasswordBtn.querySelector("i").classList.toggle("fa-eye-slash");
  });