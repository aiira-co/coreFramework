<?php

class AccountComponent
{
    public $data = 'Welcome back ';

    public function onInit()
    {
        $this->data .= $_SESSION['user_session'];
    }
}
