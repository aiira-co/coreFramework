<?php namespace Lynq\Core;

class Component
{
    private $router= [];
    private $routerExist = false;
    private $component;

    private static $c = [];

    public function __construct($component, $router)
    {
        $this->router = $router;
        $this->component = $component;
        if (method_exists($component, 'onInit')) {
            $component->onInit();
        }
        // echo 'hello controller';
        $this->renderComponent();
    }

    public static function Init(array $c)
    {

        //Get the keys of the passed component
        $cFields = array_keys($c);
        //Get the length of the passed component
        $cLength = count($c);

        for ($i = 0; $i < $cLength; $i++) {
            //compare the passed component key to the original componenent key,
            //if there is a match, assign it, else die
            self::$c[$cFields[$i]] = $c[$cFields[$i]];
        }
    }

    // The component function must have an array as an argument not just variables
    public function renderComponent()
    {
        $legacy = Programe::getInstance('Legacy');


        // Set Title if {{title}
        if (isset($legacy->routerPath['title']) && $legacy->routerPath['title'] == '{{title}}') {
            $legacy->routerPath['title'] = $this->component->title??'Error: $title does not exist in component';
        }


        // Set STYLE
        if (isset(self::$c['style'])) {
            $legacy->style = self::$c['style'];
        } elseif (isset(self::$c['styleUrls'])) {
            $legacy->styleUrls = self::$c['styleUrls'];
        }

        // Set SCRIPT
        if (isset(self::$c['script'])) {
            $legacy->script = self::$c['script'];
        } elseif (isset(self::$c['scriptUrls'])) {
            $legacy->scriptUrls = self::$c['scriptUrls'];
        }

        if (isset(self::$c['template'])) {
            Programe::render(self::$c['template'], $this->component, false);
        } elseif (isset(self::$c['templateUrl'])) {
            Programe::render(self::$c['templateUrl'], $this->component);
        } else {
            Programe::render(DS.$this->router[0].DS.$this->router[0].'.view', $this->component);
        }
    }


    public function Oninit(array $loadFiles)
    {
    }


    /**
     * Method for calling Component Styles, if any
     * This method echos tagged styles if there is any for the component
     */
    public static function getComponentStyle()
    {
        if (!AirJax) {
            $legacy = Programe::getInstance('Legacy');
            if (isset($legacy->style)) {
                echo '<style>'.$legacy->style.'</style>';
            } elseif (isset($legacy->styleUrls)) {
                for ($i =0; $i < count($legacy->styleUrls); $i++) {
                    echo '<link rel="stylesheet" href="'.BaseUrl.'components'.DS.$legacy->styleUrls[$i].'">';
                }
            }
        }
    }


    /**
     * Method for calling Component Script, if any
     * Check to see if SPA ajax request is going to be used. if yes,
     * Dont load the script here, load it when the component is called at render()
    */
    public static function getComponentScript()
    {
        if (AirJax) {
            echo '<script src="'.CDN.'js'.DS.'airjax.js"></script>';
        } else {
            // <!-- Component Scripts -->

            if (isset($legacy->script)) {
                echo '<script>'.$legacy->script.'</script>';
            } elseif (isset($legacy->scriptUrls)) {
                for ($i =0; $i < count($legacy->scriptUrls); $i++) {
                    echo '<script src="'.BaseUrl.'components'.DS.$legacy->scriptUrls[$i].'"></script>';
                }
            }
        }
    }



    /**
     * Returns Component Title from Routes
     * First check for title membership in routes,
     * Else get the title of the Page from the $url
    **/
    public static function getComponentTitle():string
    {
        $legacy = Programe::getInstance('Legacy');
        if (isset($legacy->routerPath['title'])) {
            $title=$legacy->routerPath['title'];
        } else {
            if (isset($_GET['zenoUrlQuery'])) {
                $url = explode('/', (rtrim(strtolower($_GET['zenoUrlQuery']), '/')));
                $title = ucfirst($url[0]);
                for ($i=1; $i<count($url); $i++) {
                    $title.='->'.ucfirst($url[$i]);
                }
            } else {
                $title="Home";
            }
        }

        return $title;
    }


    /**
     * Renders Component to the browser
     * Converts Component public variables to json for view interpolation
    **/
    public static function render($component)
    {
        $cfile = $component.DS.$component.'.component';
        $vfile = $component.DS.$component.'.view';

        $cPath  = ($component == PROGRAME::$bootstrap)?
        $cfile.'.php':
        PROGRAME::$bootstrap.DS.'components'.DS.$cfile.'.php';

        // view path is different for bootstrap
        $vPath  = ($component == PROGRAME::$bootstrap) ?
        $vfile.'.php' :
        PROGRAME::$bootstrap.DS.'components'.DS.$vfile.'.php';

        // echo '<br/>view path is: '.$vPath.'<br/>';
        if (PROGRAME::autoload($cfile, 'component')) {
            // require_once $cPath;
            $component = explode('-', $component);

            $class = isset($component[1]) ?
            ucfirst($component[0]).ucfirst($component[1]).'Component' :
            ucfirst($component[0]).'Component';

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
                                ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) :
                                $routeComponentData[$routeComponentFields[$i]];
                        }
                    }

                    include_once $vPath;
                } else {
                    PROGRAME::reportError('The View File <i  class="bg-dark color-yellow padding-sm">'.$vPath.'</i> Was Not Found', 'Component Error');
                }
            } else {
                PROGRAME::reportError('The Components class <i  class="bg-dark color-yellow padding-sm">'.$class.' </i> does not exist', 'Component Error');
            }
        } else {
            PROGRAME::reportError('The Component File <i class="bg-dark color-yellow padding-sm">'.$cfile.'</i> Was Not Found', 'Component Error');
        }
    }
}
