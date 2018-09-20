<?php  namespace Lynq\Core;

use Lynq\Core\Programe;

class AirJax
{
    private static $method;
    private static $airParams;
    private static $airJaxPath;
    private static $type="application/json";


    public function __construct($bootstrapComponent, $config)
    {
        // if its a post request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data  = file_get_contents('php://input');
            // component:method
            self::$airJaxPath = explode(':', $_POST['airJaxPath'])[0]??'/';
            self::$method = explode(':', $_POST['airJaxPath'])[1]??'onInit()';

            self::$airParams = $_POST['airParams']??null;
        } elseif ($_SERVER['REQUEST_METHOD']== 'GET') {
            // for get request
            // component:method
            self::$airJaxPath = explode(':', $_GET['airJaxPath'])[0]??'/';
            self::$method =  explode(':', $_GET['airJaxPath'])[1]??'onInit()';

            self::$airParams = $_GET['airParams']??null;
        }

        if (isset($_SERVER['HTTP_ACCEPT'])) {
            self::$type = explode(',', $_SERVER['HTTP_ACCEPT'])[0];
        }

        $core = new Programe($config);
        $core->airJax($bootstrapComponent, self::$airJaxPath, $config);
    }




    public static function processAjaxToPHP($class)
    {
        $method = trim(self::$method, ' ');
        $airParams =self::$airParams;

        // echo $method;
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
