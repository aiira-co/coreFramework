<?php

class CheckComponent
{
    public $title="Check Works!";

    private $model;


    public function onInit()
    {
        $this->model = CORE::getModel('check');

        $this->getData();
    }

    public function getData()
    {
        $this->data = $this->model->getPersons();
        $this->sql= $this->model->getSQL();
    }
}
