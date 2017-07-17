<?php


$base = ['path'=>'/', 'component'=>'app', 'title'=>'Welcome Home'];
$about = ['path'=>'about', 'component'=>'about'];

$practice = ['path'=>'practice', 'component'=>'practice', 'title'=>'Practice With Data'];
$practiceData = ['path'=>'persondata', 'component'=>'practicedata'];

$contact = ['path'=>'contact', 'component'=>'contact', 'title'=>'Get In Touch'];

$account = ['path'=>'account', 'component'=>'account', 'title'=>'Profile', 'auth'=>[true,'account/login']];
$loginPage = ['path'=>'account/login', 'component'=>'login','title'=>'Please Login'];
$logout = ['path'=>'account/logout', 'component'=>'logout'];


$math = ['path'=>'math', 'title'=>'Mathematics', 'component'=>'math'];
$add = ['path'=>'add/:x/:y', 'title'=>'{{title}}', 'component'=>'add'];

 $router = CORE::getInstance('Router');

 $router->setRouter(
                    $base,
                    $practice,
                    $practiceData,
                    $contact,
                    $about,
                    $account,
                    $loginPage,
                    $logout,

                    $math,
                    $add
                  );



?>
