var searchProduct = [];
var search = document.getElementById('search-info');
var products = JSON.parse(localStorage.getItem('products'));

getNewLabel();
function getNewLabel() {
    for (var i = 0; i < products.length; i++) {
        if (products[i].state == 'new')
            products[i]['label'] = 'product__item-new-label';
        else
            products[i]['label'] = 'no-label';
    }
}

// Ensure search results are relevant to sellers
search.addEventListener('keyup', function(event) {
    if (event.keyCode == 13 && search.value.trim().length > 0) {
        localStorage.setItem('search', search.value.trim());
        searchProduct = products.filter(function(product) {
            return product.name.toLowerCase().includes(search.value.trim().toLowerCase());
        });
        localStorage.setItem('searchProduct', JSON.stringify(searchProduct));
        document.getElementById('search-info').value = '';
        window.location.href = 'index.html?search';
    }
});

function showCategory() {
    searchProduct = JSON.parse(localStorage.getItem('searchProduct'));

    var categoryList = searchProduct.map(function(product) {
        return product.category; 
    });

    for (var i = 0; i < categoryList.length; i++) {
        categoryList[i] = categoryList[i].toLowerCase();
    }
    categoryList = [...new Set(categoryList)];

    for (var i = 0; i < categoryList.length; i++) {
        categoryList[i] = ReName(categoryList[i]);
    }

    if (categoryList.length > 1) {
        var s = `
            <li class="product__filter-item">
                <button class="product__filter-item-btn product__filter-item-btn--active" onclick="showSearchProduct(1)">Tất cả</button>
            </li>
        `;
        var html = categoryList.map(function(category) {
            return `
                <li class="product__filter-item">
                    <button class="product__filter-item-btn" onclick="showCategoryProduct('${category.toLowerCase().replaceAll(' ', '-')}', 1)">${category}</button>
                </li>
            `;
        });
        s = s + html.join('');
        document.querySelector('.product__filter').innerHTML = s;
    } else {
        document.querySelector('.product__filter').innerHTML = '';
    }
}

function showCurrentCategory(name) {
    var currentFilter = document.querySelectorAll('.product__filter-item-btn');
    for (var i = 0; i < currentFilter.length; i++) {
        currentFilter[i].classList.remove('product__filter-item-btn--active');
    }
    for (var i = 0; i < currentFilter.length; i++) {
        if (currentFilter[i].innerText.toLowerCase() == name.replaceAll('-', ' ')) {
            currentFilter[i].classList.add('product__filter-item-btn--active');
            break;
        }
    }
}   

function showCategoryProduct(name, start) {
    var tmpArray = JSON.parse(localStorage.getItem('searchProduct'));
    var categoryProduct = tmpArray.filter(function(product) {
        return product.category.toLowerCase() === name.toLowerCase();
    });
    localStorage.setItem('categoryName', name);

    showCurrentCategory(name);
    showCategoryPagination(categoryProduct, name);
    showCurrentPage(start);
    
    var arr = createTempArray(start, categoryProduct);
    document.getElementById('show-product').innerHTML = arr.join('');
    document.querySelector('.product__header').scrollIntoView();

    // Xử lý page
    Pagination();
}

function showSearchProduct(start) {
    document.querySelector('.cart').style.display = 'none';
    document.querySelector('.order').style.display = 'none';

    searchProduct = JSON.parse(localStorage.getItem('searchProduct')) || [];
    if (searchProduct.length === 0) {
        document.getElementById('body').style.display = 'none';
        document.getElementById('search__empty').innerHTML = `
            <div class="grid wide">
                <p class="search__empty-notice">Không tìm thấy kết quả nào phù hợp với từ khóa "${localStorage.getItem('search')}"</p>
            </div>
        `;
    } else {
        var arr = createTempArray(start, searchProduct);
        document.getElementById('show-product').innerHTML = arr.join('');
        showSearchPagination(searchProduct);
    }
}