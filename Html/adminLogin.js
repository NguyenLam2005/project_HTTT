function openModal() {
    const modal = document.getElementById("modal");
    modal.style.display = "flex";
  
    // Ẩn tất cả modal-child
    const children = modal.querySelectorAll(".modal-child");
    children.forEach(child => child.classList.add("hide"));
  
    // Hiện modal đăng nhập
    const loginForm = modal.querySelector(".modal-login");
    if (loginForm) {
      loginForm.classList.remove("hide");
    }
}
  
function closeModal() {
    document.getElementById("modal").style.display = "none";
}

function outsideClick(event) {
    if (event.target.id === "modal") {
      closeModal();
    }
}

function showError(input, message) {
    var errorDiv = input.parentNode.querySelector(".error-msg");
    var symbolError = '<i class="error-symbol fa-solid fa-circle-xmark"></i>';
    errorDiv.innerHTML = symbolError + " " + message;
    errorDiv.classList.add("show");
}

function clearErrors(form) {
    form.querySelectorAll(".error-msg").forEach((errorDiv) => {
        errorDiv.innerHTML = "";
        errorDiv.classList.remove("show");
    });
}

// document.querySelector(".login-btn").addEventListener("click", function() {
//     var userName = $('.lg-adminName').val();
//     var passWord = $('.lg-password').val();

//     $.ajax({
//         type: "POST",
//         url: 
//     });
// });
  