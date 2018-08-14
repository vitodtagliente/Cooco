# Pure Framework
Pure is a PHP fresh and fast micro framework.
#### How To install and configure
1. Create the project using composer:
    ```php
    composer create-project vitodtagliente/pure ProjectName -s dev
    ```
2. Configure the framework editing the file config.php
3. Run the application
    ```php
    php -S localhost:8000
    ```
#### Customize the application
Pure follows the MVC pattern, it means that the behaviour is defined by Controllers and routes.
1. Edit the file routes/web.php and define the application routes:
    ```php
    <?php

    $router = Pure\Application::main()->router();
    $router->namespace("App\\Controller\\");

    $router->get('/', 'WelcomeController@index');

    ?>
    ```
2. Put controllers into the path: app/controllers:
    ```php
    <?php

    namespace App\Controller;
    use Pure\Controller;
    use Pure\Template\View;

    class WelcomeController extends Controller {

        function index(){

            View::make('welcome.php');

        }

    }

    ?>
    ```
3. Define views into app/views:
    ```html
    <html>
    <head>
        <title>pure</title>
    </head>
    <body>
        <h1>Hello Pure!</h1>
    </body>
    </html>
    ```
# Customize dependencies
Install packages using composer and customize the application behaviour.
The entire framework works on top of 3 components:
* [Pure Routing Component](https://github.com/vitodtagliente/pure-routing)
* [Pure ORM Component](https://github.com/vitodtagliente/pure-orm)
* [Pure Template Component](https://github.com/vitodtagliente/pure-template)

Look at their own Documentation
