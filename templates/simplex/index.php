<!DOCTYPE html>

<html>
    <?php
    require_once 'features/title.php';

    require_once 'features/menu.php';


    ?>
    <ad-right>
      <ad-header class="whiteBG">
        <button type="button" name="button" class="ad-btn ad-flat" id="ad-menu-toggle"><i class="fa fa-bars"></i> &nbsp; &nbsp; MENU</button>
        <div class="text-center logo" adRouter="<?=BaseUrl;?>">
          <img src="<?=BaseUrl;?>media/images/logo/logo.png" class="img-responsive" alt="">
        </div>

        <button type="button" name="button" class="ad-btn ad-flat rFloat" adRouter="<?=BaseUrl;?>practice"><i class="fa fa-shopping-cart"></i>&nbsp;  &nbsp; CART</button>
      </ad-header>
      <?php
      echo AirJax?'<ad-router  animate="true" >':null;
        CORE::CoreApp();
        echo AirJax?'</ad-router>':null;
        require_once 'features/footer.php';

        ?>
    </ad-right>


    </body>
</html>