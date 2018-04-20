<?php

class CheckComponent
{

    public $title="Check Works!";

    private $model;


    function onInit()
    {

        $this->model = CORE::getModel('check');

        $this->getData();
    }

    function getData()
    {
        $this->data = $this->model->getPersons();
        $this->sql= $this->model->getSQL();
    }
}
