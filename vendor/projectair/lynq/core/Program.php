<?php  namespace Lynq\Core;

use Lynq\Router\ActivatedRoute;
use Lynq\Router\Node;
use \Lynq\Core\Component;
use \Lynq\Core\Legacy;

class Programe
{
    // private $bootstrap;
    public static $bootstrap;
    private static $errorReport;
    private static $zenoConfig;
    private static $instance = [];

    public function __construct($config)
    {
        self::$zenoConfig = $config;
        // check if live_site is ot empty
        if (!empty(self::$zenoConfig->liveSite)) {
            $baseUrl = self::$zenoConfig->liveSite;
        } else {
            // /check if its a secured connection
            $http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
            $serverName = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];

            // echo 'Server Name'.$serverName.'<br>';

            // attach directory to the serverName if its not public
            $dir = basename(dirname($_SERVER['PHP_SELF']));

            $rootPaths = ['htdocs','www','public_html'];
            for ($i=0; $i < count($rootPaths); $i++) {
                if ($dir != $rootPaths[$i]) {
                    $is_root = false;
                } else {
                    $is_root = true;
                }
            }
            if ($is_root) {
                $baseUrl = $serverName;
            } else {
                if ($serverName == $dir) {
                    $baseUrl = $http.$serverName.'/';
                } else {
                    $baseUrl = $http.$serverName.'/'.$dir.'/';
                }
            }
        }

