<!DOCTYPE html>
<html lang="vi">

<head>
    <title>HighTech</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/logo-icon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="Css/grid.css">
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="Css/base.css">
    <link rel="stylesheet" href="Css/responsive.css">
</head>

<body>
    <div id="main">
        <!-- Header -->
        <header class="header"> 
            <div class="grid wide">
                <div class="header__navbar">
                    <a href="index.html" class="header__logo">
                        <img src="./img/logo.png" class="header__logo-img" alt="">
                    </a>
                    
                    <ul class="header__navbar-list">
                        <li class="header__navbar-item">
                            <a href="index.html?iphone" class="header__navbar-item-link">iPhone</a>
                        </li>
                        <li class="header__navbar-item">
                            <a href="index.html?ipad" class="header__navbar-item-link">iPad</a>
                        </li>
                        <li class="header__navbar-item">
                            <a href="index.html?macbook" class="header__navbar-item-link">MacBook</a>
                        </li>
                        <li class="header__navbar-item">
                            <a href="index.html?apple-watch" class="header__navbar-item-link">AppleWatch</a>
                        </li>
                    </ul>
    
                    <div class="header__right-box">
                        <div class="header__search" onclick="document.getElementById('search-bar').style.display='flex'">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="header__cart" onclick="showCartPage()">
                            <span class="header__cart-icon material-symbols-rounded">shopping_bag</span>
                            <span class="header__cart-quantity"></span>
                        </div>

                        <div class="header__user-group">
                            <div class="header__none-user" onclick="document.getElementById('account__modal').style.display='flex'">
                                <i class="fa-solid fa-user"></i>
                            </div>
    
                            <div class="header__user">
                                <span class="header__user-name">User</span>
                                <div class="header__group-menu">
                                    <a href="index.html?order" class="header__user-order" onclick="showOrderPage()">Đơn hàng của bạn</a>
                                    <div id="log-out" class="header__log-out" onclick="LogOut()">Đăng xuất</div>
                                </div>
                            </div>
    
                            <!-- <div class="header__admin">
                                <span>Admin</span>
                                <div class="header__group-menu">
                                    <div class="header__admin-interface" onclick="ToAdminPage()">Trang quản trị</div>
                                    <a href="index.html?order" class="header__user-order" onclick="showOrderPage()">Đơn hàng của bạn</a>
                                    <div id="log-out" class="header__log-out" onclick="LogOut()">Đăng xuất</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Mobile & Tablet-->
                        <div class="mobile__menu">
                            <span class="mobile__menu-btn">
                                <i class="fa-solid fa-bars"></i>
                            </span>       
                            
                            <div class="mobile__list scrollbar">
                                <span class="close">
                                    <i class="close-btn fa-solid fa-xmark"></i>
                                </span>

                               <div class="mobile__header">
                                    <img src="./img/logo.png" alt="" class="mobile__header-logo">
                               </div>

                               <div class="hello-user">
                                    <span class="material-symbols-rounded">waving_hand</span>
                                    <p></p>
                               </div>

                                <div class="mobile__box user-account">
                                    <h3 class="mobile__box-header">TÀI KHOẢN</h3>
                                    <ul class="header__navbar-list">
                                        <li class="header__navbar-item">
                                            <span class="material-symbols-rounded mobile-icon">person</span>
                                            <div id="mobile-sign-up" class="header__navbar-item-link">Đăng ký</div>
                                        </li>
                                        <li class="header__navbar-item">
                                            <span class="material-symbols-rounded mobile-icon">login</span>
                                            <div id="mobile-sign-in" class="header__navbar-item-link">Đăng nhập</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mobile__box user-info">
                                        <h3 class="mobile__box-header">THÔNG TIN TÀI KHOẢN</h3>
                                        <ul class="header__navbar-list">
                                            <li class="header__navbar-item admin-interface">
                                                <span class="material-symbols-rounded mobile-icon">settings</span>
                                                <a href="admin.html" class="header__navbar-item-link">Trang quản trị</a>
                                            </li>
                                            <li class="header__navbar-item mobile-cart">
                                                <span class="header__cart-icon material-symbols-rounded mobile-icon">shopping_bag</span>
                                                <span class="header__cart-quantity mobile-cart-quantity"></span>
                                                <a href="index.html?cart" class="header__navbar-item-link">Giỏ hàng của bạn</a>
                                            </li>
                                            <li class="header__navbar-item">
                                                <span class="material-symbols-rounded mobile-icon">assignment</span>
                                                <a href="index.html?order" class="header__navbar-item-link">Đơn hàng của bạn</a>
                                            </li>
                                            <li class="header__navbar-item">
                                                <span class="material-symbols-rounded mobile-icon">logout</span>
                                                <div id="log-out" class="header__navbar-item-link" onclick="LogOut()">Đăng xuất</div>
                                            </li>
                                        </ul>
                                </div>
                                <div class="mobile__box">
                                    <h3 class="mobile__box-header">CATEGORIES</h3>
                                    <ul class="header__navbar-list">
                                        <li class="header__navbar-item">
                                            <span class="material-symbols-rounded mobile-icon">phone_android</span>
                                            <a href="index.html?iphone" class="header__navbar-item-link">iPhone</a>
                                        </li>
                                        <li class="header__navbar-item">
                                            <span class="material-symbols-rounded mobile-icon">tablet_mac</span>
                                            <a href="index.html?ipad" class="header__navbar-item-link">iPad</a>
                                        </li>
                                        <li class="header__navbar-item">
                                            <span class="material-symbols-rounded mobile-icon">laptop_mac</span>
                                            <a href="index.html?macbook" class="header__navbar-item-link">MacBook</a>
                                        </li>
                                        <li class="header__navbar-item">
                                            <span class="material-symbols-rounded mobile-icon">watch</span>
                                            <a href="index.html?apple-watch" class="header__navbar-item-link">AppleWatch</a>
                                        </li>
                                    </ul>
                                </div>                               
                            </div>
                        </div>
                        
                        <div class="mobile-overlay"></div>
                        <!--  -->
                    </div>
                    
                    <div id="search-bar" class="header__searchbar">
                        <div class="header__searcbar-container">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input id="search-info" type="text" class="header__search-input" placeholder="Nhập tên sản phẩm">
                            <span onclick="document.getElementById('search-bar').style.display='none'" class="header__searchbar-close">
                                <i class="fa-solid fa-xmark"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

    </div>
</body>