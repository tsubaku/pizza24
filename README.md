## THE PIZZA TASK

## 1. Task description
Let’s imagine you want to start a new pizza delivery business. Please create a small web application for online pizza ordering. The idea is to make a non-existing service where assumed clients can choose a pizza, put it into a cart and make an order.


## 2. Requirements
✔ The menu page should contain at least 8 pizzas

✔ Please add a currency switch so that the clients can change prices from dollars into euro and vice versa

✔ Don’t forget to add delivery costs to the final bill. It can be a static figure

✔ The app should have login and registration options. Please make sure that the login option is not mandatory for users (in other words, a user should be able to make an order without logging in)

✔ Logged users should be able to see their history of orders

✔ Don’t proceed to the payment page. The last action from a client will be filling in the order form (address,
name, surname, etc.) to get a confirmation that the order has been received

✔ Please, add a form validation for the login (password validation, e-mail validation, etc.)

## Most frequent mistakes to avoid:

✖ Cart loses items when you refresh the page

✖ It is impossible to change the number of items inside the cart or in the menu

✖ It is impossible to understand whether you added a pizza to the cart or not

✖ Page refreshes after every action you perform in the app

✖ No currency switch

✖ Weak form validation

✖ User can add a negative amount of pizzas and get a negative payment amount

✖ No separate page for the cart

✖ No pictures of pizzas

✖ You have to be logged in to make an order

✖ No form validation prefill for logged users

✖ No REST principles followed

✖ No readme file in repos

## 3. Technologies
✅ If you are seeking a frontend position, please use React as a frontend technology. Backend is up to your discretion.

✅ If you are seeking a backend position, please use Laravel as a backend technology. Frontend is up to your discretion.

✅ If you are seeking a full-stack position, it is preferably but not mandatory that you use Laravel/React stack.

## 4. Delivery format
✅ Please provide a link to your repository (front and back) and a direct link to the deployed version of your application (e.g.
on Heroku)

✅ Please provide a readme file for both repos

## 5. Resources
✅ Deployment of the application: any free hosting platform (e.g. Heroku) or your own server

___

### Deployment 

1. After installation on the server, you need to link storage: __php artisan storage:link__
2. Need to be manually copied to __\\storage\app\public\\__:
* The default image __not-available.png__ for products and categories
* Footer picture __pizza-1.jpg__
 
 All other pictures uploaded via the admin panel are stored there. 


#### Html tag naming.
Html tags such as id and class are styled in __kebab-case__, except when used in java script. In this case, the tags are named in __camelCase__. 

#### Features 
* There are categories and subcategories.
* Added localization and Russian language.



