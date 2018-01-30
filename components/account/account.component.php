<?php

class AccountComponent{

  public $data = 'Welcome back ';

  function constructor(){
    $this->data .= $_SESSION['user_session'];
  }
}

?>
