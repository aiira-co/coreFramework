# coreFramework (PHP7.1.9+)
![alt text](https://raw.githubusercontent.com/air-Design/airUI-Design-and-Media-.Tutorial-Example/media/clientapp.JPG)
A PHP 7 Framework for both Website and Application Development. We have also added 'airJax' a javascript framework for Single Page Application experience. It also enables you to call php functions or methods with events from the component of the view's file.
* eg

```html
  <button (click)="addPerson()">
    Save New
  </button>
```

This will call the addPerson() method in the component when a user clicks of the button.
This function or framework will only work when its enabled in the 'confile.php' file

## GETTING STARTED

Core-Framework is a PHP7 MVC framework. It follows a component based approach where a component contains the component file and its view. A separate file which is a model handles database queries which is used by the component to render data into the browser through the view file.

### INSTALLATION
Download the framework from this page(github), it comes bundled in a zip file format.
The zip file "coreFramework-master.zip" contains a folder called "coreFramework". Extract that folder into a PHP7 Server root directory.
* Eg. In XAMPP, the root director is "htdocs" folder of the XAMPP directory.

* [OPTIONAL] Now open the config.php file in the framework and set the variable "$live_site" to the corresponding folder_name of the app on the server.

* Eg. If the folder name was ‘MyApp’, change the value of the $live_site variable to ‘/MyAPP/’ or ‘http://localhost/MyApp/’. If you did not change the name, it should be "coreFramework".

* This variable is used to set the BaseUrl constant for the application.
If the value of "$live_site" is_empty, the framwork will automatically generate a BaseUrl constant for it.
  * If the value is left empty, coreFramework will automatically generated the BaseUrl constant behind the scene.


* The value of the variable is used throughout the framework as a constant called BaseUrl. This is used to reference image directory, CSS and Script files, routing etc.
Open your browser and make sure your Server(Apache) is running and open the site or app.
Remember that the framework is written in PHP7 so your server must run PHP7 and above for your app to function.

![alt text](https://raw.githubusercontent.com/air-Design/airUI-Design-and-Media-.Tutorial-Example/media/reel.JPG)

# SETTING UP THE DATABASE
The app contains tow(2) pages which requires a database connection (pratice page and the login page). In the app(coreFramework) folder, there is a coredb.sql file in a folder called (database file). Open your database management studio. In XAMPP open the PHPMYADMIN page and create a database called coredb. Import the sql file (coredb.sql) into the database.
The 'database file' folder can be deleted.

Now open the config.php file and set the variables:

*	$dbtype = meaning the database type,
  *	if its MySQL or MySQLi, enter ‘mysqli’ .
  *	if its Microsoft SQL enter ‘mssql’.
  *	Oracle ->  enter ‘oracle’

*	$host => where the database is hosted. eg: 'localhost'
*	$db => the corresponding database name you just created, in this case "coredb".
*	$user => the username to access your database (default is root).
*	$password => The password to access the database (leave empty if no password is related).
*	$db_prefix => The table prefix for the database if any.

eg:

```php
public $dbtype = 'mysqli';
public $host='localhost';
public $db = 'coredb';
public $user='root'
public $password='';
public $db_prefix='';

```
Now go to the practice/client page on the framework, if all things are properly set, the page should display correctly with some data from the database being displayed on the table. In this page, you can decide to add new client, edit cleint's info, and delete a client. Try them.

You can also go to the login page, just go back to the home page, scroll down and click on the account button. This should take you to the login page.

### Credentials are:
*	Username: admin
*	Password: admin123

* After authentication, you should be able to view the account page. Authentication to view a page is set at the "app.router.php" file.

# Understanding the framework

When ever a page is requested or routed, the url is sent to the 'app.router.php' file, which then
checks if the 'path' matches the url, if yes the framework now renders the coresponding component to the browser.

## CONFIG.PHP
* The file is the configuration file of the application.
  * It’s a class with default varibales such as offline (to determine if the application is available to view or under development), host, dbname, dbuser, dbpass, dbprefix etc.
* These values are used by the framework to run the application. Any changes made to these values must be valid else the app will turn off.

## INDEX.PHP
Index.php file: This is the default file which check the config.php file for offline value, start the session and set CONSTANTS for the application.
* You are advised not to alter this file except you know what you are about.


## TEMPLATES FOLDER
This contains the templates or themes for the application or website.
* The 'config.php' file have a variable called template which tells the application which template to use. The value for the template variable must match the name of the template in the templates folder.
* There are tutorials on creating your own templates, or you can decide to download some of our free templates here online.

## COMPONENTS FOLDER
The 'components' folder contains all the components for the application. These components represent the individual pages of the application.

Each component here represents a page in the website or application. Components are created in the components folder in an independent folder. This way, the application Is organized and the components are reusable in other applications.

## Creating a Component
* Open the component folder and create a new folder. The folder name should match the name of the component you want to create. (Let us consider creating a component to view users.) Hence the component folder should be named users.

* In the 'users' folder, create two PHP files.
  * Every component must contain a [name].component.php and [name].view.php. (where [name] represent the name of the component or page).

* For example, to create a page to display list of users, we could decide to name the component users.component.php and users.view.php, contained in a folder called users.
* We advise that every component must be within a folder having the name of the component itself.
* The user.component.php file here handles all the php logics and variable which are made available for the view file. It could be considered as the controller of the MVC framework.
* The users.view.php file is rendered in the browser as the user’s page.

This is how  the users.component.php will look like.
* The class name must match the name of the component.

```php
<?php

class UsersComponent
{

    public $title="Users component works!";

    function onInit()
    {
    }
}

```

then the 'users.view.php' file could look like so:

```php

  <h1><?=$title;?></h1>

```
## Routing
Though the users component is created, we have not created any route to get to that component. To do so, we open the app.router.php file at the root directory of the framework.

* The app.router.php file registers a url to a component, so that whenever the url matches the one registered, the binding component (page) is displayed.

* Create a variable called $users. The variable must be an array with members
  * path: the url to bind the component to. In this case, input 'users' as the value for this array member.
  * component: this should correspond to the component folder name in the components folder. In this case, the folder name is 'users'
  * title: this is the title that displayed at the browser’s tab when the component or page is view. This member can be omitted.

  * The $users variable should look like:
    * $users = ['path'=>'users', 'component'=>'users', 'title'=>'users page'];

* The above variable is not yet registered as a route. To register the variable, add it as a member to the '$appRoutes' array . Like so:
  * $appRoutes=[..., $users];

```PHP
 $users = [
            'path'=>'users', // http://127.0.0.1/users the router looks if the url matches the path, hence users. i.e http://domain.com/{{path}}
            'component'=>'users', // Component to go when the path matches the url given
            'title'=>'users page' // Page title to display at the browsers tab
            ];

$appRouter = [
  ['path'=>'/', 'component'=>'app', 'title'=>'Welcome Home'],
 $users

];

$appRouterModule = CORE::getInstance('Router'); //creates an instance of the router class
$appRouterModule->setRouter($appRouter); //registers the routers

```
* Now the users component is available to the router to view in the browser. Enter the server name to the App and add the path of the component ('users'). I.e
  * http://localhost/MyApp/users.
  * This should display the users component and the $title variable should be echo-ed to the screen.

* To learn more about routing, click here

* Note: every public varible in the component class can be directory called it's view file.
  you will see the string 'Users component works!' when the page is viewed at that component.

### AUTHGUARD
* Authentication and Authorization is key in Application development and coreFramework already has this feature implemented for you.
* 'authguard' is also a member of the routes and takes arrays of models name as strings which are used to authorize clients to access the component.
* example:

```PHP

$appRouter = [
  //App Component does not contain any Authorization
  ['path'=>'/', 'component'=>'app', 'title'=>'Welcome Home'],

  //Users Component contains Authorization
  [
  'path'=>'users',
  'component'=>'users',
  'title'=>'users page',
  'authguard'=>['authenticate'] // authguard checks a method 'canActivate():bool' in the model authenticate.model
  ];

];

$appRouterModule = CORE::getInstance('Router'); //creates an instance of the router class
$appRouterModule->setRouter($appRouter); //registers the routers

```
* The authguard member checks the method 'canActivate():bool' in the model authenticate.model which expects a boolean return.
  - If the canActivate method returns true, then the component or page loads
  - if false, page does not loads and the developer has the freedom to redirect the user to login page or home.
* Example of the authenticate model is as follows:


```php

<?php

class AuthenticateModel{

  // This method is used by the routing class to allow or disabllow a route to the component
  function canActivate(string $url):bool{
    if (CoreSession::IsLoggedIn()) {
      return true;
    }else{
        Core::redirect(BaseUrl.'account/login',$url);
        return false;
    }
  }


}

```

* The $url parameter of the method is automatically passed in by coreFramework: That is, the path you are trying to access.

* CoreSession::IsLoggedIn() is a static method in coreFramework used to check if a users is LoggedIn.
  - This method specifically checks if the $_SESSION['id'] isset.
  - Apart from using tghe in-build authentication at CoreSession you could write your own code to check if a user is logged in.


## MODELS FOLDER
This folder contains model files for database queries.
For legibility and separation of concerns, use the models for database related scripts and the component file for logics.

* Every model must contain a [name].model.php (where [name] represent the name of the model or component the model is related to).

* Example of user.model.php.

```php
<?php

use CoreModel as DB;

class UserModel
{

    private $table='users';

    function getUsers()
    {
        return DB::table($this->table)
                    ->get();
    }

    function getUser(int $id)
    {
        return DB::table($this->table)
                    ->where('id', $id)
                    ->get();
    }
}

```


* To get to an instance of the model in the component,
  * Create a private varible in the component called '$dataModel'
  * In the 'constructor()' method, get the model with 'CORE::getModel('user');

```php

class UsersComponent
{

    public $title="Users component works!";
    private $dataModel;

    function constructor()
    {
      $this->dataModel = CORE::getModel('user');
    }
}


```

* CORE:: makes reference the coreFrameworks 'core class' which contains static methods like
  * getModel('modelName') --> for instantiating a model
  * getInstance('className') --> for instantiating a core class 'params' and components.
  * component('componentName') --> for rendering a component within a component.

In  this case, ``CORE::getModel('user')`` looks into the models folder for the model file user.model.php, then it now instantiate it with 'UserModel'.
* It takes the 'model name' paramenter, and also a 'path' parameter to point to a custom folder the model exists.


* Now that we have the model in the component, we can easily get the data of all users or a single user from the model in the component.

```php

class UsersComponent
{

    public $title="Users component works!";
    private $dataModel;

    //create a variable to hold data
    public $data;

    function constructor()
    {
      // instantiate the model
      $this->dataModel = CORE::getModel('user');

      if(isset($_GET['id'])){
        $this->getSingleData($_GET['id']);
      }else{

        // get data
        $this->getData();
      }
    }

    function getData()
    {
      $this->data = $this->dataModel->getUsers();

    }

    function getSingleUser($id)
    {
      $this->data = $this->dataModel->getUser($id);

    }

}


```


* Rather than using the '$_GET' global variable, coreFramework has a class called params, which stores any POST or GET in it.
* A more pleasing way would be to use the params class.
  * Create private variable called $params, then instantiate it at the 'onInit()' method
  with CORE::getInstance('params');


```php

class UsersComponent
{

    public $title="Users component works!";
    private $dataModel;
    private $params;
    //create a variable to hold data
    public $data;

    function onInit()
    {
      // instantiate the model
      $this->dataModel = CORE::getModel('user');

      // instantiate params
      $this->params = CORE::getInstance('params');

      if(isset($this->params->id)){
        $this->getSingleData($this->params->id);
      }else{

        // get data
        $this->getData();
      }
    }

    function getData()
    {
      $this->data = $this->dataModel->getUsers();

    }

    function getSingleUser($id)
    {
      $this->data = $this->dataModel->getUser($id);

    }

}


```

* Now that we have the data from the model stored in the '$data' variable, we can call it in the view file of the component since the variable is declared as public.
* We expect '$data' to be a row of objects and will probably have a 'name' field, hence...

```php
  <h1><?=$title;?></h1>

  <ul>

    <?php foreach ($data as $user){?>

    <li><?=$user->name;?></li>  

    <?php } ?>
  </ul>

```


* In the model file, you realise a that we make use of the 'CoreModel' namespace with an alias 'DB',
```php
  <?php

use CoreModel as DB;

class UserModel
{
  ...
}

```

## CoreModel
You might find in a 'model file', 'component file(not the best for coreFramework)' or 'controller file(cQured web-api)' a
```php
<?php

use CoreModel as DB;

```

This is a library written to easily query database.
* Let us consider a database table called 'user'.

```php
<?php

class interface IUser{
    private id;
    private name;
    private gender;
    private email;

}

class class User implements IUser{
    public id=0;
    public name='';
    public gender='';
    public email='';

}
```

* Remember the database settings are already made in the config.php file.
*   To query the table
**  These returns a row of objects

* 'DB' here is the alias or represents the 'CoreModel' class

*   Query any SQL statement :
```php
DB::sql('SELECT * FROM users t WHERE u.age > 45 LIMIT 10 ORDER BY u.name')
        ->get();
```

*   SELECT All Users :
```php
DB::table('user')
          ->get();
```

*   SELECT All Users DISTINCT:
```php
DB::table('user')
          ->distinct();
```


*   Count All Users :
 ```php
 DB::table('user')
          ->count();
 ```

*   SELECT All Users with only id and name Fields:
```php
DB::table('user')
          ->fields('id, name')
          ->get();
```


*   SELECT All Users with only id and name Fields 'AS' username:
```php
DB::table('user')
          ->fields('id, name AS username')
          ->get();
```


*   SELECT All Users Limit to 10:
```php
 DB::table('user')
          ->limit(10)
          ->get();
```


*   SELECT All Users Limit to 10 Offset 100:
 ```php
 DB::table('user')
          ->limit(10)
          ->offset(100)
          ->get();
```


*   SELECT First User in Users row :
 ```php
 DB::table('user')->first();
```

*   SELECT Last User in Users row :
 ```php
 DB::table('user')->last();
```

*   SELECT All Users Order by name DESCENDING :
 ```php
 DB::table('user')
        ->orderBy('name')
        ->get();
```

*   SELECT All Users Order by ASCENDING :
```php
DB::table('user')
          ->orderBy('name',2)
           ->get();
```

*   SELECT User with id == 3 :
```php
DB::table('user')
        ->where('id',3)
    	  ->get();
```

*   SELECT User with id != 3 :
```php
DB::table('user')
        ->where('id','!=',3)
        ->get();
```

*   SELECT User with id < 3 :
```php
DB::table('user')
        ->where('id','<',3)
        ->get();
```
*   SELECT User with id > 3 :
```php
DB::table('user')
          ->where('id','>',3)
          ->get();
```    

*   SELECT User with id <= 3 :
```php
DB::table('user')
          ->where('id','<=',3)
          ->get();
```

*   SELECT User with name LIKE 'kel' :
```php
DB::table('user')
          ->where('id','LIKE','%kel%')
          ->get();
```

**  These returns a single object
*   SELECT A Single User with id == 3 :
```php
DB::table('user')
          ->where('id',3)
          ->single();
```

*   SELECT Users with id == 3 or name = 'kelvin' :
```php
DB::table('user')
          ->where('id',3)
          ->orWhere('name','kelvin')
          ->get();
```
*   SELECT Users with id == 3 and name = 'kelvin' :
```php
DB::table('user')
          ->where('id',3)
          ->andWhere('name','kelvin')
          ->get();
```    
**  These returns a true or false if its sucessfull or failed
*   INSERT New User:
```php
$data = [
  'name'=>'kelvin',
  'email'=>'kelvin@air.com',
  'gender'=>'male'
  ];
DB::table('user')
          ->add($data);
```    
*   UPDATE User with id = 3 :
```php
$data = [
  'name'=>'kelvin',
  'email'=>'kelvin@air.com',
  'gender'=>'male'
  ];
DB::table('user')
          ->where('id',3)
          ->update($data);
```   
*   DELETE User with id = 3 :
```php
DB::table('user')
          ->where('id',3)
          ->delete();
```
* JOIN queries
    *   SELECT * FROM Users u and INNER JOIN comments c ON u.id == c.userId
```php
DB::table('user u')
        ->join('comment','c')
        ->on('u.id','c.userId')
        ->get();
```

*   SELECT * FROM Users u and LEFT JOIN comments c ON u.id == c.userId
```php
DB::table('user u')
    ->leftJoin('comment','c')
    ->on('u.id','c.userId')
    ->get();
```

*   SELECT * FROM Users u and RIGHT JOIN comments c ON u.id == c.userId
```php
DB::table('user u')
    ->rightJoin('comment','c')
    ->on('u.id','c.userId')
    ->get();
```

*   The letter 'u' in the table method after the table name 'user' is the alias of the table.
*   There also is the rightJoin, leftJoin, innerJoin, fullJoin

* GROUP BY
*   SELECT Users u and RIGHT JOIN comments c ON u.id == c.userId GROUP BY u.id
```php
DB::table('user u')
    ->rightJoin('comment','c')
    ->on('u.id','c.userId')
    ->groupBy('t.id')
    ->get();
```

* MULTI DATABASE            
*   SELECT identityDB.Users u and INNER JOIN blogDB.comments c ON u.id
```php
DB::table('identityDB.user u')
    ->join('blogDB.comment','c')
    ->on('u.id','c.userId')
    ->groupBy('t.id')
    ->get();
```

## ASSETS FOLDER
* This contains the media content and document  of the application. The sub folder in this folder are images, videos and audio.
* The folder contains airDesign CSS Framework files which comes by default with the coreFramework.
  - 'css' folder for air.design.css, font-awesome.min.css
  - 'fonts' contain airdesign's default font 'bariol' and font-awesome's
  - 'js' folder contains jquery library, air.design.js file and airJax.js.
  - 'airJax.js' file is a javascript framework written to enhance coreFramework for Single Page Application Experience. it also comes with event handlers which we will go further down this page.

* The logo and favicon of the application is stored in the images folder here. Images of the users, persons and items related to the database are also stored here I separate folders with their respective names.
* This way all the media content are properly organized and optimized for future updates and backward compatibility if the need arise.
* Downloadable files are also placed in the assets folder.

## CORE FOLDER
* This folder contains the files for the framework and legacy file for the database and component management.
* The Framework's core scripts are stored in this folder. DO NOT TOUCH IT; except you know what you are about and plans to extend this framework.


## Composer
You can extend the framework to use other php scripts via composer.



# airJax

AirJax makes your Web Application experience the behavior of native desktop application by
turning your project into an Single Page Application(SPA).

## AJAX for Single Page Application(SPA)

At the index file of each template of coreFramework, we call 'router-outlet' element.
This is the place where the html results will be rendered when the page routes with airJax's routing

* routerLink -- routes to the page you wants to display. use href in <a> if you want the page to refresh
* routerLinkActive -- This attribute takes a class as a value. When the page routes with routerLink, if the routerLink element or child contain the routerLinkActive attribute, the class value of the routerLinkActive attribute is set to that element

##  Events
Each time an event fires, the ``return value`` from the method is displayed in airdesign's notifier.

  * At the [componentName].view.php file
```html
  <button (click)="newPerson('Kelvin')" >
    Save New
  </button>
```
  * At the [componentName].component.php file


```php

  class NameComponent{

    public function newPerson(string $name){
      return 'my name is '.$name;
    }
  }

```
* To change element you want the return string to load, add the attribute [outlet]='#elementId' afer the event has been declared on an element.

* If you are sure the data to be return is an html format, add the attribute [data-type]='html' to the element, by default the 'data-type' is 'json' for every event.

  * At the [componentName].view.php file
```html
  <button (click)="recordPage()" [outlet]="summary" [data-type]="html">
    Add New
  </button>

  <!-- OR, you can ommit the data-type attrubute, and it will automatically assume html if outlet attribute is present-->
  <button (click)="recordPage()" [outlet]="summary">
    View Records
  </button>

  <div id="summary">
    add or view person detail
  </div>
```
  * At the [componentName].component.php file


```php

  class NameComponent{

    public function newPersonPage(){
      // this will call the new-person.component.php with its view to render
      //  Therefore the return type of this action is an html
       CORE::component('new-person');
    }

    public function recordPage(){
      echo '<h1>Record Page</h1>';
    }
  }

```

* Once the event is fired, airjax takes the method, outlet, and data-type attribute,
  * Process the method to find if there are any parameters, breaks down the method into
  strings params, then sends it to coreFramework to inteperate,
  * Identifies the component, checks if the method exists in the component and then call the method.
  * Upon respond, the return value from the ajax call is stored in a variable, then placed in the
  outlet attribute is any (in this case the element with an id summary) or airdesign's notifier.


* (click) -- handles click event
* (submit) -- handles the submit even in a form
* (blur) -- handles blur event for only input elements $(input).blur
* (change) -- handles change event that occurs in an input or select element $(input, select).change

* (keypress) -- handles keypress events for only inputs $(input).keypress. ca be used for autocompleting
* (keydown) -- handles keydown events for only inputs $(input).keydown
* (keyup) -- handles keyup events for only inputs $(input).keyup

* (mouseenter) -- mouse enter event $.mouseenter
* (mouseleave) -- mouse leave event $.mouseleave
* (mousedown) -- mouse down event $.mousedown
* (mouseup) -- mouse up event $.mouseup
* (mousemove) -- mouse move event $.mousemove
* (mouseover) -- mouse over event $.mouseover

* (modal)-- this causes a pop-up event with ajax loading into ad-modal
* (adSync) -- this causes the page to continuesly check for update every 10 second. if update is found, load.. hence autorefresh. its good to be used for table data, chat or messaging and notification
