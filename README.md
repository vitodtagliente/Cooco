# Pure Framework
Pure is a PHP fresh and fast micro framework.
#### How To install and configure
1. Create the project using composer:
    ```php
    composer create-project vitodtagliente/pure ProjectName -s dev
    ```

2. Configure the application edititng the files under *app/Config*

3. Generate the project key with the command

    ```bash
    php pure app generate:key
    ```

4. Run the application
    ```php
    php -S localhost:8000
    ```
#### How to Update pure

To update the framework and all the dependencies, run the following command:

```bash
composer update
```

Each time the file composer.json is changed, run the following command:

```
composer dump-autoload
```

#### Customize the application

Pure follows the MVC pattern, it means that the behaviour is defined by Controllers and routes.
1. Edit the file *app/Routes/web.php* and define the application routes:
    ```php
    <?php

    router()->get('/', 'App\\Controllers\\WelcomeController@index');

    ?>
    ```

2. Put controllers into the path: *app/Controllers*:
    ```php
    <?php

    namespace App\Controllers;
    use Pure\Controller;
    use Pure\Template\View;

    class WelcomeController extends Controller {

        function index(){
            view('welcome.php');
        }

    }

    ?>
    ```

    Controllers can be added to the project typing the command:

    ```bash
    php pure app make:controller ChooseTheNameController
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
pure works on top of 4 components:

* [Pure Routing Component](https://github.com/vitodtagliente/pure-routing)
* [Pure ORM Component](https://github.com/vitodtagliente/pure-orm)
* [Pure Template Component](https://github.com/vitodtagliente/pure-template)
* [Pure Core Component](https://github.com/vitodtagliente/pure-core)

Look at their own Documentation
