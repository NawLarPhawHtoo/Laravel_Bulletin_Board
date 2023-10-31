document.addEventListener("DOMContentLoaded", function () {
  const elements = [
    { toggleId: "togglePassword", passwordId: "password" },
    { toggleId: "togglePasswordConfirm", passwordId: "password-confirm" },
    { toggleId: "toggleNewPassword", passwordId: "new_password" },
    { toggleId: "toggleNewPasswordConfirm", passwordId: "new_password_confirmation" },
  ];

  elements.forEach((element) => {
    const togglePassword = document.querySelector(`#${element.toggleId}`);
    const password = document.querySelector(`#${element.passwordId}`);

    if (togglePassword && password) {
      togglePassword.addEventListener("click", function () {
        // Toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Toggle the eye icon
        this.classList.toggle('bi-eye');
      });
    }
  });
});


// document.addEventListener("DOMContentLoaded", function() {
//   var today = new Date().toISOString().split('T')[0];
//   document.getElementById("dob").setAttribute("max", today);
// });
document.addEventListener("DOMContentLoaded", function () {
  var today = new Date().toISOString().split('T')[0];
  var dobElement = document.getElementById("dob");
  if (dobElement) {
    dobElement.setAttribute("max", today);
  }
});

function openDetailModal(id) {
  $("#detailModal_" + id).modal("show");
}

function openDeleteModal(id, action) {
  $("#deleteModal").modal("show");
  // Set the action attribute for the form in the delete modal
  $("#deleteModal form").attr("action", action);
}
