<?php


use middleWare as MW;


class PracticeComponent{

    public $model;
    public $count;
    public $personData;
    public $title ='Add New Item';
    public $params;
    public $clear = false;


    function constructor(){
      $this->model = CORE::getModel('practice');
      $this->params =  CORE::getInstance('params');

    }

      function searchItem(){
        $this->params->key = $_POST['key'];
        return CORE::component('practicedata');
      }

        function countData(){
          $this->count = $this->model->countItems();

          return $this->count;
        }






    function createNew(int $id=null){
      if(!empty($id)){
        $this->params->itemId = $id;
      }

      return CORE::component('practice-new');
    }




    function saveItem(){

      $name = isset($_POST['name']) ? $_POST['name'] : null;
      $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
      $email = isset($_POST['email']) ? $_POST['email'] : null;

      $data = [
          'name'=>$name,
          'gender'=>$gender,
          'email'=>$email
          ];

      if($this->model->addItem($data)){
        return 'Item <span class="colorTgreen">successfully</span> saved';
      }else{
        return 'Item <span class="colorYellow">could not</span>be to saved. Please try again';
      }


    }



    function updateItem(){
      $data = MW::filterPost($this->personData);
      if(!empty($data)){

        if($this->model->updateItem($data, $this->params->edit)){
          return 'Item Info has <span class="colorTgreen">successfully<span> been updated';
        }else{
          return 'Item Info has <span class="colorYellow">could not<span> be updated. Please try again';
        }
      }else{
        return ' <span class="colorYellow">No Changes<span> were made to be updated.';
      }
    }



    function deleteItem($id){
      if($this->model->deleteItem($id)){
        return 'Item <span class="colorTgreen">successfully</span> deleted';
      }else{
        return 'Item <span class="colorYellow">could not</span> be deleted';
      }
    }

}

?>
