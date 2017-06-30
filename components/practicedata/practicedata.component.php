<?php

use middleWare as MW;

class PracticedataComponent{

    public $model;
    public $data;
    public $personData;
    private $key='';



    function constructor(){
      $this->model = CORE::getModel('practice');
      $this->params =  CORE::getInstance('Params');
      $this->key = $_POST['key']??'';
      $this->persons();
    }

    function persons(){

      $this->data = $this->model->getPersons($this->key);
    }



}

?>
