<?php
  use CoreSession as Session;

 class LoginComponent{

   private $params;
   public $message;
   public $redirect;

   function constructor(){
     $this->params = CORE::getInstance('Params');
     if(isset($this->params->redirect)){
       $this->redirect =$this->params->redirect;
     }


     if(Session::IsLoggedIn()){
       if(isset($this->params->redirect)){
         Core::Redirect(BaseUrl.$this->params->redirect);
       }else{
          Core::Redirect(BaseUrl);
       }
    }




     if(isset($_POST['login'])){
       $this->verify();
     }

   }

   function verify(){

    //  echo password_hash($_POST['upass'], PASSWORD_DEFAULT);
     Session::SessionInit('user','email','username','hashword');
      if(Session::SessionLogin($_POST['uname'],$_POST['uname'],$_POST['upass']))
        {
          $link = BaseUrl.$this->params->redirect ?? BaseUrl;

          Core::Redirect($link);
        }
        else
        {

        $this->message = Session::$error ? 'The entered password doesnt match the password of the user' : 'The username or email is wrong';

        }




   }
 }

?>
