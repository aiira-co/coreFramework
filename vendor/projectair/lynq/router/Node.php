<?php namespace Lynq\Router;

use Lynq\Core\Programe;
use Lynq\Core\Component;
use Lynq\Core\Legacy;

class Node
{
    private $route = ['0'=>'aleph','1'=>'beth','2'=>'gimmel','3'=>'daleth','4'=>'hey'];
    public $router = [];
    private $zenoConfig;
    public $aleph;


    public function __construct($config)
    {
        $this->zenoConfig = $config;
    }

    // Setters & Getters
    public function set($key, $value)
    {
        $this->$key = $value;
    }

    public function get($key)
    {
        return $this->$key ?? null;
    }


    public function router(string $bootstrapComponent, string $routerPath)
    {
        if (file_exists($routerPath)) {
            $this->airRoute($bootstrapComponent, $routerPath);
        } else {
            Programe::reportError('The file: <i  class="bg-dark color-yellow padding-sm">'.$routerPath.'</i> was not found at the specified destination <br /><b>Check the bootstrapComponent for router.php</b>', 'App Routing Error');
        }
    }




    public function airJaxRouter(string $bootstrapComponent, string $urlPath)
    {
        require_once $bootstrapComponent.DS.$bootstrapComponent.'.router.php';
        require_once('routes.php');
        $coreRouter = new Routes;
        $routerPath = $coreRouter->getPath($urlPath);
        //Check if it has a authentication property
        if (isset($routerPath['authguard'])) {
            // if ($routerPath['auth'][0]) {
            //     $coreRouter->checkSession($routerPath['auth'][1], $routerPath['path']);
            // }

            // echo 'authguard exists';
            for ($i= 0; $i < count($routerPath['authguard']); $i++) {
                //check if model exists.
                $model = $routerPath['authguard'][$i];
                $modelClass = '\\Api\\Models\\'.$model;
                if (!(new $modelClass)->canActivate($routerPath['path'])) {
                    break;
                }
            }
        }

        $this->aleph = $routerPath['component'];
        $this->router[0] = $routerPath['component'];

        $legacy = Programe::getInstance('Legacy');
        $legacy->set('routerPath', $routerPath);

        $aleph = strtolower($this->aleph);
        $path = $bootstrapComponent.DS.'components'.DS.$aleph.DS.$aleph.'.component.php';

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
                Programe::reportError('The class:<i class="bg-dark color-yellow padding-sm">'.$class.'</i>does not exist. File: '.$path, 'AirJax Routing Error');
            }
        } else {
            Programe::reportError('File path:<i class="bg-dark color-yellow padding-sm">'.$path.'</i> to component not found', 'AirJax Routing Error');
        }
    }




    private function airRoute($bootstrapComponent, $routerPath)
    {
        // echo ' app router file exists';
        require_once $routerPath;
        $coreRouter = $appRouterModule;
        // print_r($r->getRouter());

        // Get URL and Formate it
        $url = $_GET['zenoUrlQuery']??'/';
        $url = $url!='/' ? rtrim($url, '/'):'/';

        $routerPath = $coreRouter->getPath($url);
        $legacy = Programe::getInstance('Legacy');


        // Check if url was found in the coreRouter
        if ($routerPath != null) {
            //Check if it has a redirect property
            if (isset($routerPath['redirectTo'])) {
                Programe::redirect($routerPath['redirectTo']);
            }



            //Check if it has a authentication property
            if (isset($routerPath['authguard'])) {
                // if ($routerPath['auth'][0]) {
                //     $coreRouter->checkSession($routerPath['auth'][1], $routerPath['path']);
                // }

                // echo 'authguard exists';
                for ($i= 0; $i < count($routerPath['authguard']); $i++) {
                    //check if model exists.
                    $model = $routerPath['authguard'][$i];
                    $modelClass = '\\Api\\Models\\'.$model;
                    if (!(new $modelClass)->canActivate($routerPath['path'])) {
                        break;
                    }
                }
            }


            // $coreComponent = new CoreComponent($path['component'], $this->router);

            $this->aleph = $routerPath['component'];
            $this->router[0] = $routerPath['component'];

            $legacy->set('routerPath', $routerPath);
            $aleph = strtolower($this->aleph);
            // echo $aleph.'<br/>';
            $path = $bootstrapComponent.DS.'components'.DS.$aleph.DS.$aleph.'.component.php';
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
                    $coreComponent = new Component(new $class, $this->router);
                } else {
                    Programe::reportError('The class <i  class="bg-dark color-yellow padding-sm">'.$class.'</i> does not exist. File: '.$path, 'App Routing Error');
                }
            } else {
                // Controller path does not exists
                Programe::reportError('Controller path: <i  class="bg-dark color-yellow padding-sm">'.$path.'</i> does not exists', 'App Routing Error');
            }
        } else {
            // No matching router found
            // if(no match){
            //   echo router for path with **,
            //   else{
            //     render boostrap like that
            //   }
            // }
            Programe::reportError('No matching router found for: <i class="bg-dark color-yellow padding-sm">'.$url.'</i>', 'App Routing Error');
        }
    }
}
