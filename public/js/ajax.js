/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/ajax.js ***!
  \******************************/
eval("/**\n * Add token on ajax request.\n */\n$.ajaxSetup({\n  headers: {\n    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')\n  }\n});\n/**\n * Request to the server to recalculate the prices of all products on the page.\n * Called when the currency is changed.\n */\n\n$('.currencySet').click(function (e) {\n  e.preventDefault();\n  var select = document.getElementById(\"selectCurrency\");\n  var currency = select.value;\n  console.log('Change currency: ' + currency);\n  $.ajax({\n    type: 'POST',\n    url: \"/ajaxGetPrices\",\n    data: {\n      currency: currency\n    },\n    success: function success(result) {\n      var data = JSON.parse(result);\n      console.log('result=' + result); // Get a list of products items on the Index page\n\n      var elements = document.getElementsByClassName(\"divPrice\");\n      var productList = [];\n\n      for (var i = 0; i < elements.length; i++) {\n        productList[i] = parseInt(elements[i].id.replace(/\\D/g, ''));\n      } //Change prices on the Index page\n\n\n      if (data.productPrices) {\n        for (var j = 0; j < data.productPrices.length; j++) {\n          flagProductIsListed = productList.indexOf(data.productPrices[j].id) != -1;\n\n          if (flagProductIsListed) {\n            document.getElementById('idPrice' + data.productPrices[j].id).textContent = data.productPrices[j].price;\n          }\n        }\n      } //Change prices on the Cart page\n\n\n      for (var k in data.pricesProductInCart) {\n        var divPrice = document.getElementById('idPrice' + k);\n\n        if (divPrice) {\n          divPrice.textContent = data.pricesProductInCart[k];\n        }\n\n        var idTdSum = document.getElementById('tdSum' + k);\n\n        if (idTdSum) {\n          idTdSum.textContent = data.sums[k]; //productPriceSum text (on the Cart page)\n        }\n      } //Change the Delivery costs on the Cart page\n\n\n      var deliveryCosts = document.getElementById('deliveryCosts');\n\n      if (deliveryCosts) {\n        deliveryCosts.textContent = data.deliveryCosts;\n      } //Change the Full price on the Cart page\n\n\n      var divFullPrice = document.getElementById('divFullPrice');\n\n      if (divFullPrice) {\n        divFullPrice.textContent = data.fullPrice;\n      } //Change currency name\n\n\n      $(\".divCurrencyName\").text(data.currencyLogo); //$(\"#divTest\").text(result);\n    },\n    error: function error(result) {\n      console.log('Ajax error!');\n      console.log(result);\n    }\n  });\n});\n/**\n * Change the category in the Index page header\n */\n\n$('.categorySet').click(function (e) {\n  e.preventDefault();\n  var selectedCategory = document.getElementById(\"selectCategory\").value; //console.log('Change category: ' + selectedCategory);\n\n  window.location.href = '?category=' + selectedCategory;\n});\n/**\n * Increment/Decrement current quantity.\n */\n\n$('.buttonDecProduct, .buttonAddProduct').click(function (e) {\n  console.log('Click button Decrement Product');\n  e.preventDefault();\n  nameProductId = $(this).attr('id');\n  productId = nameProductId.replace(/\\D/g, '');\n  console.log('productId=' + productId);\n\n  if (nameProductId.includes('idAddButton')) {\n    action = 'increment';\n  } else {\n    action = 'decrement';\n  }\n\n  $.ajax({\n    type: 'POST',\n    url: \"/changeProductQuantity\",\n    data: {\n      productId: productId,\n      action: action\n    },\n    success: function success(result) {\n      var data = JSON.parse(result);\n      console.log('result=' + result);\n      setNewPricesOnPage(data);\n    },\n    error: function error(result) {\n      console.log('Ajax error!');\n      console.log(result);\n    }\n  });\n});\n/**\n * The function takes the price data, received from the server after changing the quantity of ordered goods and changes the old peices on the page to the new ones.\n * @param data\n */\n\nfunction setNewPricesOnPage(data) {\n  //Index page\n  var divCount = document.getElementById('divCount' + productId);\n\n  if (divCount) {\n    divCount.textContent = '(' + data.quantity + ' pieces)'; //Button text (index page)\n  } //Cart page\n\n\n  var tdQuantity = document.getElementById('tdQuantity' + productId);\n\n  if (tdQuantity) {\n    tdQuantity.textContent = data.quantity; //Quantity text (on the Cart page)\n\n    var idDecButton = document.getElementById('idDecButton' + productId);\n    var idTrProduct = document.getElementById('tr' + productId);\n\n    if (data.quantity > 0) {\n      idDecButton.classList.remove('disabled'); //Set \"Enable\" for the Decrement button\n\n      idTrProduct.classList.remove('td-draft'); //Set \"Disable\" for the Decrement button\n    } else {\n      idDecButton.classList.add('disabled'); //Set \"Disable\" for the Decrement button (on the Cart page)\n\n      idTrProduct.classList.add('td-draft'); //Highlight product with zero quantity (on the Cart page)\n    }\n\n    var idTdSum = document.getElementById('tdSum' + productId);\n    idTdSum.textContent = data.productPriceSum; //productPriceSum text (on the Cart page)\n\n    var divFullPrice = document.getElementById('divFullPrice');\n    divFullPrice.textContent = data.fullPrice; //productPriceSum text (on the Cart page)\n\n    if (data.fullPrice == data.deliveryCosts) {\n      var buttonSubmit = document.getElementById('buttonSubmit');\n      buttonSubmit.classList.add('disabled'); //Set \"Disable\" for the Submit button (on the Cart page)\n    }\n  }\n}\n/**\n * Navigation through the order panels in the shopping cart.\n */\n\n\n$('.buttonPartControl').click(function (e) {\n  e.preventDefault(); //console.log('buttonPartControl');\n\n  $(\"#part1\").slideToggle();\n  $(\"#part2\").slideToggle();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvYWpheC5qcz8yNjBjIl0sIm5hbWVzIjpbIiQiLCJhamF4U2V0dXAiLCJoZWFkZXJzIiwiYXR0ciIsImNsaWNrIiwiZSIsInByZXZlbnREZWZhdWx0Iiwic2VsZWN0IiwiZG9jdW1lbnQiLCJnZXRFbGVtZW50QnlJZCIsImN1cnJlbmN5IiwidmFsdWUiLCJjb25zb2xlIiwibG9nIiwiYWpheCIsInR5cGUiLCJ1cmwiLCJkYXRhIiwic3VjY2VzcyIsInJlc3VsdCIsIkpTT04iLCJwYXJzZSIsImVsZW1lbnRzIiwiZ2V0RWxlbWVudHNCeUNsYXNzTmFtZSIsInByb2R1Y3RMaXN0IiwiaSIsImxlbmd0aCIsInBhcnNlSW50IiwiaWQiLCJyZXBsYWNlIiwicHJvZHVjdFByaWNlcyIsImoiLCJmbGFnUHJvZHVjdElzTGlzdGVkIiwiaW5kZXhPZiIsInRleHRDb250ZW50IiwicHJpY2UiLCJrIiwicHJpY2VzUHJvZHVjdEluQ2FydCIsImRpdlByaWNlIiwiaWRUZFN1bSIsInN1bXMiLCJkZWxpdmVyeUNvc3RzIiwiZGl2RnVsbFByaWNlIiwiZnVsbFByaWNlIiwidGV4dCIsImN1cnJlbmN5TG9nbyIsImVycm9yIiwic2VsZWN0ZWRDYXRlZ29yeSIsIndpbmRvdyIsImxvY2F0aW9uIiwiaHJlZiIsIm5hbWVQcm9kdWN0SWQiLCJwcm9kdWN0SWQiLCJpbmNsdWRlcyIsImFjdGlvbiIsInNldE5ld1ByaWNlc09uUGFnZSIsImRpdkNvdW50IiwicXVhbnRpdHkiLCJ0ZFF1YW50aXR5IiwiaWREZWNCdXR0b24iLCJpZFRyUHJvZHVjdCIsImNsYXNzTGlzdCIsInJlbW92ZSIsImFkZCIsInByb2R1Y3RQcmljZVN1bSIsImJ1dHRvblN1Ym1pdCIsInNsaWRlVG9nZ2xlIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQUEsQ0FBQyxDQUFDQyxTQUFGLENBQVk7QUFDUkMsRUFBQUEsT0FBTyxFQUFFO0FBQ0wsb0JBQWdC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LFVBQVUyQyxTQUFsQyxDQUFkO0FBQ0FiLElBQUFBLE9BQU8sQ0FBQ0wsV0FBUixHQUFzQmpCLElBQUksQ0FBQytDLGVBQTNCLENBZFksQ0FjZ0M7O0FBRTVDLFFBQUl0QixZQUFZLEdBQUdsQyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsY0FBeEIsQ0FBbkI7QUFDQWlDLElBQUFBLFlBQVksQ0FBQ1IsV0FBYixHQUEyQmpCLElBQUksQ0FBQzBCLFNBQWhDLENBakJZLENBaUIrQjs7QUFFM0MsUUFBSTFCLElBQUksQ0FBQzBCLFNBQUwsSUFBa0IxQixJQUFJLENBQUN3QixhQUEzQixFQUEwQztBQUN0QyxVQUFJd0IsWUFBWSxHQUFHekQsUUFBUSxDQUFDQyxjQUFULENBQXdCLGNBQXhCLENBQW5CO0FBQ0F3RCxNQUFBQSxZQUFZLENBQUNKLFNBQWIsQ0FBdUJFLEdBQXZCLENBQTJCLFVBQTNCLEVBRnNDLENBRUU7QUFDM0M7QUFDSjtBQUNKO0FBR0Q7QUFDQTtBQUNBOzs7QUFDQS9ELENBQUMsQ0FBQyxvQkFBRCxDQUFELENBQXdCSSxLQUF4QixDQUE4QixVQUFVQyxDQUFWLEVBQWE7QUFDdkNBLEVBQUFBLENBQUMsQ0FBQ0MsY0FBRixHQUR1QyxDQUV2Qzs7QUFDQU4sRUFBQUEsQ0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZa0UsV0FBWjtBQUNBbEUsRUFBQUEsQ0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZa0UsV0FBWjtBQUNILENBTEQiLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIEFkZCB0b2tlbiBvbiBhamF4IHJlcXVlc3QuXG4gKi9cbiQuYWpheFNldHVwKHtcbiAgICBoZWFkZXJzOiB7XG4gICAgICAgICdYLUNTUkYtVE9LRU4nOiAkKCdtZXRhW25hbWU9XCJjc3JmLXRva2VuXCJdJykuYXR0cignY29udGVudCcpXG4gICAgfVxufSk7XG5cbi8qKlxuICogUmVxdWVzdCB0byB0aGUgc2VydmVyIHRvIHJlY2FsY3VsYXRlIHRoZSBwcmljZXMgb2YgYWxsIHByb2R1Y3RzIG9uIHRoZSBwYWdlLlxuICogQ2FsbGVkIHdoZW4gdGhlIGN1cnJlbmN5IGlzIGNoYW5nZWQuXG4gKi9cbiQoJy5jdXJyZW5jeVNldCcpLmNsaWNrKGZ1bmN0aW9uIChlKSB7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgdmFyIHNlbGVjdCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwic2VsZWN0Q3VycmVuY3lcIik7XG4gICAgdmFyIGN1cnJlbmN5ID0gc2VsZWN0LnZhbHVlO1xuICAgIGNvbnNvbGUubG9nKCdDaGFuZ2UgY3VycmVuY3k6ICcgKyBjdXJyZW5jeSk7XG5cbiAgICAkLmFqYXgoe1xuICAgICAgICB0eXBlOiAnUE9TVCcsXG4gICAgICAgIHVybDogXCIvYWpheEdldFByaWNlc1wiLFxuICAgICAgICBkYXRhOiB7Y3VycmVuY3k6IGN1cnJlbmN5fSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgICAgdmFyIGRhdGEgPSBKU09OLnBhcnNlKHJlc3VsdCk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygncmVzdWx0PScgKyByZXN1bHQpO1xuXG4gICAgICAgICAgICAvLyBHZXQgYSBsaXN0IG9mIHByb2R1Y3RzIGl0ZW1zIG9uIHRoZSBJbmRleCBwYWdlXG4gICAgICAgICAgICB2YXIgZWxlbWVudHMgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5Q2xhc3NOYW1lKFwiZGl2UHJpY2VcIik7XG4gICAgICAgICAgICB2YXIgcHJvZHVjdExpc3QgPSBbXTtcbiAgICAgICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgZWxlbWVudHMubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgICAgICBwcm9kdWN0TGlzdFtpXSA9IHBhcnNlSW50KGVsZW1lbnRzW2ldLmlkLnJlcGxhY2UoL1xcRC9nLCAnJykpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAvL0NoYW5nZSBwcmljZXMgb24gdGhlIEluZGV4IHBhZ2VcbiAgICAgICAgICAgIGlmIChkYXRhLnByb2R1Y3RQcmljZXMpIHtcbiAgICAgICAgICAgICAgICBmb3IgKHZhciBqID0gMDsgaiA8IGRhdGEucHJvZHVjdFByaWNlcy5sZW5ndGg7IGorKykge1xuICAgICAgICAgICAgICAgICAgICBmbGFnUHJvZHVjdElzTGlzdGVkID0gcHJvZHVjdExpc3QuaW5kZXhPZihkYXRhLnByb2R1Y3RQcmljZXNbal0uaWQpICE9IC0xO1xuICAgICAgICAgICAgICAgICAgICBpZiAoZmxhZ1Byb2R1Y3RJc0xpc3RlZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2lkUHJpY2UnICsgZGF0YS5wcm9kdWN0UHJpY2VzW2pdLmlkKS50ZXh0Q29udGVudCA9IGRhdGEucHJvZHVjdFByaWNlc1tqXS5wcmljZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgLy9DaGFuZ2UgcHJpY2VzIG9uIHRoZSBDYXJ0IHBhZ2VcbiAgICAgICAgICAgIGZvciAodmFyIGsgaW4gZGF0YS5wcmljZXNQcm9kdWN0SW5DYXJ0KSB7XG4gICAgICAgICAgICAgICAgdmFyIGRpdlByaWNlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2lkUHJpY2UnICsgayk7XG4gICAgICAgICAgICAgICAgaWYgKGRpdlByaWNlKSB7XG4gICAgICAgICAgICAgICAgICAgIGRpdlByaWNlLnRleHRDb250ZW50ID0gZGF0YS5wcmljZXNQcm9kdWN0SW5DYXJ0W2tdO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB2YXIgaWRUZFN1bSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0ZFN1bScgKyBrKTtcbiAgICAgICAgICAgICAgICBpZiAoaWRUZFN1bSkge1xuICAgICAgICAgICAgICAgICAgICBpZFRkU3VtLnRleHRDb250ZW50ID0gZGF0YS5zdW1zW2tdOyAvL3Byb2R1Y3RQcmljZVN1bSB0ZXh0IChvbiB0aGUgQ2FydCBwYWdlKVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgLy9DaGFuZ2UgdGhlIERlbGl2ZXJ5IGNvc3RzIG9uIHRoZSBDYXJ0IHBhZ2VcbiAgICAgICAgICAgIHZhciBkZWxpdmVyeUNvc3RzID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2RlbGl2ZXJ5Q29zdHMnKTtcbiAgICAgICAgICAgIGlmIChkZWxpdmVyeUNvc3RzKSB7XG4gICAgICAgICAgICAgICAgZGVsaXZlcnlDb3N0cy50ZXh0Q29udGVudCA9IGRhdGEuZGVsaXZlcnlDb3N0cztcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgLy9DaGFuZ2UgdGhlIEZ1bGwgcHJpY2Ugb24gdGhlIENhcnQgcGFnZVxuICAgICAgICAgICAgdmFyIGRpdkZ1bGxQcmljZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdkaXZGdWxsUHJpY2UnKTtcbiAgICAgICAgICAgIGlmIChkaXZGdWxsUHJpY2UpIHtcbiAgICAgICAgICAgICAgICBkaXZGdWxsUHJpY2UudGV4dENvbnRlbnQgPSBkYXRhLmZ1bGxQcmljZTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgLy9DaGFuZ2UgY3VycmVuY3kgbmFtZVxuICAgICAgICAgICAgJChcIi5kaXZDdXJyZW5jeU5hbWVcIikudGV4dChkYXRhLmN1cnJlbmN5TG9nbyk7XG5cbiAgICAgICAgICAgIC8vJChcIiNkaXZUZXN0XCIpLnRleHQocmVzdWx0KTtcblxuICAgICAgICB9LFxuICAgICAgICBlcnJvcjogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ0FqYXggZXJyb3IhJyk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhyZXN1bHQpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcblxuXG4vKipcbiAqIENoYW5nZSB0aGUgY2F0ZWdvcnkgaW4gdGhlIEluZGV4IHBhZ2UgaGVhZGVyXG4gKi9cbiQoJy5jYXRlZ29yeVNldCcpLmNsaWNrKGZ1bmN0aW9uIChlKSB7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgIHZhciBzZWxlY3RlZENhdGVnb3J5ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJzZWxlY3RDYXRlZ29yeVwiKS52YWx1ZTtcbiAgICAvL2NvbnNvbGUubG9nKCdDaGFuZ2UgY2F0ZWdvcnk6ICcgKyBzZWxlY3RlZENhdGVnb3J5KTtcbiAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9ICc/Y2F0ZWdvcnk9JyArIHNlbGVjdGVkQ2F0ZWdvcnk7XG59KTtcblxuXG4vKipcbiAqIEluY3JlbWVudC9EZWNyZW1lbnQgY3VycmVudCBxdWFudGl0eS5cbiAqL1xuJCgnLmJ1dHRvbkRlY1Byb2R1Y3QsIC5idXR0b25BZGRQcm9kdWN0JykuY2xpY2soZnVuY3Rpb24gKGUpIHtcbiAgICBjb25zb2xlLmxvZygnQ2xpY2sgYnV0dG9uIERlY3JlbWVudCBQcm9kdWN0Jyk7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgbmFtZVByb2R1Y3RJZCA9ICQodGhpcykuYXR0cignaWQnKTtcbiAgICBwcm9kdWN0SWQgPSBuYW1lUHJvZHVjdElkLnJlcGxhY2UoL1xcRC9nLCAnJyk7XG4gICAgY29uc29sZS5sb2coJ3Byb2R1Y3RJZD0nICsgcHJvZHVjdElkKTtcblxuICAgIGlmIChuYW1lUHJvZHVjdElkLmluY2x1ZGVzKCdpZEFkZEJ1dHRvbicpKSB7XG4gICAgICAgIGFjdGlvbiA9ICdpbmNyZW1lbnQnO1xuICAgIH0gZWxzZSB7XG4gICAgICAgIGFjdGlvbiA9ICdkZWNyZW1lbnQnO1xuICAgIH1cblxuICAgICQuYWpheCh7XG4gICAgICAgIHR5cGU6ICdQT1NUJyxcbiAgICAgICAgdXJsOiBcIi9jaGFuZ2VQcm9kdWN0UXVhbnRpdHlcIixcbiAgICAgICAgZGF0YToge1xuICAgICAgICAgICAgcHJvZHVjdElkOiBwcm9kdWN0SWQsXG4gICAgICAgICAgICBhY3Rpb246IGFjdGlvbixcbiAgICAgICAgfSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgICAgdmFyIGRhdGEgPSBKU09OLnBhcnNlKHJlc3VsdCk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygncmVzdWx0PScgKyByZXN1bHQpO1xuICAgICAgICAgICAgc2V0TmV3UHJpY2VzT25QYWdlKGRhdGEpO1xuICAgICAgICB9LFxuICAgICAgICBlcnJvcjogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgICAgY29uc29sZS5sb2coJ0FqYXggZXJyb3IhJyk7XG4gICAgICAgICAgICBjb25zb2xlLmxvZyhyZXN1bHQpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcblxuXG4vKipcbiAqIFRoZSBmdW5jdGlvbiB0YWtlcyB0aGUgcHJpY2UgZGF0YSwgcmVjZWl2ZWQgZnJvbSB0aGUgc2VydmVyIGFmdGVyIGNoYW5naW5nIHRoZSBxdWFudGl0eSBvZiBvcmRlcmVkIGdvb2RzIGFuZCBjaGFuZ2VzIHRoZSBvbGQgcGVpY2VzIG9uIHRoZSBwYWdlIHRvIHRoZSBuZXcgb25lcy5cbiAqIEBwYXJhbSBkYXRhXG4gKi9cbmZ1bmN0aW9uIHNldE5ld1ByaWNlc09uUGFnZShkYXRhKSB7XG4gICAgLy9JbmRleCBwYWdlXG4gICAgdmFyIGRpdkNvdW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2RpdkNvdW50JyArIHByb2R1Y3RJZCk7XG4gICAgaWYgKGRpdkNvdW50KSB7XG4gICAgICAgIGRpdkNvdW50LnRleHRDb250ZW50ID0gJygnICsgZGF0YS5xdWFudGl0eSArICcgcGllY2VzKSc7IC8vQnV0dG9uIHRleHQgKGluZGV4IHBhZ2UpXG4gICAgfVxuXG4gICAgLy9DYXJ0IHBhZ2VcbiAgICB2YXIgdGRRdWFudGl0eSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0ZFF1YW50aXR5JyArIHByb2R1Y3RJZCk7XG4gICAgaWYgKHRkUXVhbnRpdHkpIHtcbiAgICAgICAgdGRRdWFudGl0eS50ZXh0Q29udGVudCA9IGRhdGEucXVhbnRpdHk7IC8vUXVhbnRpdHkgdGV4dCAob24gdGhlIENhcnQgcGFnZSlcblxuICAgICAgICB2YXIgaWREZWNCdXR0b24gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaWREZWNCdXR0b24nICsgcHJvZHVjdElkKTtcbiAgICAgICAgdmFyIGlkVHJQcm9kdWN0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3RyJyArIHByb2R1Y3RJZCk7XG4gICAgICAgIGlmIChkYXRhLnF1YW50aXR5ID4gMCkge1xuICAgICAgICAgICAgaWREZWNCdXR0b24uY2xhc3NMaXN0LnJlbW92ZSgnZGlzYWJsZWQnKTsgLy9TZXQgXCJFbmFibGVcIiBmb3IgdGhlIERlY3JlbWVudCBidXR0b25cbiAgICAgICAgICAgIGlkVHJQcm9kdWN0LmNsYXNzTGlzdC5yZW1vdmUoJ3RkLWRyYWZ0Jyk7IC8vU2V0IFwiRGlzYWJsZVwiIGZvciB0aGUgRGVjcmVtZW50IGJ1dHRvblxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgaWREZWNCdXR0b24uY2xhc3NMaXN0LmFkZCgnZGlzYWJsZWQnKTsgLy9TZXQgXCJEaXNhYmxlXCIgZm9yIHRoZSBEZWNyZW1lbnQgYnV0dG9uIChvbiB0aGUgQ2FydCBwYWdlKVxuICAgICAgICAgICAgaWRUclByb2R1Y3QuY2xhc3NMaXN0LmFkZCgndGQtZHJhZnQnKTsgLy9IaWdobGlnaHQgcHJvZHVjdCB3aXRoIHplcm8gcXVhbnRpdHkgKG9uIHRoZSBDYXJ0IHBhZ2UpXG4gICAgICAgIH1cblxuICAgICAgICB2YXIgaWRUZFN1bSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0ZFN1bScgKyBwcm9kdWN0SWQpO1xuICAgICAgICBpZFRkU3VtLnRleHRDb250ZW50ID0gZGF0YS5wcm9kdWN0UHJpY2VTdW07IC8vcHJvZHVjdFByaWNlU3VtIHRleHQgKG9uIHRoZSBDYXJ0IHBhZ2UpXG5cbiAgICAgICAgdmFyIGRpdkZ1bGxQcmljZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdkaXZGdWxsUHJpY2UnKTtcbiAgICAgICAgZGl2RnVsbFByaWNlLnRleHRDb250ZW50ID0gZGF0YS5mdWxsUHJpY2U7IC8vcHJvZHVjdFByaWNlU3VtIHRleHQgKG9uIHRoZSBDYXJ0IHBhZ2UpXG5cbiAgICAgICAgaWYgKGRhdGEuZnVsbFByaWNlID09IGRhdGEuZGVsaXZlcnlDb3N0cykge1xuICAgICAgICAgICAgdmFyIGJ1dHRvblN1Ym1pdCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdidXR0b25TdWJtaXQnKTtcbiAgICAgICAgICAgIGJ1dHRvblN1Ym1pdC5jbGFzc0xpc3QuYWRkKCdkaXNhYmxlZCcpOyAvL1NldCBcIkRpc2FibGVcIiBmb3IgdGhlIFN1Ym1pdCBidXR0b24gKG9uIHRoZSBDYXJ0IHBhZ2UpXG4gICAgICAgIH1cbiAgICB9XG59XG5cblxuLyoqXG4gKiBOYXZpZ2F0aW9uIHRocm91Z2ggdGhlIG9yZGVyIHBhbmVscyBpbiB0aGUgc2hvcHBpbmcgY2FydC5cbiAqL1xuJCgnLmJ1dHRvblBhcnRDb250cm9sJykuY2xpY2soZnVuY3Rpb24gKGUpIHtcbiAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgLy9jb25zb2xlLmxvZygnYnV0dG9uUGFydENvbnRyb2wnKTtcbiAgICAkKFwiI3BhcnQxXCIpLnNsaWRlVG9nZ2xlKCk7XG4gICAgJChcIiNwYXJ0MlwiKS5zbGlkZVRvZ2dsZSgpO1xufSk7XG5cblxuIl0sImZpbGUiOiIuL3Jlc291cmNlcy9qcy9hamF4LmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/ajax.js\n");
/******/ })()
;