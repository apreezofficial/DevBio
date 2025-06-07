document.addEventListener("DOMContentLoaded", () => {
    const questions = document.querySelectorAll(".faq-question");

    questions.forEach((btn) => {
      btn.addEventListener("click", () => {
        const answer = btn.nextElementSibling;
        const icon = btn.querySelector(".faq-icon");

        // Collapse other open ones
        document.querySelectorAll(".faq-answer").forEach((el) => {
          if (el !== answer) {
            el.style.maxHeight = null;
            el.previousElementSibling.querySelector(".faq-icon").style.transform = "rotate(0deg)";
          }
        });

        // Toggle current
        if (answer.style.maxHeight) {
          answer.style.maxHeight = null;
          icon.style.transform = "rotate(0deg)";
        } else {
          answer.style.maxHeight = answer.scrollHeight + "px";
          icon.style.transform = "rotate(180deg)";
        }
      });
    });
  });