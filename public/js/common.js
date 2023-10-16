document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");

  togglePassword.addEventListener("click", function () {
    // Toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Toggle the eye icon
    this.classList.toggle('bi-eye');
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#togglePasswordConfirm");
  const password = document.querySelector("#password-confirm");

  togglePassword.addEventListener("click", function () {
    // Toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Toggle the eye icon
    this.classList.toggle('bi-eye');
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#toggleNewPassword");
  const password = document.querySelector("#new_password");

  togglePassword.addEventListener("click", function () {
    // Toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Toggle the eye icon
    this.classList.toggle('bi-eye');
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#toggleNewPasswordConfirm");
  const password = document.querySelector("#new_password_confirmation");

  togglePassword.addEventListener("click", function () {
    // Toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Toggle the eye icon
    this.classList.toggle('bi-eye');
  });
});