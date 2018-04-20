<?php


use middleWare as MW;

class PracticeComponent
{
    public $title ='Add New Item';
    public $clear = false;
    public $count;
    public $personData;


    private $params;
    private $model;



    public function onInit()
    {
        $this->model = CORE::getModel('practice');
        $this->params =  CORE::getInstance('params');
    }

    public function searchItem()
    {
        $this->params->key = $_POST['key'];
        return CORE::component('practicedata');
    }

    public function countData()
    {
        $this->count = $this->model->countItems();

        return $this->count;
    }






    public function createNew(int $id = null)
    {
        if (!empty($id)) {
            $this->params->itemId = $id;
        }

        return CORE::component('practice-new');
    }




    public function saveItem()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;

        $data = [
          'name'=>$name,
          'gender'=>$gender,
          'email'=>$email
          ];

        if ($this->model->addItem($data)) {
            return 'Item <span class="color-tgreen">successfully</span> saved';
        } else {
            return 'Item <span class="color-yellow">could not</span>be to saved. Please try again';
        }
    }



    public function updateItem()
    {
        $data = MW::filterPost($this->personData);
        if (!empty($data)) {
            if ($this->model->updateItem($data, $this->params->edit)) {
                return 'Item Info has <span class="color-tgreen">successfully<span> been updated';
            } else {
                return 'Item Info has <span class="color-yellow">could not<span> be updated. Please try again';
            }
        } else {
            return ' <span class="color-yellow">No Changes<span> were made to be updated.';
        }
    }



    public function deleteItem($id)
    {
        if ($this->model->deleteItem($id)) {
            return 'Item <span class="color-tgreen">successfully</span> deleted';
        } else {
            return 'Item <span class="color-yellow">could not</span> be deleted';
        }
    }
}
