<?php


class AirJax
{
    private static $method;
    private static $airParams;
    private static $airJaxPath;
    private static $type="application/json";


    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST') {
            $data  = file_get_contents('php://input');
            self::$airJaxPath = $_POST['airJaxPath']??'/';
            self::$method = $_POST['method']??'onInit';
            self::$airParams = $_POST['airParams']??null;
        } elseif ($_SERVER['REQUEST_METHOD']== 'GET') {
            self::$airJaxPath = $_GET['airJaxPath']??'/';
            self::$method = $_GET['method']??'onInit';
            self::$airParams = $_GET['airParams']??null;
        }

        if (isset($_SERVER['HTTP_ACCEPT'])) {
            self::$type = explode(',', $_SERVER['HTTP_ACCEPT'])[0];
        }

        $core = new core;
        $core->airJax();
    }




    public static function processAjaxToPHP($class)
    {
        $method = trim(self::$method, ' ');
        $airParams =self::$airParams;



        if (method_exists($class, $method)) {
            //call the constructor method if it exists
            if (method_exists($class, 'onInit')) {
                $class->onInit();
            }

            if (is_null($airParams) || empty($airParams)) {
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
                    call_user_func_array(array($class,$method), $airParams);
                } else {
                    $render = [
                    "notification"=>"Success",
                    "result" => call_user_func_array(array($class,$method), $airParams)
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



    public static function renderJSON($result)
    {
        header('Content-type:'.self::$type);
        return json_encode($result);
    }
}
