<?php

$appRouter = [
  ['path'=>'/', 'component'=>'app', 'title'=>'Welcome Home'],
  ['path'=>'about', 'component'=>'about'],
  ['path'=>'practice', 'component'=>'practice', 'title'=>'Practice With Data'],
  ['path'=>'persondata', 'component'=>'practicedata'],
  ['path'=>'contact', 'component'=>'contact', 'title'=>'Get In Touch'],
  ['path'=>'account', 'component'=>'account', 'title'=>'Profile', 'auth'=>[true,'account/login']],
  ['path'=>'account/login', 'component'=>'login','title'=>'Please Login'],
  ['path'=>'account/logout', 'component'=>'logout'],
  ['path'=>'math', 'title'=>'Mathematics', 'component'=>'math'],
  ['path'=>'add/:x/:y', 'title'=>'{{title}}', 'component'=>'add'],
  ['path'=>'check', 'component'=>'check', 'title'=>'{{title}}']

]; 

$appRouterModule = CORE::getInstance('Router');
$appRouterModule->setRouter($appRouter);
