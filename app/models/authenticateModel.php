<?php namespace App\Models;

use Lynq\Core\Programe;
use Lynq\Entity\Session;

class AuthenticateModel
{

  // This method is used by the routing class to allow or disabllow a route to the component
    public function canActivate(string $url):bool
    {
        if (Session::IsLoggedIn()) {
            return true;
        } else {
            PROGRAME::redirect('account/login', $url);
            return false;
        }
    }
}
