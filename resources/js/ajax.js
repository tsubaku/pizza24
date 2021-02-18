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
            if (data.currency == 'EUR'){
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


