# coreFramework

A PHP Framework for both Website and Application Development.

# GETTING STARTED

Core Framework is a PHP7 MVC framework. It follows a component based approach where a component contains the component file and its view. A separate file which is a model handles database queries which is used by the component to render data into the browser through the view file.

# INSTALLATION
Download the framework from this page(github), it comes bundled in a zip file format. 
The zip file "coreFramework-master.zip" contains a folder called "coreFramework". Extract that folder into a PHP7 Server root directory.
Eg. In XAMPP, the root director is "htdocs" folder of the XAMPP directory.

**OPTIONALL** Now open the config.php file in the framework and set the variable "$live_site" to the corresponding folder_name of the app on the server. 

Eg. If the folder name was ‘MyApp’, change the value of the $live_site variable to ‘/MyAPP/’ or ‘http://localhost/MyApp/’. If you did not change the name, it should be "coreFramework".

This variable is used to set the BaseUrl constant for the application.
If the value of "$live_site" is_empty, the framwork will automatically generate a BaseUrl constant for it.
I


The value of the variable is used throughout the framework as a constant called BaseUrl. This is used to reference image directory, CSS and Script files, routing etc.
Open your browser and make sure your Server(Apache) is running and open the site or app.
Remember that the framework is written in PHP7 so your server must run PHP7 and above for your app to function.

# SETTING UP THE DATABASE
The app contains tow(2) pages which requires a database connection (pratice page and the login page). In the app(coreFramework) folder, there is a coreDB.sql file in a folder called Database. Open your database management studio. In XAMPP open the PHPMYADMIN page and create a database called coreDB. Import the sql file (coreDB.sql) into the database. 

Now open the config.php file and set the variables:
•	$dbtype = meaning the database type, 
  o	if its MySQL or MySQLi, enter ‘mysqli’ . 
  o	if its Microsoft SQL enter ‘mssql’. 
  o	Oracle ->  enter ‘oracle’ 

•	$host => where the database is hosted. eg: localhost
•	$db => the corresponding database name you just created, in this case "coreDB". 
•	$user => the username to access your database (default is root). 
•	$password => The password to access the database (leave empty if no password is related). 
•	$db_prefix => The table prefix for the database if any.


Now go to the practice/client page on the framework, if all things are properly set, the page should display correctly with some data from the database being displayed on the table. In this page, you can decide to add new client, edit cleint's info, and delete a client. Try them. 

You can also go to the login page, just go back to the home page, scroll down and click on the account button. This should take you to the login page. 

#Credentials are: 
•	Username: admin 
•	Password: admin123 

After authentication, you should be able to view the account page. Authentication to view a page is set at the "app.router.php" file.