<?php


class Node
{

    private $route = ['0'=>'aleph','1'=>'beth','2'=>'gimmel','3'=>'daleth','4'=>'hey'];
    public $router = [];
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


    function router()
    {
        $this->adConfig  =  new AdConfig;

        if (file_exists($this->adConfig->routerPath)) {
            $this->airRoute();
        } else {
            echo 'The file '.$this->adConfig->routerPath.'was not found at the specified destination <br><h2>Check the routerPath variable in config.php<h2>';
        }
    }




    function airJaxRouter()
    {
        $this->adConfig  =  new AdConfig;

          require_once '../'.$this->adConfig->routerPath;

        $coreRouter = CORE::getInstance('Router');

        $airJaxPath = $_POST['airJaxPath']??$_GET['airJaxPath'];
        $airJaxPath =empty($airJaxPath)?'/':$airJaxPath;
        $routerPath = $coreRouter->getPath($airJaxPath);

      //Check if it has a authentication property
        if (isset($routerPath['auth'])) {
            if ($routerPath['auth'][0]) {
                $coreRouter->checkSession($routerPath['auth'][1], $routerPath['path']);
            }
        }

        $this->aleph = $routerPath['component'];
        $this->router[0] = $routerPath['component'];

        $legacy = CORE::getInstance('Legacy');
        $legacy->set('routerPath', $routerPath);

        $aleph = strtolower($this->aleph);
        $path = '..'.DS.'components'.DS.$aleph.DS.$aleph.'.component.php';

        if (file_exists($path)) {
            // echo'file exists';
            require_once $path;
              $i = explode('-', $aleph);

              $class = isset($i[1]) ? ucfirst($i[0]).ucfirst($i[1]) : ucfirst($i[0]);


                      // $aleph;
            $class = $class.'Component';
            // echo $class;

            //echo '<br/>'.$class;
            if (class_exists($class)) {
                $cc = new $class;

                AirJax::processAjaxToPHP(new $class);
            } else {
                echo '<br/> The class '.$class.'does not exist. File: '.$path;
            }
        } else {
            echo 'Node::File path to component not found';
        }
    }




    private function airRoute()
    {
      // echo ' app router file exists';
        require_once $this->adConfig->routerPath;
        $coreRouter = CORE::getInstance('Router');
      // print_r($r->getRouter());

      // Get URL and Formate it
        $url = $_GET['url']??'/';
        $url = $url!='/' ? rtrim($url, '/'):'/';

        $routerPath = $coreRouter->getPath($url);
        $legacy = CORE::getInstance('Legacy');

        $this->adConfig  =  new AdConfig;


      // Check if url was found in the coreRouter
        if ($routerPath != null) {
            //Check if it has a redirect property
            if (isset($routerPath['redirectTo'])) {
                CORE::redirect($routerPath['redirectTo']);
            }



            //Check if it has a authentication property
            if (isset($routerPath['auth'])) {
                if ($routerPath['auth'][0]) {
                    $coreRouter->checkSession($routerPath['auth'][1], $routerPath['path']);
                }
            }



            // $coreComponent = new CoreComponent($path['component'], $this->router);

            $this->aleph = $routerPath['component'];
            $this->router[0] = $routerPath['component'];

            $legacy->set('routerPath', $routerPath);
            $aleph = strtolower($this->aleph);
            // echo $aleph.'<br/>';
            $path = 'components'.DS.$aleph.DS.$aleph.'.component.php';
            // echo $path;


            if (file_exists($path)) {
                //echo'file exists';
                require_once $path;


                $i = explode('-', $aleph);

                $class = isset($i[1]) ? ucfirst($i[0]).ucfirst($i[1]) : ucfirst($i[0]);


                        // $aleph;
                $class = $class.'Component';

                //echo '<br/>'.$class;
                if (class_exists($class)) {
                    $coreComponent = new CoreComponent(new $class, $this->router);
                } else {
                    echo '<br/> The class '.$class.'does not exist. File: '.$path;
                }
            } else {
                require_once 'templates'.DS.$this->adConfig->template.DS.'error.php';
            }
        } else {
            require_once 'templates'.DS.$this->adConfig->template.DS.'error.php';
        }
    }
}
