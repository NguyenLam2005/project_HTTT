// Lấy các phần tử DOM cần thiết
var modalBody = document.querySelector('.modal-body');
var signUp = document.getElementById('sign-up-btn');
var signIn = document.getElementById('sign-in-btn');

// Ngăn modal bị tắt khi click vào bên trong modal body
modalBody.addEventListener('click', function(event) {
    event.stopPropagation(); // Ấn vào khung modal body sẽ không bị tắt
});

// Hiển thị form đăng nhập
function showSignIn() {
    document.getElementById('sign-in').style.display = 'block';
    document.getElementById('sign-up').style.display = 'none';
}

// Hiển thị form đăng ký
function showSignUp() {
    document.getElementById('sign-up').style.display = 'block';
    document.getElementById('sign-in').style.display = 'none';
}

// Hiển thị/ẩn mật khẩu trong form đăng ký
function showPassword() {
    var icon = document.querySelector('.sign-up-showpass .show-hide');
    passwords.forEach(function(password) {
        if (password.type == 'password') {
            icon.classList.replace('uil-eye', 'uil-eye-slash'); // Đổi icon
            password.type = 'text'; // Hiển thị mật khẩu
        } else {
            icon.classList.replace('uil-eye-slash', 'uil-eye'); // Đổi icon
            password.type = 'password'; // Ẩn mật khẩu
        }
    });
}

// Hiển thị/ẩn mật khẩu trong form đăng nhập
function showSignInPassword() {
    var icon = document.querySelector('.sign-in-showpass .show-hide');
    if (signInPassword.type == 'password') {
        icon.classList.replace('uil-eye-slash', 'uil-eye'); // Đổi icon
        signInPassword.type = 'text'; // Hiển thị mật khẩu
    } else {
        icon.classList.replace('uil-eye', 'uil-eye-slash'); // Đổi icon
        signInPassword.type = 'password'; // Ẩn mật khẩu
    }
}

// Tạo tài khoản
var userAccount = localStorage.getItem('userAccount');
if (userAccount) {
    userAccount = JSON.parse(userAccount);
} else {
    userAccount = [];
    console.warn('No user accounts found in localStorage.');
}
var email = document.getElementById('email');
var passwords = document.querySelectorAll('.password');
var myName = document.getElementById('user-name');

// Nếu chưa có tài khoản nào, tạo tài khoản mặc định
if (!userAccount) {
    userAccount = [
        {cartList: [], userName: 'Admin', userEmail: 'admin@gmail.com', userPassword: 'admin', userFullName: 'Admin', userPhone: '0123456789', userAddress: 'Admin', userDate: '20/10/2024', type: 'admin'},
        {cartList: [], userName: 'Random', userEmail: 'random@gmail.com', userPassword: 'random', userFullName: 'Random', userPhone: '0123456789', userAddress: 'Random', userDate: '20/11/2024', type: 'user'},
    ];
    localStorage.setItem('userAccount', JSON.stringify(userAccount)); // Lưu vào localStorage
}

// Kiểm tra email đã tồn tại chưa
function checkSameAccount(email) {
    for (var i = 0; i < userAccount.length; i++) {
        if (email == userAccount[i].userEmail) {
            return true; // Email đã tồn tại
        }
    }
    return false; // Email chưa tồn tại
}

// Tạo tài khoản mới
function createAccount() {
    var rePassword = document.getElementById('re-password');
    var password = document.getElementById('true-password');

    // Kiểm tra email đã tồn tại
    if (checkSameAccount(email.value)) {
        document.querySelector('.error.email').innerHTML = 'Email đã tồn tại!';
        return false;
    } else {
        document.querySelector('.error.email').innerHTML = '';
    }

    // Kiểm tra mật khẩu nhập lại có khớp không
    if (rePassword.value != password.value) {
        document.querySelector('.error.password').innerHTML = 'Mật khẩu không trùng khớp!';
        return false;
    } else {
        document.querySelector('.error.password').innerHTML = '';
        // Thêm tài khoản mới vào danh sách
        userAccount.push({cartList: [], userName: myName.value, userEmail: email.value, userPassword: password.value, userFullName: '', userPhone: '', userAddress: '', userDate: today, type: 'user'});
        localStorage.setItem('userAccount', JSON.stringify(userAccount)); // Lưu vào localStorage
        localStorage.setItem('isLogIn', 1); // Đánh dấu đã đăng nhập
        localStorage.setItem('userAccountIndex', userAccount.length - 1); // Lưu index của tài khoản
    }
}

// Kiểm tra thông tin đăng nhập
var signInEmail = document.getElementById('sign-in-email');
var signInPassword = document.getElementById('sign-in-password');

function checkLogIn() {
    if (userAccount != null) {
        for (var i = 0; i < userAccount.length; i++) {
            if (signInEmail.value == userAccount[i].userEmail && signInPassword.value == userAccount[i].userPassword) {
                localStorage.setItem('userAccountIndex', i); // Lưu index của tài khoản
                return true; // Đăng nhập thành công
            }
        }
    }
    return false; // Đăng nhập thất bại
}

// Xử lý đăng nhập
function LogIn() {
    if (checkLogIn()) {
        localStorage.setItem('isLogIn', 1); // Đánh dấu đã đăng nhập
        location.reload(); // Tải lại trang
    } else {
        showToast('fail', 'Thất bại!', 'Email hoặc mật khẩu không hợp lệ. Vui lòng kiểm tra lại!');
    }
}

// Xử lý đăng xuất
function LogOut() {
    localStorage.setItem('isLogIn', 0); // Đánh dấu chưa đăng nhập
    localStorage.setItem('userAccountIndex', ''); // Xóa index tài khoản
    window.location.href = 'index.html'; // Chuyển hướng về trang chủ
}

// Hiển thị nhóm người dùng (admin, user, hoặc chưa đăng nhập)
var noneUser = document.querySelector('.header__none-user');
var user =  document.querySelector('.header__user');
var admin = document.querySelector('.header__admin');
var index;

function showUserGroup(name, name1, name2) { 
    name.style.display = 'block'; // Hiển thị nhóm người dùng
    name1.style.display = 'none'; // Ẩn nhóm khác
    name2.style.display = 'none'; // Ẩn nhóm khác
}   

// Kiểm tra trạng thái đăng nhập
var isLogIn = localStorage.getItem('isLogIn');
if (isLogIn == 1) {
    index = JSON.parse(localStorage.getItem('userAccountIndex'));
    
    if (userAccount[index].type == 'admin') {
        showUserGroup(admin, noneUser, user); // Hiển thị giao diện admin
    } else {
        var changeUserName = document.querySelector('.header__user .header__user-name');
        changeUserName.innerHTML = userAccount[index].userName; // Hiển thị tên người dùng
        showUserGroup(user, noneUser, admin); // Hiển thị giao diện user
    }
} else {
    showUserGroup(noneUser, user, admin); // Hiển thị giao diện chưa đăng nhập
}