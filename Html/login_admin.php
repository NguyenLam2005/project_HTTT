<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Login</title>
    <link rel="stylesheet" href="../../CSS/admin/loginAD.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="login-ad-wrapper">
    <form id="admin-login-form">
        <h1>LOGIN ADMIN</h1>
        <div class="input-box-ad">
            <input type="text" class="admin-username" placeholder="Username" required>
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="input-box-ad">
            <input type="password" class="admin-password" placeholder="Password" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="error-msg-ad"></div>
        <button type="submit" class="login-ad-btn">Login</button>
    </form>
</div>

<script src="../../JS/admin/Login_admin_ajax.js"></script>
<script src="../../JS/admin/Logout_admin.js"></script>

</body>

</html>