        //CDN
        $cdn = !empty(self::$zenoConfig->cdn) ? self::$zenoConfig->cdn:$baseUrl.'assets'.DS;
        define('BASEURL', $baseUrl);
        define('AIRJAX', self::$zenoConfig->airJax);
        define('CDN', $cdn);
    }


    /**
     * This Method is called in the root index.php file.
     * the Method intanciates the node class for routing

    **/
    private function onInit(string $component)
    {
        // check is componet exists;
        $filename = $component.DS.$component.'.component.php';
        if (file_exists($filename)) {
            $routerPath = $component.DS.$component.'.router.php';
            self::$bootstrap = $component;
        } else {
            self::reportError('Component Path: '.$filename.' does not exist');
        }

        // $node = new \Lynq\Router\Node(self::$zenoConfig);
        // $node->router($component, $routerPath);
        // $this->aleph = $node->aleph;
    }


    // This Method is called in the root index.php file.
    // the Method intanciates the node class for routing
    public function renderO(string $component)
    {
        $this->onInit($component);
        $node = new Node(self::$zenoConfig);
        $node->router($component, $component.DS.$component.'.router.php');
        // $this->aleph = $node->aleph;
    }









    // method to report error & kill app process
    public static function reportError(string $error, string $errorTitke='Error Report')
    {
        if (!self::$zenoConfig->enableProdMode) {
            self::$errorReport = '<div class="ad-card ad-shadow bg-white outline"><h2 class="title">'.$errorTitke.'</h2> <p class="color-pink">'.$error.'</p></div>';
        } else {
            self::$errorReport = '';
        }

        die(self::$errorReport);
    }







    // Method to Instantiate a class.
    // It first checks to see if class is available
    // if yes, return the instance of the class
    //   hence [new className]
    // if class is not available, require the class file, then repeat the
    // process again to instantiate

    public static function getInstance($class)
    {
        // check if instance of the class already exist
        if (isset(self::$instance[$class])) {
            return self::$instance[$class];
        } else {
            // check if class is available
            if (!class_exists($class)) {
                self::autoload($class, 'core');
            }

            if ($class == 'Legacy') {
                self::$instance[$class] = new Legacy;
            }elseif ($class == 'Routes') {
                self::$instance[$class] = new \Routes;
            } else {

              // $formatClass = ucfirst($class)
                self::$instance[$class] = new $class;
            }


            return self::$instance[$class];
        }
    }







    // Automatically load required for to instatiate the class
    public static function autoload(string $class, string $instanceType=''): bool
    {
        // echo memory_get_usage();

        $path=[];

        // Reduce target directories to query
        switch ($instanceType) {
          case 'core':
            $paths = [
              '.'.DS.'core',
              '.' //for airjax
            ];
            break;

          case 'component':
          // echo'<pre>component loading...';
            $paths = [
              '.'.DS.'',
              '.'.DS.self::$bootstrap.DS.'components',
              '..'.DS.self::$bootstrap.DS.'components'
            ];
            break;

          default:
          $paths = [
            '.',
            'core',

            '.'.DS.self::$bootstrap,
            '.'.DS.self::$bootstrap.DS.'models',
            '..'.DS.self::$bootstrap.DS.'components',
            '..'.DS.self::$bootstrap.DS.'models'];
            break;
        }


        foreach ($paths as $path) {
            $file = $path.DS.strtolower($class).'.php';

            // echo $file.'<br/>';

            if (file_exists($file)) {
                // echo'found';
                require_once $file;
                return true;
            }
        }



        return false;
    }




    // Renders
    // This method takes the view and component obj for rendering.
    // it sets them for the CoreApp Method which is ad only declared in the
    // workspace template where the component will be seen in the UI of the app or
    // website.

    public static function render(string $view, $component, bool $url = true)
    {
        $legacy = self::getInstance('Legacy');


        // Set view in Legacy for CoreApp()
        $legacy->set('view', $view);
        $legacy->url = $url;

        // Set component in  Legacy for CoreApp()
        if (!empty($component)) {
            $legacy->set('component', $component);
        }
        // $tmpl = self::$zenoConfig->template;
        $params = new ActivatedRoute;

        // API for rendering

        //ajaxCall
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $ajaxRequest = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ? true:false;
        } else {
            $ajaxRequest = false;
        }
        //use only this to get json to airjax and make view an html file
        // echo json_encode($component);

        if (($params->api == 'json') && ($params->hash == self::$zenoConfig->secret)) {
            echo json_encode($component);
        } elseif (($ajaxRequest && self::$zenoConfig->airJax && $params->api == 'airJax') || (($params->api) == 'html' && ($params->hash) == (self::$zenoConfig->secret))) {
            $routeComponent= $component;
            // print_r($routeComponent);

            $routeComponentData = json_decode(json_encode($routeComponent), true);
            $routeComponentLength = count($routeComponentData);


            if ($routeComponentLength > 0) {
                $routeComponentFields= array_keys($routeComponentData);


                // echo 'routeComponent is not empty';

                // Make Component variable available to View
                for ($i=0; $i < $routeComponentLength; $i++) {
                    ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
                    ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];
                }
            }


            if ($url || file_exists(self::$bootstrap.DS.'components'.DS.$view.'.php')) {
                // print_r($legacy);
                require_once self::$bootstrap.DS.'components'.DS.$view.'.php';
            } else {
                // echo str_replace('{{'.$search.'}}', $replace, $coreLegacy->view);
                // Replace vairbles in template words with component vairbles
                for ($i=0; $i < $routeComponentLength; $i++) {
                    // echo ${$routeComponentData[$i]};
                    $view = str_replace("{{".$routeComponentFields[$i]."}}", $routeComponentData[$routeComponentFields[$i]], $view);
                }
                // echo $edited;
                echo '<br/>'.$view;
            }

            //getPageTitle
            echo'<pageTitle label="'.Component::getComponentTitle().'"></pageTitle>';

            //check if scritps exists
            if (isset($legacy->script)) {
                echo '<script>'.$legacy->script.'</script>';
            } elseif (isset($legacy->scriptUrls)) {
                echo '<script  type="text/javascript" >';

                $script ="";

                for ($i =0; $i < count($legacy->scriptUrls); $i++) {
                    $path = '.'.DS.'components'.DS.$legacy->scriptUrls[$i];
                    if (file_exists($path)) {
                        $script .= require_once $path;
                    }
                }

                echo  '</script>';

                // echo $scriptOpenTag.$script.$scriptCloseTag;
            }




            // check if styles exists
            if (isset($legacy->style)) {
                echo '<style>'.$legacy->style.'</style>';
            } elseif (isset($legacy->styleUrls)) {
                for ($i =0; $i < count($legacy->styleUrls); $i++) {
                    echo '<link rel="stylesheet" href="'.BaseUrl.'components'.DS.$legacy->styleUrls[$i].'">';
                }
            }
        }
    }



    public function bootstrapComponent(string $component)
    {
        $this->onInit($component);
        $cfile = $component.DS.$component.'.component';
        $vfile = $component.DS.$component.'.view';

        $cPath  = ($component == self::$bootstrap)? $cfile.'.php':self::$bootstrap.DS.'components'.DS.$cfile.'.php';
        // view path is different for bootstrap
        $vPath  = ($component == self::$bootstrap) ? $vfile.'.php' : self::$bootstrap.DS.'components'.DS.$vfile.'.php';
        // echo '<br/>view path is: '.$vPath.'<br/>';
        if (self::autoload($cfile, 'component')) {
            // require_once $cPath;
            $component = explode('-', $component);
            $class = isset($component[1]) ? ucfirst($component[0]).ucfirst($component[1]).'Component' :ucfirst($component[0]).'Component';
            if (class_exists($class)) {
                $routeComponent = new $class;

                if (file_exists($vPath) || file_exists('..'.DS.$vPath)) {
                    $vPath = file_exists($vPath)?$vPath:'..'.DS.$vPath;
                    if (method_exists($routeComponent, 'onInit')) {
                        $routeComponent->onInit();
                    }
                    // Make Component variable available to View
                    $routeComponentData = json_decode(json_encode($routeComponent), true);
                    $routeComponentLength = count($routeComponentData);


                    if ($routeComponentLength > 0) {
                        $routeComponentFields= array_keys($routeComponentData);


                        // echo 'routeComponent is not empty';

                        // Make Component variable available to View
                        for ($i=0; $i < $routeComponentLength; $i++) {
                            ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
                                ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];
                        }
                    }

                    require_once $vPath;
                } else {
                    self::reportError('The View File <i  class="bg-dark color-yellow padding-sm">'.$vPath.'</i> Was Not Found', 'Component Error');
                }
            } else {
                self::reportError('The Components class <i  class="bg-dark color-yellow padding-sm">'.$class.' </i> does not exist', 'Component Error');
            }
        } else {
            self::reportError('The Component File <i class="bg-dark color-yellow padding-sm">'.$cfile.'</i> Was Not Found', 'Component Error');
        }
    }



    // router-outlet for the routing of the component
    // This is to only exist in the bootstrapComponent to call the rendered routing

    public function routerOutlet()
    {
        $coreLegacy = self::getInstance('Legacy');
        $coreView = $coreLegacy->view;

        // Make Component vairbles available to view
        // self::componentVariables($coreLegacy->component);
        $routeComponent= $coreLegacy->component;
        // print_r($routeComponent);

        $routeComponentData = json_decode(json_encode($routeComponent), true);
        $routeComponentLength = count($routeComponentData);


        if ($routeComponentLength > 0) {
            $routeComponentFields= array_keys($routeComponentData);


            // echo 'routeComponent is not empty';

            // Make Component variable available to View
            for ($i=0; $i < $routeComponentLength; $i++) {
                ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
                ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];
            }
        }



        if ($coreLegacy->url) {
            $coreFile = self::$bootstrap.DS.'components'.DS.strtolower($coreView).'.php';

            if (file_exists($coreFile)) {
                require_once $coreFile;
            } else {
                self::reportError('The View File <i  class="bg-dark color-yellow padding-sm">'.$coreFile.'</i> Was Not Found');
            }
        } else {
            // echo str_replace('{{'.$search.'}}', $replace, $coreLegacy->view);
            // Replace vairbles in template words with component vairbles
            for ($i=0; $i < $routeComponentLength; $i++) {
                // echo ${$routeComponentData[$i]};
                $coreLegacy->view = str_replace("{{".$routeComponentFields[$i]."}}", $routeComponentData[$routeComponentFields[$i]], $coreLegacy->view);
            }
            // echo $edited;
            echo '<br/>'.$coreLegacy->view;
        }
    }


    //
    // First get check if componet exists.
    // then check if class is available,
    // if yes, instantiate and render
    // else require component and display its view with its component exploding






    // Make Component vairbles available to view
    private static function componentVariables($component = null)
    {
        $routeComponent= $component;
        // print_r($routeComponent);

        $routeComponentData = json_decode(json_encode($routeComponent), true);
        $routeComponentLength = count($routeComponentData);


        if ($routeComponentLength > 0) {
            $routeComponentFields= array_keys($routeComponentData);


            // echo 'routeComponent is not empty';

            // Make Component variable available to View
            for ($i=0; $i < $routeComponentLength; $i++) {
                ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
                ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];
            }
        }
    }



    // Method for redirecting.
    // This method is also used in the node class for redirecting routes

    public static function redirect($url, $redirectTo = null, $code = 302)
    {
        if (!is_null($redirectTo)) {
            $airJaxURL = '&api=airJax';
            $url = self::$zenoConfig->airJax ? $url.$redirectTo.$airJaxURL : $url.$redirectTo;
        } else {
            $airJaxURL = '?api=airJax';
            $url = self::$zenoConfig->airJax ? $url.$airJaxURL : $url;
        }


        if (strncmp('cli', PHP_SAPI, 3) !== 0) {
            if (!headers_sent()) {
                if (strlen(session_id()) > 0) { // if using sessions
                    session_regenerate_id(true); // avoids session fixation attacks
                    session_write_close(); // avoids having sessions lock other requests
                }

                if (strncmp('cgi', PHP_SAPI, 3) === 0) {
                    header(sprintf('Status: %03u', $code), true, $code);
                }

                header('Location: ' . $url, true, (preg_match('~^30[1237]$~', $code) > 0) ? $code : 302);
            } else {
                echo "<meta http-equiv=\"refresh\" content=\"0;url=$url\">\r\n";
            }

            exit();
        }
    }




    public static function airJax(string $bootstrapComponent, string $urlPath, $config)
    {
        self::$bootstrap = $bootstrapComponent;
        $node = new Node($config);
        $node->airJaxRouter($bootstrapComponent, $urlPath);
    }
}
