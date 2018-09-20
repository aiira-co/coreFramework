<?php
use Lynq\Core\Programe;
use Lynq\Router\ActivatedRoute;

class ContactComponent
{
    private $params;
    public $test;
    public $title='Contact Form';

    public function onInit()
    {
        $this->params = new ActivatedRoute();
        // $this->test = $this->params->test;
        // print_r($this->params);
    }
}
