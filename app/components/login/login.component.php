<?php
use Lynq\Entity\Session;
use Lynq\Core\Programe;
use Lynq\Router\ActivatedRoute;

class LoginComponent
{
    private $params;
    public $message;
    public $redirect;

    public function onInit()
    {
        $this->params = new ActivatedRoute();
        if (isset($this->params->redirect)) {
            $this->redirect =$this->params->redirect;
        }


        if (Session::IsLoggedIn()) {
            if (isset($this->params->redirect)) {
                Programe::redirect(BaseUrl.$this->params->redirect);
            } else {
                Programe::redirect(BaseUrl);
            }
        }




        if (isset($_POST['login'])) {
            $this->verify();
        }
    }

    public function verify()
    {

      //  echo password_hash($_POST['upass'], PASSWORD_DEFAULT);
        Session::SessionInit('user', 'email', 'username', 'hash_word');
        if (Session::SessionLogin($_POST['uname'], $_POST['uname'], $_POST['upass'])) {
            $link = BaseUrl.$this->params->redirect ?? BaseUrl;

            Programe::redirect($link);
        } else {
            $this->message = Session::$error ? 'The entered password doesnt match the password of the user' : 'The username or email is wrong';
        }
    }
}
