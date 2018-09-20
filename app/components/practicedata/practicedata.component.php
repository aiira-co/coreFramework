<?php

use middleWare as MW;
use Lynq\Router\ActivatedRoute;
use App\Models\PracticeModel;

class PracticedataComponent
{
    public $model;
    public $data;
    public $personData;
    private $key='';



    public function onInit()
    {
        $this->model = new PracticeModel;
        $this->params =  new ActivatedRoute;
        $this->key = $_POST['key']??'';
        $this->items();
    }

    public function items()
    {
        $this->data = $this->model->getItems($this->key);
    }
}
