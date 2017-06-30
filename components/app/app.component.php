<?php
use CoreComponent as Component;

Component::Init([
  'selector'=>'app-main',
  // 'templateUrl'=>'./app/app.view'
  // 'template'=>'<div class="ad-card whiteBG"><h2 class="title">Hello {{title}}</h2><p>{{me}}</p></div>'
  // 'style'=>'.contact{background-color:blue;}'
  // 'styleUrls'=>['./contact/contact.component.css']
]);

class AppComponent{

  public $title="Welcome Home";
  public $me ="This is coreFramework";

    function constructor(){
      
    }
}



?>
