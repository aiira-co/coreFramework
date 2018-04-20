<?php

class AuthenticateModel{

  // This method is used by the routing class to allow or disabllow a route to the component
  function canActivate(string $url):bool{
    if (CoreSession::IsLoggedIn()) {
      return true;
    }else{
        Core::redirect(BaseUrl.'account/login',$url);
        return false;
    }
  }


}
