/**
 * Add token on ajax request.
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Request to the server to recalculate the prices of all products on the page.
 * Called when the currency is changed.
 */
$('.currencySet').click(function (e) {
    console.log('Change currency ajax script');

    e.preventDefault();

    var select = document.getElementById("selectCurrency");
    var currency = select.value;

    $.ajax({
        type: 'POST',
        url: "/ajaxGetPrices",
        data: {currency: currency},
        success: function (result) {
            var data = JSON.parse(result);
            //console.log('result=' + result);

            // Get a list of products items
            var elements = document.getElementsByClassName("divPrice");
            var productList = [];
            for (var i = 0; i < elements.length; i++) {
                productList[i] = parseInt(elements[i].id.replace(/\D/g, ''));
            }

            //Change prices and currency name
            for (var j = 0; j < data.productPrices.length; j++) {
                flagProductIsListed = productList.indexOf(data.productPrices[j].id) != -1;
                if (flagProductIsListed) {
                    document.getElementById('idPrice' + data.productPrices[j].id).textContent = data.productPrices[j].price;
                }
            }
            if (data.currency == 'EUR') {
                $(".divCurrencyName").text("€");
            } else {
                $(".divCurrencyName").text("$");
            }

        },
        error: function (result) {
            console.log('Ajax error!');
            console.log(result);
        }
    });
});


/**
 * Add products in cart. Or increment current quantity.
 */
$('.buttonAddProduct').click(function (e) {
    console.log('Click button Add Product');
    e.preventDefault();

    nameProductId = $(this).attr('id');
    productId = nameProductId.replace(/\D/g, '');
    console.log(productId);

    $.ajax({
        type: 'POST',
        url: "/ajaxAddProduct",
        data: {productId: productId},
        success: function (result) {
            var data = JSON.parse(result);
            console.log('result=' + result);
            console.log('data=' + data);

            var divCount = document.getElementById('divCount' + productId);
            if (divCount) {
                divCount.textContent = '(' + data.quantity + ' pieces)'; //Button text (index page)
            }

            var tdQuantity = document.getElementById('tdQuantity' + productId);
            if (tdQuantity) {
                tdQuantity.textContent = data.quantity; //Quantity text (on the Cart page)

                var idDecButton = document.getElementById('idDecButton' + productId);
                var idTrProduct = document.getElementById('tr' + productId);
                if (data.quantity > 0) {
                    idDecButton.classList.remove('disabled'); //Set "Enable" for the Decrement button
                    idTrProduct.classList.remove('td-draft'); //Set "Disable" for the Decrement button
                }
            }

        },
        error: function (result) {
            console.log('Ajax error!');
            console.log(result);
        }
    });
});


/**
 * Decrement current quantity. Or delete Cart item, if the quantity is 0.
 */
$('.buttonDecProduct').click(function (e) {
    console.log('Click button Decrement Product');
    e.preventDefault();

    productId = $(this).attr('id').replace(/\D/g, '');
    console.log(productId);

    $.ajax({
        type: 'POST',
        url: "/ajaxDecProduct",
        data: {productId: productId},
        success: function (result) {
            var data = JSON.parse(result);
            console.log('result=' + result);

            var divCount = document.getElementById('divCount' + productId);
            if (divCount) {
                divCount.textContent = '(' + data.quantity + ' pieces)'; //Button text (on the index page)
            }

            var tdQuantity = document.getElementById('tdQuantity' + productId);
            if (tdQuantity) {
                tdQuantity.textContent = data.quantity; //Quantity text (on the Cart page)

                var idDecButton = document.getElementById('idDecButton' + productId);
                var idTrProduct = document.getElementById('tr' + productId);
                if (data.quantity === 0) {
                    idDecButton.classList.add('disabled'); //Set "Disable" for the Decrement button (on the Cart page)
                    idTrProduct.classList.add('td-draft'); //Highlight product with zero quantity (on the Cart page)
                }
            }
        },
        error: function (result) {
            console.log('Ajax error!');
            console.log(result);
        }
    });
});



