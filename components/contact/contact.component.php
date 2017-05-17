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
  public $title='Contact Info';

  // public $title="Ghana";
  // public $me='Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
  // Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

  function constructor(){
    $this->params = CORE::getInstance('Params');
    // $this->test = $this->params->test;
    // print_r($this->params);
  }
}

?>
