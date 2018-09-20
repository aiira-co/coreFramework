<?php use Lynq\Core\Component;

?>

<header class='ad-header bg-white'>
  <div class="wrapper">
    <div class="ad-row">
      <div class="ad-colx-12">
        <h2 class='title'><?=$title?></h2>
      </div>
    </div>
  </div>
</header>

<?php Component::render('menu'); ?>

<router-outlet>
  loading
</router-outlet>
<div class=' text-center bg-dark'>

      <div class="ad-social">
        <button type="button" name="button" class="ad-btn ad-flat clear">RETURN POLICY</button>
        <br>
        <button type="button" name="button" class="ad-btn ad-flat clear">DISCLAIMER</button>
        <br>
        <a href="http://facebook.com/project-air" target="_blank" class="ad-btn ad-round ad-flat clear ad-icon"><i class="fa fa-facebook"></i></a>
        <a href="http://twitter.com/project-air" target="_blank" class="ad-btn ad-round ad-flat clear ad-icon"><i class="fa fa-twitter"></i></a>
        <a href="http://pinterest.com/project-air" target="_blank" class="ad-btn ad-round ad-flat clear ad-icon"><i class="fa fa-pinterest"></i></a>
      </div>
</div>
