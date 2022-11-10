

# PHP eCommerce Rule engine

The essence of this project is to create an engine embedded in a web application/webshop to fulfill the following criteria:

- Case A:
You’re a repeat Customer & you’re ordering more than 4 pcs of
different hoodies.
5 € Off the total
- Case B:
You ordered 2 pieces of the same product
Get the first one free
- Case C:
You never ordered before. Get the special “OneHoodie” for free
- Case D:
Entering the PromoCode - Welcome1337
Free Purchase
- Case E:
When there’s ProductA / ProductB in the cart - get first one free

As the main focus of this project is on the engine, the user interface has limited options, however, some basic features are required to demonstrate all cases. These include:
- registration, logging in and out in order to keep record of users and if they have previous orders or not (Deal C).
- order: the central part of the project: on frontend, there is a simple page where the user can add or remove hoodies to/from the cart. The order can also be sent on this page.

Missing features which would be required for production:
- option for the user to add delivery addresses
- payment provider integration
- forgotten password option at logging in
- email sending option to alert user for the followings: order received, order prepared, order sent, order delivered
- UI  polishing
- more products
- ...

## User documentation
The user interface is rather simple and intuitive: we can navigate through pages using the top navbar. The following functions are working right now:
- login/logout
- register
- order hoodies
- check previous orders
In order to send orders, we need to login. If user has not been registered, 

## Developer documentation
The application was written in *PHP8*, using the *Laravel* framework.
Further languages used:
- *JavaScript*
- *CSS*
- *HTML*
- and a little bit of *SQL*

During developing this project, XAMPP was used: it consists of an apache and a mysql/mariadb server.

[Installation of XAMPP can be found here](https://www.wikihow.com/Install-XAMPP-for-Windows)

[Installation of Laravel can be found here](https://laravel.com/docs/9.x/installation)


### Design pattern
Laravel uses the MVC design pattern: models, views and controllers have separate functions: controller is in the center, it sends the appropriate requested view/API response to the user. When request comes, the controller passes it to the respective model, which in turn carries out the database manipulations or calculations.

### Configuration
In terms of backend configuration, the /config directory contains vital information on various features. In this case, the most important is the database connection. /config/database.php defines the connectors, and reads out the enviromental variables from the .env file.

### Routes
Routing happens in the following order:
1. web.php or api.php in the routes directory gets read in accordance with the requested page. 
2. If (and hopefully the requested page is) in one of them, the appropriate controller and its method is selected to transmit request.
3. The controller then either reads out the input parameters and calls method files or just simply return a page or json data. 

### Authentication
The application uses the built-in function of authentication: the *User* model contains pieces of information what user data should be stored. By default, during login, the authentication happens against the username/email and password. The Illuminate\Foundation\Auth class will store the user information if login succeeds. 

### Session variables
Apart from authentication, further session variables are used for the functionalities of this app.

These are:
- list of ordered products by their ids
- Supplied promo code

If a user adds or removes anything to/from their cart, it will be stored in the session('order.items') variable. The respective variable for the promo code is session("promoCode").

This way, we rely only on these variables when storing order.

One important point: every time, item is added or removed from the cart, the user interface on the order page refreshes in order to keep frontend with backend synchronized.

### Directories
Keeping in mind of the MVC principles, the respective directories are the following:
- Model: app/Models
- View: resources/views
- Controller: app/Http/Controllers

In this project, I didn't use Middlewares, Components etc., as these functionalities were not required at this stage.

### Migration and seeding
Database schemas/tables have been created using migrations. The table definitions can be found in the following link:
**database/migrations**
Three tables were created this way:
- **User**: storing id, username, password, email, is_valid and dates attributes with no foreign keys; primary key: id
- **Item**: storing hoodie item attributes, like id, name, price, is_valid and dates with no foreign keys; primary key: id
- **Order**: storing id, user_id, item_id, count and dates with the following foreign keys: user_id->User.id, item_id->Item.id; primary key: [id, user_id, item_id]

Seeder (Fill up table with data) can be found in
**database/seeders
Item table filled in this way, with 6 test hoodies

### Deals handling and final price calculation
Calculating the final price based on pre-defined rules are carried out by the following model file:
/app/Models/HoodiePriceComputer

It reads the pre-defined rules, which are located in a json file: storage/special_deals.json. Its structue is self-explanatory.
The HoodiePriceComputer goes through these rules/deals one by one, with one twist: deal D assessed at the end, as promo code is supplied, the total order will be free, no previous reductions are valid any more.
During assessing rules, if one or more requirements are fulfilled, the price reduction and a message text will be added to an array. This, together with the full price and the reduced price will be sent back to the FrontEnd for processing.

### Tests
Unit tests have been created to test deals handling. These are located in tests/Unit
Five files can be found there, reflecting which Deals to test. The functions inside these classes contain the test cases.