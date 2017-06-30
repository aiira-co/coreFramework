<?php


    class Core{


        private static $instance = [];


        // This Method is called in the root index.php file.
        // the Method intanciates the node class for routing
        function route(){

           require_once 'libraries'.DS.'core'.DS.'node.php';
           require_once 'libraries'.DS.'core'.DS.'legacy.php';
            $node = CORE::getInstance('Node');
            $node->router();
			// $this->aleph = $node->aleph;
        }




        // Method to Instantiate a class.
        // It first checks to see if class is available
        // if yes, return the instance of the class
        //   hence [new className]
        // if class is not available, require the class file, then repeat the
        // process again to instantiate

        public static function getInstance($class){


            // check if instance of the class already exist
            if (isset(self::$instance[$class]))
            {
                return self::$instance[$class];
            }
            else{
              // check if class is available
                if (!class_exists($class))
                {
                    self::Autoload($class);
                }

                // if the argument entered is PDO, then return the Database connection
                if($class == 'pdo')
                {
        					$adConfig = new AdConfig;

        					//Select the dbtype, whether mysql, mysqli,mssql, oracle, sqlite etc
        					if($adConfig->dbtype == "mysqli" || $adConfig->dbtype == "mysql")
        					{
        						self::$instance[$class] = new PDO("mysql:host = $adConfig->host;dbname=$adConfig->db",$adConfig->user,$adConfig->password);
        					}
                  elseif($config->server == "oracle")
        					{
        						self::$instance[$class] = new PDO("oci:dbname=".$adConfig->db,$adConfig->user,$adConfig->password);
        					}
                  elseif($config->server == "mssql")
        					{
                    self::$instance[$class] = new PDO("mssql:host = $adConfig->host;dbname=$adConfig->db",$adConfig->user,$adConfig->password);
        					}

                }
                else
                {
				// $formatClass = ucfirst($class)
                self::$instance[$class] = new $class;
                }

                return self::$instance[$class];
            }

        }




        // Instantiate a Model
        // This class requires attention
        // First path must be 'components/model/[name].model.php'
        //Also set a second parameter for it to check the path

        public static function getModel($model, $path = null){

                $file = $path??'components'. DS .'models'.DS.$model .'.model.php';

                $class = ucfirst($model).'Model';
              if(class_exists($class)){
                return new $class;
              }else{

                if (file_exists($file)){

                  require_once $file;
                  if(class_exists($class)){
                    return new $class;
                  }else{
                    die('The Class '.$class.' does not exist in the file '.$file);
                  }

                }else{
                  die('The Model Path '.$file.' Was Not FOUND!!');

                }
              }

        }


        // Instantiate a Plugin
        //I have never used this plugin before. Work on it.
        public static function getPlugin($plugin){
          require_once 'plugins/index.php';
          $plugins = new Plugins($plugin);


            if (isset($plugins->$plugin)){
              $plugin = $plugins->$plugin;
              // print_r($plugin);
              $file = $plugin['path'];
              $class = $plugin['class'];

              if (file_exists($file)){
                require_once $file;

                if(class_exists($class)){
                  return new $class;
                }else{
                  return null;
                }
              }else {
                return null;
              }
            }
            else{
              return null;
            }

          //  $plugins;
        }





        // Automatically load required for to instatiate the class
        private static function autoload($class)
      	{
          // echo memory_get_usage();
          $node = CORE::getInstance('Node'); //check to see if you can reduced memory usage here
      		$paths = ['libraries'.DS.'core','components'.DS.$node->aleph];
      		foreach ($paths as $path)
      		{
      			$file = $path.DS.strtolower($class).'.php';

      			// echo '<p>'.$file.'</p>';

      			if (file_exists($file))
      			{
      			require_once $file;
      			   return true;
      			}

      		}




	}





    // Renders
    // This method takes the view and component obj for rendering.
    // it sets them for the CoreApp Method which is ad only declared in the
    // workspace template where the component will be seen in the UI of the app or
    // website.

    public static function render(string $view, $component, bool $url = true)
	{
		$legacy = CORE::getInstance('Legacy');
    $node = CORE::getInstance('Node');

    // Set view in Legacy for CoreApp()
		$legacy->set('view',$view);
    $legacy->url = $url;

    // Set component in  Legacy for CoreApp()
    if(!empty($component)){$legacy->set('component', $component);}

    $adConfig = new AdConfig;
		$tmpl = $adConfig->template;

		$basket = CORE::getInstance('Basket');
		$params = CORE::getInstance('Params');


    // Check Params to for template variable.
    // i.e http://server.com/?template=[tmpName]
		if (($params->get('template')) != null)
		{
			$file = 'templates'.DS.$params->template.DS.'index.php';
			//check if it exists
			if (file_exists($file))
			{$tmpl = $template;}
			else{$tmpl = 'sleek';}
		}

    // API for rendering

		if (($params->get('api')) == 'json' && ($params->get('hash')) == ($adConfig->secret))
		{

			echo json_encode($component);

		}elseif ( ($adConfig->airJax && $params->get('api') == 'airJax') || ( ($params->get('api')) == 'html' && ($params->get('hash')) == ($adConfig->secret) ))
		{



      $routeComponent= $component;
      // print_r($routeComponent);

      $routeComponentData = json_decode(json_encode($routeComponent),true);
      $routeComponentLength = count($routeComponentData);


      if($routeComponentLength > 0){


        $routeComponentFields= array_keys($routeComponentData);


        // echo 'routeComponent is not empty';

        // Make Component variable available to View
          for($i=0; $i < $routeComponentLength; $i++)
          {
            ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
            ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];


          }


      }


      if($url){

        require_once 'components'.DS.$view.'.php';


      }else{
        // echo str_replace('{{'.$search.'}}', $replace, $coreLegacy->view);
        // Replace vairbles in template words with component vairbles
            for($i=0; $i < $routeComponentLength; $i++)
            {
              // echo ${$routeComponentData[$i]};
              $view = str_replace("{{".$routeComponentFields[$i]."}}", $routeComponentData[$routeComponentFields[$i]], $view);

            }
            // echo $edited;
        echo '<br/>'.$view;
      }



		}else{

			require_once 'templates'.DS.$tmpl.DS.'index.php';

		}




	}



	public static function CoreApp()
	{
		$coreLegacy = CORE::getInstance('Legacy');
		$coreNode = CORE::getInstance('Node');
		$coreView = $coreLegacy->view;

    // Make Component vairbles available to view
    // self::componentVariables($coreLegacy->component);
    $routeComponent= $coreLegacy->component;
    // print_r($routeComponent);

    $routeComponentData = json_decode(json_encode($routeComponent),true);
    $routeComponentLength = count($routeComponentData);


    if($routeComponentLength > 0){


      $routeComponentFields= array_keys($routeComponentData);


      // echo 'routeComponent is not empty';

      // Make Component variable available to View
        for($i=0; $i < $routeComponentLength; $i++)
        {
          ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
          ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];


        }


    }



	if($coreLegacy->url){
    $coreFile = 'components'.DS.strtolower($coreView).'.php';

    if (file_exists($coreFile))
    {
      require_once $coreFile;

    }else{

      echo '<h2>The View File <i>'.$coreFile.'</i> Was Not Found</h2>';

    }


  }else{
    // echo str_replace('{{'.$search.'}}', $replace, $coreLegacy->view);
    // Replace vairbles in template words with component vairbles
        for($i=0; $i < $routeComponentLength; $i++)
        {
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

  public static function component($component){
  $cPath  = 'components'.DS.$component.DS.$component.'.component.php';
  $vPath  = 'components'.DS.$component.DS.$component.'.view.php';

    if(file_exists($cPath)){
      require_once $cPath;
      $component = explode('-',$component);
      $class = isset($component[1]) ? ucfirst($component[0]).ucfirst($component[1]).'Component' :ucfirst($component[0]).'Component';
      if(class_exists($class)){
        $routeComponent = new $class;

        if(file_exists($vPath)){
          if(method_exists($routeComponent,'constructor')){
            $routeComponent->constructor();
          }
          // Make Component variable available to View
          $routeComponentData = json_decode(json_encode($routeComponent),true);
          $routeComponentLength = count($routeComponentData);


          if($routeComponentLength > 0){


            $routeComponentFields= array_keys($routeComponentData);


            // echo 'routeComponent is not empty';

            // Make Component variable available to View
              for($i=0; $i < $routeComponentLength; $i++)
              {
                ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
                ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];


              }


          }

          require_once $vPath;
        }else{
            echo '<h2>The View File <i>'.$vPath.'</i> Was Not Found</h2>';
        }

      }else {
        echo '<h2>The Components class <i>'.$class.' </i> does not exist</h2>';
      }
    }else{
      echo '<h2>The Component File <i>'.$cPath.'</i> Was Not Found</h2>';
    }

}







    // Make Component vairbles available to view
    private static function componentVariables($component = null){
      $routeComponent= $component;
      // print_r($routeComponent);

      $routeComponentData = json_decode(json_encode($routeComponent),true);
      $routeComponentLength = count($routeComponentData);


      if($routeComponentLength > 0){


        $routeComponentFields= array_keys($routeComponentData);


        // echo 'routeComponent is not empty';

        // Make Component variable available to View
          for($i=0; $i < $routeComponentLength; $i++)
          {
            ${$routeComponentFields[$i]} = (is_array($routeComponentData[$routeComponentFields[$i]]) || ($routeComponentData[$routeComponentFields[$i]] instanceof Traversable))
            ? json_decode(json_encode($routeComponentData[$routeComponentFields[$i]])) : $routeComponentData[$routeComponentFields[$i]];


          }


      }

    }


  // Method for redirecting.
  // This method is also used in the node class for redirecting routes

	public static function redirect($url, $redirectTo = false, $code = 302)
	{
      $adConfig = new AdConfig;

      if($redirectTo){
        $airJaxURL = '&api=airJax';
        $url = $adConfig->airJax ? $url.$redirectTo.$airJaxURL : $url.$redirectTo;
      }else{
        $airJaxURL = '?api=airJax';
        $url = $adConfig->airJax ? $url.$airJaxURL : $url;
      }


	    if (strncmp('cli', PHP_SAPI, 3) !== 0)
	    {
		if (headers_sent() !== true)
		{
		    if (strlen(session_id()) > 0) // if using sessions
		    {
		        session_regenerate_id(true); // avoids session fixation attacks
		        session_write_close(); // avoids having sessions lock other requests
		    }

		    if (strncmp('cgi', PHP_SAPI, 3) === 0)
		    {
		        header(sprintf('Status: %03u', $code), true, $code);
		    }

		    header('Location: ' . $url, true, (preg_match('~^30[1237]$~', $code) > 0) ? $code : 302);
		}

		exit();
	    }
	}




  public static function airJax(){

    require_once 'node.php';
    require_once 'legacy.php';
    $node = new node;
    $node->airJaxRouter();

  }

    }

    // import components and services(models)

  class import{
    function __construct(string $n, string $p){
      $file = getcwd().DS.'components'.DS.$p.'.php';

      if(file_exists($file))
      {
        require_once $file;
        $this->instance($n);

      }else{
        die('Importing file '.$n.' was not found!!');
      }

    }

    private function instance(string $n){

              $class = explode(',',trim($n,' '));


              for($i = 0; $i < count($class); $i++){
                print_r($class[0]);
                if(class_exists($class[$i])){
                  $this->set($class[$i], new $class[$i]);
                }else{
                  die('The Class '.$class[$i].' does not exist in the imported path');
                }
              }

    }

    private function set($key,$value){
      $this->$key = $value;
    }
  }

 function import(string $p){
  $file = getcwd().DS.'components'.DS.$p.'.php';

  if(file_exists($file))
  {
    require_once $file;

    // $class = explode(',',trim($n,' '));
    //
    //
    // for($i = 0; $i < count($class); $i++){
    //   print_r($class[0]);
    //   if(class_exists($class[$i])){
    //     return ${$class[$i]} = new $class[$i];
    //   }else{
    //     die('The Class '.$class[$i].' does not exist in the imported path');
    //   }
    // }

  }else{
    die('Importing file '.$p.' was not found!!');
  }

}




?>
