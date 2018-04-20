<!DOCTYPE html>

<html>
    <?php
    require_once 'features/title.php';

    require_once 'features/menu.php';


    ?>
    <ad-right>
      <ad-header class="ad-flat bg-white">
        <button type="button" name="button" class="ad-btn ad-flat" id="ad-menu-toggle"><i class="fa fa-bars"></i> &nbsp; &nbsp; MENU</button>
        <div class="text-center logo" routerLink="<?=BaseUrl;?>">
          <img src="<?=CDN;?>images/logo/logo.png" class="img-responsive" alt="">
        </div>

        <a href='http://www.github.com/air-Design' target="_blank" class="ad-btn ad-flat rFloat" >
          <i class="fa fa-github"></i>&nbsp;  &nbsp; airDesign
        </a>
      </ad-header>
        <?php
        echo AirJax?'<router-outlet  animate="true" >':null;
        CORE::CoreApp();
        echo AirJax?'</router-outlet>':null;
        require_once 'features/footer.php';

        ?>
    </ad-right>


    </body>
</html>
