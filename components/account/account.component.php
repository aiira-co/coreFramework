<?php

class AccountComponent{

  public $data = 'Welcome back ';

  function onInit(){
    $this->data .= $_SESSION['user_session'];
  }
}

?>
