<?php

class ContactComponent
{
    private $params;
    public $test;
    public $title='Contact Form';

    function constructor()
    {
        $this->params = CORE::getInstance('Params');
        // $this->test = $this->params->test;
        // print_r($this->params);
    }
}
