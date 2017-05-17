<?php


class Node{

    private $route = array('0'=>'aleph','1'=>'beth','2'=>'gimmel','3'=>'daleth','4'=>'hey');
    public $router = array();
    private $adConfig;
    public $aleph;


    // Setters & Getters
    function set($key, $value)
	{
		$this->$key = $value;

	}

	function get($key)
	{
		return $this->$key ?? null;

	}


    function router(){
      $this->adConfig  =  new AdConfig;
      if(isset($this->adConfig->routerPath)){
          // echo 'manual on';
        if(file_exists($this->adConfig->routerPath)){
          $this->manualRoute();
        }else{
          echo 'The file '.$this->adConfig->routerPath.'was not found at the specified destination <br><h2>Check the routerPath variable in config.php<h2>';
        }
      }else{
        // echo 'auto on';
        $this->autoRoute();
      }


    }




    private function manualRoute(){
      // echo ' app router file exists';
      require_once $this->adConfig->routerPath;
      $coreRouter = CORE::getInstance('Router');
      // print_r($r->getRouter());

      // Get URL and Formate it
      $url = $_GET['url']??'/';
      $url = $url!='/' ? rtrim($url, '/'):'/';

      $routerPath = $coreRouter->getPath($url);
      $legacy = CORE::getInstance('Legacy');


      // Check if url was found in the coreRouter
      if($routerPath != null){
        //Check if it has a redirect property
        if(isset($routerPath['redirectTo'])){
          CORE::Redirect($routerPath['redirectTo']);
        }

        //Check if it has a authentication property
        if(isset($routerPath['auth'])){
          if($routerPath['auth'][0]){
            $coreRouter->checkSession($routerPath['auth'][1], $routerPath['path']);
          }

        }



        // $coreComponent = new CoreComponent($path['component'], $this->router);

        $this->aleph = $routerPath['component'];
        $this->router[0] = $routerPath['component'];

        $legacy->set('routerPath',$routerPath);
          $aleph = strtolower($this->aleph);
          // echo $aleph.'<br/>';
          $path = 'components'.DS.$aleph.DS.$aleph.'.component.php';
          // echo $path;


          if(file_exists($path)){
              //echo'file exists';
              require_once $path;


                $i = explode('-',$aleph);

                $class = isset($i[1]) ? ucfirst($i[0]).ucfirst($i[1]) : ucfirst($i[0]);


                        // $aleph;
              $class = $class.'Component';

              //echo '<br/>'.$class;
              if(class_exists($class)){
                  $coreComponent = new CoreComponent(new $class, $this->router);

              }else{
                  echo '<br/> The class '.$class.'does not exist. File: '.$path;
              }

          }else{

            require_once 'templates'.DS.$this->adConfig->template.DS.'error.php';
          }


      }else{
        require_once 'templates'.DS.$this->adConfig->template.DS.'error.php';
      }



    }






    private function autoRoute(){


      if(isset($_GET['url'])){

          $url = explode('/',rtrim($_GET['url'],'/'));

          foreach ($url as $key => $value)
          {

              if (isset($this->route[$key]))
              {
                  $this->set($this->route[$key], $value);
              }
              else
              {
                  $this->set($key, $value);
              }

              $this->router[$key] = $value;
          }



          if(isset($this->aleph)){
              $aleph = strtolower($this->aleph);
              // echo $aleph.'<br/>';
              $path = 'components'.DS.$aleph.DS.$aleph.'.component.php';
              // echo $path;
              if(file_exists($path)){
                  //echo'file exists';
                  require_once $path;

                  $class = ucfirst($aleph).'Component';
                  //echo '<br/>'.$class;
                  if(class_exists($class)){
                      if(method_exists($class,'constructor')){
                          $display = new $class;
                          $display->constructor();
                      }else{
                          $display = new $class;
                      }

                  }else{
                      echo '<br/> the class ',$class.'does not exist';
                  }

              }else{

                require_once 'templates'.DS.$this->adConfig->template.DS.'error.php';
              }


          }




      }else{
          $aleph = 'app';
          $this->set('aleph', $aleph);
          $this->router[0] = $aleph;

          $path = 'components'.DS.$aleph.DS.$aleph.'.component.php';
          // echo 'yh';
              if(file_exists($path)){
                  //echo'file exists';
                  require_once $path;
                  // echo $path;

                  $class = ucfirst($aleph).'Component';
                  //echo '<br/>'.$class;
                  if(class_exists($class)){
                      if(method_exists($class,'constructor')){
                          $display = new $class;
                          $display->constructor();

                      }else{

                          $display = new $class;
                      }

                  }else{
                      echo '<br/> the class ',$class.'does not exist';
                  }
              }
                  else{
                  require_once 'templates'.DS.$this->adConfig->template.DS.'error.php';
              }


      }

      // print_r($url);
    }



}




?>
