Pure Framework

Pure is a PHP fresh and fast micro framework.



How To install and configure

1. Create the project using composer:
       composer create-project vitodtagliente/pure ProjectName -s dev
2. Configure the framework editing the config files placed into $path/app/Config/
3. Generate the project key
       php pure generate:key
4. Run the application
       php -S localhost:8000



The pattern MVC

Pure follows the MVC pattern.

1. All pure routes are defined inside the path: path/app/Routes/.
   By default the application's routes are loaded from the file web.php
       <?php
       
       router()->get('/', 'App\\Controllers\\WelcomeController@index');
       
       ?>
2. Put controllers into the path: path/app/Controllers.
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
3. Define views inside of path/app/Views
       <html>
       <head>
           <title>pure</title>
       </head>
       <body>
           <h1>Hello Pure!</h1>
       </body>
       </html>



Managing config settings

Inside the path path/app/Config are placed all the project's config files. In that folder all kind of custom config file can be placed. For example, define the following config file custom.ini:

    ; Comments, test ini file
    one = 1
    key = "test"

To retrieve these options inside your application 

    $one = Pure\Config::get('custom::one');
    // or
    $one = config('custom::one');



Customize dependencies

Install packages using composer and customize the application behaviour.

The entire framework works on top of 3 components:

- Pure Routing Component
- Pure ORM Component
- Pure Template Component

Look at their own Documentation
