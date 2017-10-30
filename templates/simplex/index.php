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
          <img src="<?=BaseUrl;?>assets/images/logo/logo.png" class="img-responsive" alt="">
        </div>

        <button type="button" name="button" class="ad-btn ad-flat rFloat" adRouter="<?=BaseUrl;?>practice"><i class="fa fa-user-circle"></i>&nbsp;  &nbsp; CLIENT</button>
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
