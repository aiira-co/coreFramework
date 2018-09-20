<?php

use Lynq\Entity\Session;
use Lynq\Core\Programe;

class LogoutComponent
{
    public function onInit()
    {
        if (Session::IsLoggedIn()) {
            if (Session::SessionLogout()) {
                Programe::redirect(BaseUrl.'account/login');
            } else {
                Programe::redirect(BaseUrl.'account');
            }
        } else {
            Programe::redirect(BaseUrl.'account/login');
        }
    }
}
