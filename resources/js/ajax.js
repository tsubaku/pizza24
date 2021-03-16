/**
 * Add token on ajax request.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


/**
 * Changes the user locale
 */
$('.languageSet').click(function (e) {
    console.log('Click button change locale');
    e.preventDefault();

    var select = document.getElementById("selectLanguage");
    var newLocale = select.value;
    console.log('Change locale: ' + newLocale);

    $.ajax({
        type: 'POST',
        url: "/changeLocale",
        data: {
            newLocale: newLocale
        },
        success: function (result) {
            var data = JSON.parse(result);
            console.log('result=' + result);
        },
        error: function (result) {
            console.log('Ajax error!');
            console.log(result);
        }
    });
});


/**
 * Request to the server to recalculate the prices of all products on the page.
 * Called when the currency is changed.
 */
$('.currencySet').click(function (e) {
    e.preventDefault();

    var select = document.getElementById("selectCurrency");
    var currency = select.value;
    console.log('Change currency: ' + currency);

    $.ajax({
        type: 'POST',
        url: "/ajaxGetPrices",
        data: {currency: currency},
        success: function (result) {
            var data = JSON.parse(result);
            console.log('result=' + result);

            // Get a list of products items on the Index page
            var elements = document.getElementsByClassName("divPrice");
            var productList = [];
            for (var i = 0; i < elements.length; i++) {
                productList[i] = parseInt(elements[i].id.replace(/\D/g, ''));
            }

            //Change prices on the Index page
            if (data.productPrices) {
                for (var j = 0; j < data.productPrices.length; j++) {
                    flagProductIsListed = productList.indexOf(data.productPrices[j].id) != -1;
                    if (flagProductIsListed) {
                        document.getElementById('idPrice' + data.productPrices[j].id).textContent = data.productPrices[j].price;
                    }
                }
            }

            //Change prices on the Cart page
            for (var k in data.pricesProductInCart) {
                var divPrice = document.getElementById('idPrice' + k);
                if (divPrice) {
                    divPrice.textContent = data.pricesProductInCart[k];
                }
                var idTdSum = document.getElementById('tdSum' + k);
                if (idTdSum) {
                    idTdSum.textContent = data.sums[k]; //productPriceSum text (on the Cart page)
                }
            }

            //Change the Delivery costs on the Cart page
            var deliveryCosts = document.getElementById('deliveryCosts');
            if (deliveryCosts) {
                deliveryCosts.textContent = data.deliveryCosts;
            }

            //Change the Full price on the Cart page
            var divFullPrice = document.getElementById('divFullPrice');
            if (divFullPrice) {
                divFullPrice.textContent = data.fullPrice;
            }

            //Change currency name
            $(".divCurrencyName").text(data.currencyLogo);

            //$("#divTest").text(result);

        },
        error: function (result) {
            console.log('Ajax error!');
            console.log(result);
        }
    });
});


/**
 * Change the category in the Index page header
 */
$('.categorySet').click(function (e) {
    e.preventDefault();
    var selectedCategory = document.getElementById("selectCategory").value;
    //console.log('Change category: ' + selectedCategory);
    window.location.href = '?category=' + selectedCategory;
});


/**
 * Increment/Decrement current quantity.
 */
$('.buttonDecProduct, .buttonAddProduct').click(function (e) {
    console.log('Click button Decrement Product');
    e.preventDefault();

    nameProductId = $(this).attr('id');
    productId = nameProductId.replace(/\D/g, '');
    console.log('productId=' + productId);

    if (nameProductId.includes('idAddButton')) {
        action = 'increment';
    } else {
        action = 'decrement';
    }

    $.ajax({
        type: 'POST',
        url: "/changeProductQuantity",
        data: {
            productId: productId,
            action: action,
        },
        success: function (result) {
            var data = JSON.parse(result);
            console.log('result=' + result);
            setNewPricesOnPage(data);
        },
        error: function (result) {
            console.log('Ajax error!');
            console.log(result);
        }
    });
});


/**
 * The function takes the price data, received from the server after changing the quantity of ordered goods and changes the old peices on the page to the new ones.
 * @param data
 */
function setNewPricesOnPage(data) {
    //Index page
    var divCount = document.getElementById('divCount' + productId);
    if (divCount) {
        divCount.textContent = '(' + data.quantity + ' pieces)'; //Button text (index page)
    }

    //Cart page
    var tdQuantity = document.getElementById('tdQuantity' + productId);
    if (tdQuantity) {
        tdQuantity.textContent = data.quantity; //Quantity text (on the Cart page)

        var idDecButton = document.getElementById('idDecButton' + productId);
        var idTrProduct = document.getElementById('tr' + productId);
        if (data.quantity > 0) {
            idDecButton.classList.remove('disabled'); //Set "Enable" for the Decrement button
            idTrProduct.classList.remove('td-draft'); //Set "Disable" for the Decrement button
        } else {
            idDecButton.classList.add('disabled'); //Set "Disable" for the Decrement button (on the Cart page)
            idTrProduct.classList.add('td-draft'); //Highlight product with zero quantity (on the Cart page)
        }

        var idTdSum = document.getElementById('tdSum' + productId);
        idTdSum.textContent = data.productPriceSum; //productPriceSum text (on the Cart page)

        var divFullPrice = document.getElementById('divFullPrice');
        divFullPrice.textContent = data.fullPrice; //productPriceSum text (on the Cart page)

        if (data.fullPrice == data.deliveryCosts) {
            var buttonSubmit = document.getElementById('buttonSubmit');
            buttonSubmit.classList.add('disabled'); //Set "Disable" for the Submit button (on the Cart page)
        }
    }
}


/**
 * Navigation through the order panels in the shopping cart.
 */
$('.buttonPartControl').click(function (e) {
    e.preventDefault();
    console.log('buttonPartControl');

    //if user is on the Order page, go to the Cart page
    if (window.location.pathname != '/cart') {
        window.location.pathname = '/cart';
    }

    $("#part1").slideToggle();
    $("#part2").slideToggle();
});


