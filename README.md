# coreFramework

A PHP Framework for both Website and Application Development.

#GETTING STARTED

Core Framework is a PHP7 MVC framework. It follows a component based approach where a component contains the component file and its view. A separate file which is a model handles database queries which is used by the component to render data into the browser through the view file.

#INSTALLATION
Download the framework from this page, it comes bundled in a zip file format. Extract the files in the MyApp folder into a folder which is the name of the app you want to create. Copy the folder into your PHP7 server directory.
Eg. In XAMPP, copy the folder to the htdocs folder of the XAMPP directory.

Now open the config.php file in the framework and set the variable $live_site to the corresponding name of the app on the server.
Eg. If the folder name was ‘MyApp’, change the value of the $live_site variable to ‘/MyAPP/’ or ‘http://localhost/MyApp/’.

The value of the variable is used throughout the framework as a constant called BaseUrl. This is used to reference image directory, CSS and Script files, routing etc.
Open your browser and make sure your Server(Apache) is running and open the site or app.
Remember that the framework is written in PHP7 so your server must run PHP7 and above for your app to function.

#SETTING UP THE DATABASE
The framework 2 pages which requires a database connection (person’s page and the login page). In the zip file, there is coreDB.sql file in a folder called Database. Open your database management studio. In XAMPP open the PHPMYADMIN page and create a database called coreDB. Import the sql file (coreDB.sql) into the database. Now open the config.php file and set the variables:
