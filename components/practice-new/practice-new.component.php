<?php

class PracticeNewComponent
{
    public $title ="Add New Item";
    public $method = "saveItem()";
    public $item;

    private $params;
    private $model;

    public function onInit()
    {
        $this->model = CORE::getModel('practice');
        $this->params = CORE::getInstance('params');



        if (isset($this->params->itemId)) {
            $this->title ="Edit Item Info";
            $this->method ="updateItem()";
            $this->getItem($this->params->itemId);
        }
    }


    public function getItem(int $id)
    {
        $this->item = $this->model->getItem($id);
    }
}
