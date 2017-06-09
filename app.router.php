<?php

// require_once('./components/practice/practice.component.php');
// $c = new PracticeComponent;
// echo $c->title;


$base = array('path'=>'/', 'component'=>'app', 'title'=>'Welcome Home');
$about = array('path'=>'about', 'redirectTo'=>BaseUrl);
$practice = array('path'=>'practice', 'component'=>'practice', 'title'=>'Practice With Data');
$contact = array('path'=>'contact', 'component'=>'contact', 'title'=>'Get In Touch');
$account = array('path'=>'account', 'component'=>'account', 'title'=>'Profile', 'auth'=>[true,'account/login']);
$loginPage = array('path'=>'account/login', 'component'=>'login','title'=>'Please Login');
$logout = array('path'=>'account/logout', 'component'=>'logout');


$math = array('path'=>'math', 'title'=>'Mathematics', 'component'=>'math');
$add = array('path'=>'add/:x/:y', 'title'=>'{{title}}', 'component'=>'add');

 $router = CORE::getInstance('Router');

 $router->setRouter(
                    $base,
                    $practice,
                    $contact,
                    $about,
                    $account,
                    $loginPage,
                    $logout,

                    $math,
                    $add
                  );



?>
