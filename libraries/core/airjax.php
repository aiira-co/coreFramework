<?php


class AirJax
{

    private static $method;
    private static $params;
    private static $airJaxPath;
    private static $type="application/json";


    function __construct()
    {

        if ($_SERVER['REQUEST_METHOD']== 'POST') {
            $data  = file_get_contents('php://input');
            self::$airJaxPath = $_POST['airJaxPath']??'/';
            self::$method = $_POST['method']??'constructor';
            self::$params = $_POST['params']??null;
        } elseif ($_SERVER['REQUEST_METHOD']== 'GET') {
            self::$airJaxPath = $_GET['airJaxPath']??'/';
            self::$method = $_GET['method']??'constructor';
            self::$params = $_GET['params']??null;
        }

        if (isset($_SERVER['HTTP_ACCEPT'])) {
            self::$type = explode(',', $_SERVER['HTTP_ACCEPT'])[0];
        }

        $core = new core;
        $core->airJax();
    }




    static function processAjaxToPHP($class)
    {

        $method = trim(self::$method, ' ');
        $params =self::$params;



        if (method_exists($class, $method)) {
            //call the constructor method if it exists
            if (method_exists($class, 'constructor')) {
                $class->constructor();
            }

            if (is_null($params) || empty($params)) {
                if (self::$type == 'text/html') {
                    header('Content-type:'.self::$type);
                    $class->$method();
                } else {
                    $render = [
                    "notification"=>"Success",
                    "result" => $class->$method()
                    ];
                    echo self::renderJSON($render);
                }
            } else {
                if (self::$type == 'text/html') {
                    header('Content-type:'.self::$type);
                    call_user_func_array(array($class,$method), $params);
                } else {
                    $render = [
                    "notification"=>"Success",
                    "result" => call_user_func_array(array($class,$method), $params)
                    ];

                    echo self::renderJSON($render);
                }
            }
        } else {
            if (self::$type == 'text/html') {
                header('Content-type:'.self::$type);
                echo 'The method '.$method.' does not exist in the component-> '.self::$airJaxPath;
            } else {
                $render = [
                "notification"=>"Failure",
                "result" => 'The method '.$method.' does not exist in the component-> '.self::$airJaxPath
                ];

                echo self::renderJSON($render);
            }
        }
    }



    static function renderJSON($result)
    {

        header('Content-type:'.self::$type);
        return json_encode($result);
    }
}
