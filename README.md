# Pure Framework

Pure is a PHP fresh and fast micro framework.



## How To install and configure

1. Create the project using composer:

   ```bash
   composer create-project vitodtagliente/pure ProjectName -s dev
   ```

2. Configure the framework editing the config files placed into $path/app/Config/

3. Generate the project key

   ```bash
   php pure generate:key
   ```

4. Run the application

   ```bash
   php -S localhost:8000
   ```



## The pattern MVC

Pure follows the MVC pattern.

1. All pure routes are defined inside the path: <u>*path/app/Routes/*</u>.

   By default the application's routes are loaded from the file `web.php`

   ```php
   <?php
   
   router()->get('/', 'App\\Controllers\\WelcomeController@index');
   
   ?>
   ```

2. Put controllers into the path: <u>*path/app/Controllers*</u>.

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

3. Define views inside of <u>*path/app/Views*</u>

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



## Managing config settings

Inside the path <u>*path/app/Config*</u> are placed all the project's config files. In that folder all kind of custom config file can be placed. For example, define the following config file <u>custom.ini</u>:

```ini
; Comments, test ini file
one = 1
key = "test"
```

To retrieve these options inside your application 

```php
$one = Pure\Config::get('custom::one');
// or
$one = config('custom::one');
```



## Customize dependencies

Install packages using composer and customize the application behaviour.
The entire framework works on top of 3 components:

- [Pure Routing Component](https://github.com/vitodtagliente/pure-routing)
- [Pure ORM Component](https://github.com/vitodtagliente/pure-orm)
- [Pure Template Component](https://github.com/vitodtagliente/pure-template)

Look at their own Documentation