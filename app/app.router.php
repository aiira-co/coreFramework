<?php

use Lynq\Router\Routes;

$appRouterModule = new Routes;

$appRouter = [
  [
    'path'=>'/',
    'component'=>'home',
    'title'=>'Welcome Home'
  ],

  [
    'path'=>'about',
    'component'=>'about'
  ],

  [
    'path'=>'practice',
    'component'=>'practice',
    'title'=>'Practice With Data'
  ],

  [
    'path'=>'persondata',
    'component'=>'practicedata'
  ],

  [
    'path'=>'contact',
    'component'=>'contact',
    'title'=>'Get In Touch'
  ],

  [
    'path'=>'account',
    'component'=>'account',
    'title'=>'Profile',
    'authguard'=>['AuthenticateModel']
  ],

  [
    'path'=>'account/login',
    'component'=>'login',
    'title'=>'Please Login'
  ],

  [
    'path'=>'account/logout',
    'component'=>'logout'
  ]

];


$appRouterModule->setRouter($appRouter);
