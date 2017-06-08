<?php
use CoreSession as Session;

  class LogoutComponent{

    function constructor(){
      if(Session::IsLoggedIn()){

          if(Session::SessionLogout()){
              Core::Redirect(BaseUrl.'account/login');
          }else{
              Core::Redirect(BaseUrl.'account');

          }
      }else{

          Core::Redirect(BaseUrl.'account/login');
      }
    }
  }


?>
