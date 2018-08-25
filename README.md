# Pure Framework
Pure is a PHP fresh and fast micro framework.
#### How To install and configure
1. Create the project using composer:
    ```php
    composer create-project vitodtagliente/pure ProjectName -s dev
    ```

2. Configure the application edititng the files under *app/Config*

    - <u>app/Config/app.ini</u> contains all the application settings
    - <u>app/Config/database.ini</u> contains database connection settings

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

#### MVC Pattern

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

3. Define views into *app/Views*:

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
#### Creating Resources

In pure is easy to add resources to the application. Type the following commands on the shell:

```powershell
- php pure app make:command ControllerName
- php pure app make:controller ControllerName
- php pure app make:middleware MiddlewareName
- php pure app make:model ModelName
- php pure app make:schema SchemaName
- php pure app make:service ServiceName
```

- Create new Commands add command line functions to your application. All commands are called by

  ```php
  php pure 'command_class_name' argument1 argument2 .... argumentN
  ```

- Controllers are used to define the behaviour of the application, following the MVC pattern.

- Middlewares are not yet implemented (Work in progress)

- Models define the datatabase data abstraction, look at [Pure ORM Component](https://github.com/vitodtagliente/pure-orm) documentation

- Schemas generate database tables. Schemas can be generated automatically by pure startup if they are registered. Schemas can be registered in 2 ways:

  - Adding the schema class name to the app/Config/app.ini

    ```ini
    ; put there the Scemas that should be created at startup time
    ; schemas[]=''
    schemas[] = 'App\Schemas\UserSchema'
    ```

  - Registering the class name directly to the pure application:

    ```php
    $app = \Pure\Application::main();
    $app->registerSchema('App\Schemas\UserSchema');
    ```

- Services are used to change the application flow

  ```php
  class CustomService extends ApplicationService {

      public function boot(){
          // at the applicatio startup
      }

      public function start(){
        // before fetching routes
      }

      public function stop(){
        // at the application exit
      }

  }
  ```

  Like Schemas, Services must be registered to the pure application adding the schema class name to the app/Config/app.ini:

  ```ini
  ; put there the Application Service classes
  ; services[]=''
  services[] = 'App\Services\CustomService'
  ```

# Customize dependencies

Install packages using composer and customize the application behaviour.
pure works on top of 4 components:

* [Pure Routing Component](https://github.com/vitodtagliente/pure-routing)
* [Pure ORM Component](https://github.com/vitodtagliente/pure-orm)
* [Pure Template Component](https://github.com/vitodtagliente/pure-template)
* [Pure Core Component](https://github.com/vitodtagliente/pure-core)

Look at their own Documentation
