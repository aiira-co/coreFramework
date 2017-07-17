<h2>This is Offline Page</h2>


    <img src="<?=$adConfig->offline_image;?>" alt="">
<?php

    if($adConfig->display_offline_message)
        echo $adConfig->offline_message;


?>