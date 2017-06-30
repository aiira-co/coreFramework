<?php

// import('./practice/practice.model');

use CoreComponent as Component;
use middleWare as MW;
Component::init([
  'selector'=>'ad-practice',
  'templateUrl'=>'./practice/practice.view'
  // styleUrls=>['./practice/practice.component.css']
]);

class PracticeComponent{

    public $model;
    public $count;
    public $personData;
    public $title ='Add New Person';
    public $params;
    public $clear = false;


    function constructor(){
      $this->model = CORE::getModel('practice');
      $this->params =  CORE::getInstance('Params');
      $this->check();


    }

      function searchPerson(){
        $this->params->key = $_POST['key'];
        return CORE::component('practicedata');
      }

        function countData(){
          $this->count = $this->model->countPersons();

          return $this->count;
        }

        function blurMe(){
          return 'My email is <span class="colorYellow">'.$_POST['email'].'</span>';
        }

    function check(){

      if(isset($_POST['submite'])){

          $this->savePerson();


      }elseif(isset($_POST['update'])){
        $this->person();
        $this->update();

      }elseif(isset($_POST['deletePerson'])){

        $this->del();

      }elseif(isset($_GET['edit'])){

        $this->person();
      }
      // $this->persons();

    }



    // function persons(){
    //   $this->data = $this->model->getPersons();
    // }



    function talk(){
      echo 'talking here';
    }

    function ajaxPerson(){
      if($this->savePerson()){
        $notfy = 'successfully saved';
      }else{
        $notify = 'failed to save to db';
      }

      return $notify;
    }



    function savePerson(){

      $name = isset($_POST['name']) ? $_POST['name'] : null;
      $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
      $email = isset($_POST['email']) ? $_POST['email'] : null;

      $data = [
          'name'=>$name,
          'gender'=>$gender,
          'email'=>$email
          ];

      if($this->model->addPerson($data)){
        return 'successfully saved';
      }else{
        return 'failed to save to db';
      }


    }



    function update(){
      $data = MW::filterPost($this->personData);

      $this->model->updatePerson($data, $this->params->edit);
    }





    function del(){
      $deletePerson = $_POST['deletePerson'] ?? null;
      $this->model->deletePerson($deletePerson);
    }


    function deletePerson($id){
      if($this->model->deletePerson($id)){
        return 'Person <span class="colorTgreen">successfully</span> deleted';
      }else{
        return 'Person <span class="colorYellow">could not</span> be deleted';
      }
    }


    function person(){
      $this->personData = $this->model->getPerson($this->params->edit);
      $this->title = 'Editing Person';
      $this->clear = !$this->clear;
    }
    //create a function that its name should equal the name of an input=btn or submite form.


}

?>
