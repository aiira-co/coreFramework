<?php
use CoreComponent as Component;

Component::Init([
  'selector'=>'app-cont',
  'templateUrl'=>'./contact/contact.view'
  // 'template'=>'<div class="ad-card whiteBG"><h2 class="title">Hello {{title}}</h2><p>{{me}}</p></div>',
  // 'style'=>'.contact{background-color:blue;}'
  // 'styleUrls'=>['./contact/contact.component.css']
]);

class ContactComponent {
  private $params;
  public $test;
  public $title='Contact Form';

  function constructor(){
    $this->params = CORE::getInstance('Params');
    // $this->test = $this->params->test;
    // print_r($this->params);
  }
}

?>
