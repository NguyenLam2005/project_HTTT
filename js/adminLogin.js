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


$(document).on("submit", ".adminLogin-form", function(event) {
    event.preventDefault();
    var adminName = $('.lg-adminName').val();
    var passWord = $('.lg-adminPassword').val();

    $.ajax({
        type: "POST",
        url: "../PHP/adminLogin.php",
        data: {
            "adminLogin-form": true,
            "lg-adminName": adminName,
            "lg-adminPassword": passWord
        },
        dataType: "json",
        success: function (response) {
            var loginForm = document.querySelector(".adminLogin-form");
            clearErrors(loginForm);

            if (response.status === "error") {
                if (response.message === "Không tồn tại người dùng") {
                    var adminName = document.querySelector(".lg-adminName");
                    showError(adminName, response.message)
                    adminName.focus();
                }
                else if (response.message === "Sai mật khẩu") {
                    var passWord = document.querySelector(".lg-adminPassword");
                    showError(passWord, response.message)
                    passWord.focus();
                }
                return;
            }
            localStorage.setItem("adminJustLoggedIn", "true");
            location.reload();
        }
        
    });
});


window.addEventListener("DOMContentLoaded", function () {
    const isLoggedIn = localStorage.getItem("adminJustLoggedIn");

    const loginBtn = document.querySelector(".admin-login");
    const greetingBox = document.querySelector(".greeting-box");
    const adminNameText = document.querySelector(".admin-name");

    if (isLoggedIn === "true") {
        loginBtn.style.display = "none";
        greetingBox.style.display = "flex";
    } else {
        loginBtn.style.display = "inline";
        greetingBox.style.display = "none";
    }
});

function logout(){
    localStorage.removeItem("adminJustLoggedIn");
    location.reload();
}