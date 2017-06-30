<?php


class AirJax{

  private static $method;
  private static $params;
  private static $airJaxPath;


  function __construct(){

    if($_SERVER['REQUEST_METHOD']== 'POST'){

      $data  = file_get_contents('php://input');
      self::$airJaxPath = $_POST['airJaxPath']??'/';
      self::$method = $_POST['method']??'constructor';
      self::$params = $_POST['params']??null;


    }elseif($_SERVER['REQUEST_METHOD']== 'GET'){

      self::$airJaxPath = $_GET['airJaxPath']??'/';
      self::$method = $_GET['method']??'constructor';
      self::$params = $_GET['params']??null;
    }

    $core = new core;
    $core->airJax();


  }




  static function processAjaxToPHP($class){

    $method = trim(self::$method, ' ');
    $params =self::$params;

    

    if(method_exists($class, $method)){
      //call the constructor method if it exists
      if(method_exists($class,'constructor')){
        $class->constructor();
      }

      if(is_null($params) || empty($params)){
        $render = [
          "notification"=>"Success",
          "result" => $class->$method()
        ];
        echo self::renderJSON($render);
      }else{

        $render = [
          "notification"=>"Success",
          "result" => call_user_func_array(array($class,$method),$params)
        ];

        echo self::renderJSON($render);
      }


    }else{
      $render = [
        "notification"=>"Failure",
        "result" => 'The method '.$method.' does not exist in the component-> '.self::$airJaxPath
      ];

      echo self::renderJSON($render);

    }
  }



  static function renderJSON($result){
    header("Content-type: application/json");
    return json_encode($result);
  }


}




 ?>
