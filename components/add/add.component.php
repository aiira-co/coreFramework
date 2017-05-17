<?php


class AddComponent{

  public $title = 'Hello Addition';
  public $ans;

  function constructor(){

    $params = CORE::getInstance('Params');

    $this->ans = $params->x + $params->y;
  }

}

 ?>
