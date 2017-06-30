<!DOCTYPE html>

<html>
    <?php
    require_once 'features/title.php';

    require_once 'features/menu.php';



    echo AirJax?'<ad-router  animate="true" >':null;
     CORE::CoreApp();
     echo AirJax?'</ad-router>':null;
   require_once 'features/footer.php';

   ?>


    </body>
</html>
