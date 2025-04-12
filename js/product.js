// Add this block at the top of the file
if (typeof localStorage === 'undefined' || localStorage === null) {
    const { LocalStorage } = require('node-localstorage');
    global.localStorage = new LocalStorage('./scratch');
}

var products = JSON.parse(localStorage.getItem('products'));
if (!products || products.length === 0) {
    products = [
        { id: 'watchmale01', category: 'watch-male', name: 'Watch Male 1', img: './img/product/watchmale/watchmale01.png', currentPrice: '36.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale02', category: 'watch-male', name: 'Watch Male 2', img: './img/product/watchmale/watchmale02.png', currentPrice: '35.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale03', category: 'watch-male', name: 'watch-male-3', img: './img/product/watchmale/watchmale03.png', currentPrice: '34.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale04', category: 'watch-male', name: 'watch-male-4', img: './img/product/watchmale/watchmale04.png', currentPrice: '33.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale05', category: 'watch-male', name: 'watch-male-5', img: './img/product/watchmale/watchmale05.png', currentPrice: '32.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale06', category: 'watch-male', name: 'watch-male-6', img: './img/product/watchmale/watchmale06.png', currentPrice: '31.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale07', category: 'watch-male', name: 'watch-male-7', img: './img/product/watchmale/watchmale07.png', currentPrice: '30.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale08', category: 'watch-male', name: 'watch-male-8', img: './img/product/watchmale/watchmale08.png', currentPrice: '29.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale09', category: 'watch-male', name: 'watch-male-9', img: './img/product/watchmale/watchmale09.png', currentPrice: '28.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale10', category: 'watch-male', name: 'watch-male-10', img: './img/product/watchmale/watchmale10.png', currentPrice: '27.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale11', category: 'watch-male', name: 'watch-male-11', img: './img/product/watchmale/watchmale11.png', currentPrice: '26.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale12', category: 'watch-male', name: 'watch-male-12', img: './img/product/watchmale/watchmale12.png', currentPrice: '25.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale13', category: 'watch-male', name: 'watch-male-13', img: './img/product/watchmale/watchmale13.png', currentPrice: '24.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale14', category: 'watch-male', name: 'watch-male-14', img: './img/product/watchmale/watchmale14.png', currentPrice: '23.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale15', category: 'watch-male', name: 'watch-male-15', img: './img/product/watchmale/watchmale15.png', currentPrice: '22.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },
        { id: 'watchmale16', category: 'watch-male', name: 'watch-male-16', img: './img/product/watchmale/watchmale16.png', currentPrice: '21.990.000₫', oldPrice: '', detailCategory: 'watch-male', state: 'new' },

        { id: 'watchfemale01', category: 'watch-female', name: 'Watch Female 1', img: './img/product/watchfemale/watchfemale01.png', currentPrice: '26.290.000₫', oldPrice: '28.990.000₫', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale02', category: 'watch-female', name: 'watch-female-2', img: './img/product/watchfemale/watchfemale02.png', currentPrice: '25.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale03', category: 'watch-female', name: 'watch-female-3', img: './img/product/watchfemale/watchfemale03.png', currentPrice: '24.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale04', category: 'watch-female', name: 'watch-female-4', img: './img/product/watchfemale/watchfemale04.png', currentPrice: '23.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale05', category: 'watch-female', name: 'watch-female-5', img: './img/product/watchfemale/watchfemale05.png', currentPrice: '22.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale06', category: 'watch-female', name: 'watch-female-6', img: './img/product/watchfemale/watchfemale06.png', currentPrice: '21.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale07', category: 'watch-female', name: 'watch-female-7', img: './img/product/watchfemale/watchfemale07.png', currentPrice: '20.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale08', category: 'watch-female', name: 'watch-female-8', img: './img/product/watchfemale/watchfemale08.png', currentPrice: '19.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale09', category: 'watch-female', name: 'watch-female-9', img: './img/product/watchfemale/watchfemale09.png', currentPrice: '18.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale10', category: 'watch-female', name: 'watch-female-10', img: './img/product/watchfemale/watchfemale10.png', currentPrice: '17.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale11', category: 'watch-female', name: 'watch-female-11', img: './img/product/watchfemale/watchfemale11.png', currentPrice: '16.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale12', category: 'watch-female', name: 'watch-female-12', img: './img/product/watchfemale/watchfemale12.png', currentPrice: '15.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale13', category: 'watch-female', name: 'watch-female-13', img: './img/product/watchfemale/watchfemale13.png', currentPrice: '14.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale14', category: 'watch-female', name: 'watch-female-14', img: './img/product/watchfemale/watchfemale14.png', currentPrice: '13.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale15', category: 'watch-female', name: 'watch-female-15', img: './img/product/watchfemale/watchfemale15.png', currentPrice: '12.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },
        { id: 'watchfemale16', category: 'watch-female', name: 'watch-female-16', img: './img/product/watchfemale/watchfemale16.png', currentPrice: '11.290.000₫', oldPrice: '', detailCategory: 'watch-female', state: 'new' },

        { id: 'watchwall01', category: 'watch-wall', name: 'Watch Wall 1', img: './img/product/watchwall/watchwall01.png', currentPrice: '35.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall02', category: 'watch-wall', name: 'watch-wall-2', img: './img/product/watchwall/watchwall02.png', currentPrice: '34.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall03', category: 'watch-wall', name: 'watch-wall-3', img: './img/product/watchwall/watchwall03.png', currentPrice: '33.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall04', category: 'watch-wall', name: 'watch-wall-4', img: './img/product/watchwall/watchwall04.png', currentPrice: '32.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall05', category: 'watch-wall', name: 'watch-wall-5', img: './img/product/watchwall/watchwall05.png', currentPrice: '31.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall06', category: 'watch-wall', name: 'watch-wall-6', img: './img/product/watchwall/watchwall06.png', currentPrice: '30.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall07', category: 'watch-wall', name: 'watch-wall-7', img: './img/product/watchwall/watchwall07.png', currentPrice: '29.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall08', category: 'watch-wall', name: 'watch-wall-8', img: './img/product/watchwall/watchwall08.png', currentPrice: '28.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall09', category: 'watch-wall', name: 'watch-wall-9', img: './img/product/watchwall/watchwall09.png', currentPrice: '27.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall10', category: 'watch-wall', name: 'watch-wall-10', img: './img/product/watchwall/watchwall10.png', currentPrice: '26.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall11', category: 'watch-wall', name: 'watch-wall-11', img: './img/product/watchwall/watchwall11.png', currentPrice: '25.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall12', category: 'watch-wall', name: 'watch-wall-12', img: './img/product/watchwall/watchwall12.png', currentPrice: '24.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall13', category: 'watch-wall', name: 'watch-wall-13', img: './img/product/watchwall/watchwall13.png', currentPrice: '23.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall14', category: 'watch-wall', name: 'watch-wall-14', img: './img/product/watchwall/watchwall14.png', currentPrice: '22.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall15', category: 'watch-wall', name: 'watch-wall-15', img: './img/product/watchwall/watchwall15.png', currentPrice: '21.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' },
        { id: 'watchwall16', category: 'watch-wall', name: 'watch-wall-16', img: './img/product/watchwall/watchwall16.png', currentPrice: '20.990.000₫', oldPrice: '', detailCategory: 'watch-wall', state: 'new' }
    ];
    localStorage.setItem('products', JSON.stringify(products));
}

function htmlProduct(product) {
    return `
        <div class="col l-3 m-4 c-6">
            <div class="product__item">
                <a href="index.html?category=${product.category.toLowerCase()}&name=${product.name.replaceAll(' ', '-').toLowerCase()}" class="product__item-link">
                    <p class="${product.state === 'new' ? 'product__item-new-label' : 'no-label'}">${product.state === 'new' ? 'Mới' : ''}</p>
                    <img src="${product.img}" class="product__item-img" alt="${product.name}">
                    <h3 class="product__item-name">${product.name}</h3>
                    <div class="product__item-price">
                        <p class="product__item-current-price">${product.currentPrice}</p>
                        <p class="product__item-old-price">${product.oldPrice || ''}</p>
                    </div>
                </a>
            </div>
        </div>
    `;
}

function getNewLabel() {
    for (var i = 0; i < products.length; i++) {
        products[i]['label'] = products[i].state === 'new' ? 'product__item-new-label' : 'no-label';
    }
}

getNewLabel();

function showCurrentNavbar(str) {
    var currentNavbar = document.querySelectorAll('.header__navbar-item-link');
    for (var i = 0; i < currentNavbar.length; i++) {
        currentNavbar[i].classList.remove('header__navbar-item-link--active');
    }
    for (var i = 0; i < currentNavbar.length; i++) {
        if (currentNavbar[i].innerText.toLowerCase() == str.replaceAll('-', '').toLowerCase()) {
            currentNavbar[i].classList.add('header__navbar-item-link--active');
            break;
        }
    }
}

function showCurrentFilter(name) {
    var currentFilter = document.querySelectorAll('.product__filter-item-btn');
    for (var i = 0; i < currentFilter.length; i++) {
        currentFilter[i].classList.remove('product__filter-item-btn--active');
    }
    for (var i = 0; i < currentFilter.length; i++) {
        if (currentFilter[i].innerText == name) {
            currentFilter[i].classList.add('product__filter-item-btn--active');
            break;
        }
    }
}

function showFilter(name) {
    var productArray = products.filter(function(product) {
        return product.category.toLowerCase().replaceAll(' ', '-') === name.toLowerCase();
    });
    var filterArray = productArray.map(function(product) {
        return product.detailCategory;
    });
    filterArray = [...new Set(filterArray)];
    var s = `
        <li class="product__filter-item">
            <button class="product__filter-item-btn product__filter-item-btn--active" onclick="showProduct(1)">Tất cả</button>
        </li>
    `;

    var html = filterArray.map(function(filter) {
        return `
            <li class="product__filter-item">
                <button class="product__filter-item-btn" onclick="showFilterProduct('${name}', '${filter}', 1)">${filter}</button>
            </li>
        `;
    });
    s += html.join('');
    document.querySelector('.product__filter').innerHTML = s;
}

function showFilterProduct(category, filterName, start) {
    var productArr = products.filter(function(product) {
        return product.category.toLowerCase().replaceAll(' ', '-') == category.toLowerCase();
    });
    var filterArr = productArr.filter(function(product) {
        return product.detailCategory.toLowerCase() == filterName.toLowerCase();
    })
    localStorage.setItem('filterName', filterName);

    category = ReName(category);
    showCurrentFilter(filterName);
    showFilterPagination(filterArr, category, filterName);
    showCurrentPage(start);

    var filter = document.querySelectorAll('.product__filter-item-btn');
    var arr;
    for (var i = 0; i < filter.length; i++) {
        if (filter[i].innerText == filterName) {
            arr = createTempArray(start, filterArr);
            break;
        }
    }
    document.getElementById('show-product').innerHTML = arr.join('');
    document.querySelector('.product__header').scrollIntoView();

    Pagination();
}

function showProduct(start) {
    document.querySelector('.cart').style.display = 'none';
    document.querySelector('.order').style.display = 'none';

    var category = getCategory(); // Ensure getCategory() returns the correct category
    var productArray = category
        ? products.filter(product => product.category.toLowerCase() === category.toLowerCase())
        : products;

    if (!productArray.length) {
        document.getElementById('show-product').innerHTML = '<p>No products available.</p>';
        return;
    }

    var paginatedProducts = createTempArray(start, productArray); // Ensure createTempArray works correctly
    document.getElementById('show-product').innerHTML = paginatedProducts.join('');
    showPagination(productArray); // Ensure showPagination is defined and functional
}

// Remove admin-specific product rendering
function createTempArray(start, array) {
    var tmp = [], cnt = 0;
    start = (start - 1) * productPerPage;
    for (var i = start; i < array.length; i++) {
        tmp.push(htmlProduct(array[i]));
        cnt++;
        if (cnt == productPerPage) 
            break;
    }
    return tmp;
}

// Remove admin-specific pagination logic
function showPagination(array) {
    if (array.length > productPerPage) {
        var pageNumber = Math.ceil(array.length / productPerPage);
        localStorage.setItem('totalPage', pageNumber);
        var s = '';
        for (var i = 1; i <= pageNumber; i++) {
            s += `
                <div class="pagination-item" onclick="showProduct(${i})">
                    <span value="${i}" class="pagination-item__page">${i}</span>
                </div>
            `;
        }
        document.querySelector('.product__pagination-list').innerHTML = s;
    } else {
        localStorage.setItem('totalPage', 0);
        document.querySelector('.product__pagination-list').innerHTML = '';
    }
}

//Product Detail
function showProductDetail() {
    document.querySelector('.cart').style.display = 'none';
    document.querySelector('.order').style.display = 'none';

    var urlParams = new URLSearchParams(window.location.search);
    var category = urlParams.get('category');
    var name = urlParams.get('name');

    // Ensure category and name are properly formatted
    if (!category || !name) {
        document.getElementById('show-product-detail').innerHTML = '<p>Invalid product details!</p>';
        return;
    }

    var detailProduct = products.find(function(product) {
        return (
            product.category.toLowerCase() === category.toLowerCase() &&
            product.name.replaceAll(' ', '-').toLowerCase() === name.toLowerCase()
        );
    });

    if (!detailProduct) {
        document.getElementById('show-product-detail').innerHTML = '<p>Product not found!</p>';
        return;
    }

    var html = `
        <div class="col l-6 m-12 c-12">
            <div class="product__detail-img-box">
                <img src="${detailProduct.img}" alt="" class="product__detail-img">
            </div>
        </div>
        <div class="col l-6 m-12 c-12">
            <div class="product__detail-info">
                <span class="product__detail-name">${detailProduct.name}</span>
                <div class="product__detail-price">
                    <p class="product__detail-current-price">${detailProduct.currentPrice}</p>
                    <p class="product__detail-old-price">${detailProduct.oldPrice || ''}</p>
                </div>
                <div class="product__detail-policy">
                    <div class="product__detail-policy-item">
                        <i class="uil uil-box"></i>
                        <span class="product__detail-policy-text">Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cây lấy sim, Cáp Lightning - Type C</span>
                    </div>
                    <div class="product__detail-policy-item">
                        <i class="uil uil-sync"></i>
                        <span class="product__detail-policy-text">Hư gì đổi nấy trong 12 tháng</span>
                    </div>
                    <div class="product__detail-policy-item">
                        <i class="uil uil-shield-check"></i>
                        <span class="product__detail-policy-text">Bảo hành chính hãng 2 năm</span>
                    </div>
                    <div class="product__detail-policy-item">
                        <i class="uil uil-truck"></i>
                        <span class="product__detail-policy-text">Giao hàng nhanh toàn quốc</span>
                    </div>
                    <div class="product__detail-policy-item">
                        <i class="uil uil-phone"></i>
                        <span class="product__detail-policy-text">
                            Tổng đài:
                            <a href="tel:0976124506" class="product__detail-phone">0976124506</a>                                      
                        </span>
                    </div>
                </div>
                <div class="product__detail-pay">
                    <button class="product__detail-add-cart">Thêm vào giỏ</button>
                    <button class="product__detail-buy">Mua ngay</button>
                </div>
            </div>
        </div>
    `;

    document.getElementById('body').style.display = 'none';
    document.getElementById('show-product-detail').innerHTML = html;

    haveToLogin();
    addToCart();
}

function haveToLogin() {
    var buyBtn = document.querySelector('.product__detail-buy');
    var notUser = document.querySelector('.header__none-user');

    buyBtn.addEventListener('click', function() {
        if (notUser.style.display == 'block') {
            showToast('fail', 'Cảnh báo!', 'Vui lòng đăng nhập để mua sản phẩm!');
            setTimeout(function() {
                document.getElementById('account__modal').style.display = 'flex';
            }, 1000);
        } else {
            getCurrentProduct();
            window.location.href = 'index.html?cart';
        }
    });
}

function getCurrentProduct() {
    var url = window.location.href;
    var s = url.split('?')[2];

    var userAccount = JSON.parse(localStorage.getItem('userAccount'));
    var index = localStorage.userAccountIndex;
    var cartProduct = products.find(function(product) {
        return product.name.replace('"', '').replaceAll(' ', '-') == s;
    })

    userAccount[index].cartList.push(cartProduct);
    localStorage.setItem('userAccount', JSON.stringify(userAccount));
}