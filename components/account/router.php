<?php

    class Router{

        private $route = array('0'=>'aleph','1'=>'beth','2'=>'gimmel','3'=>'daleth','4'=>'hey');
        
            // Setters & Getterws
        function Set($key, $value)
        {
            $this->$key = $value;

        }

        function Get($key)
        {
            if(isset($this->$key))
            {
                return $this->$key;
            }
            else
            {
                return null;
            }

        }


    
        function Navigator($url){

            //Set Variables for Navigatioin
        foreach ($url as $key => $value)
            {

                if (isset($this->route[$key]))
                {
                    $this->Set($this->route[$key], lcfirst($value));
                }
                else
                {
                    $this->Set($key, lcfirst($value));
                }

                
            }


            //Set default page and class
            require_once getcwd().DS.'components'.DS.$this->aleph.DS.'controllers'.DS.$this->aleph.'.php';;
            $class = new $this->aleph();


            if(isset($this->beth)){

                //First check the default controller to see if method exists
                if(method_exists($this->aleph,ucfirst($this->beth))){
                    $method = ucfirst($this->beth);
                    $class->$method();
                }
                
                else{


                                //If mehtod doesnt exist in the default controller, check to see if controller exists with that name
                            $path = getcwd().DS.'components'.DS.$this->aleph.DS.'controllers'.DS.$this->beth.'.php';
                            // echo $path;
                            if(file_exists($path)){
                                require_once $path;

                                //if file exists, check to see if the class exists
                                if(class_exists(ucfirst($this->beth))){
                                    $class= ucfirst($this->beth);
                                    $class = new $class;

                                    if(isset($this->gimmel)){
                                        if(method_exists($class,ucfirst($this->gimmel))){
                                            $method = ucfirst($this->gimmel);
                                            $class->$method();


                                        
                                        }else{
                                            //if method GIMMEL of Class BETH doesnt exists, show error or
                                            //I could still display the Main Function of of the class BETH
                                            require_once getcwd().DS.'templates'.DS.'sleek'.DS.'error.php';
                                        }
                                    }
                                    else{
                                        $class->Main();
                                    }
                                }
                            
                            //If file Beth exists BUT class BETH does not exist
                            else{
                                require_once getcwd().DS.'templates'.DS.'sleek'.DS.'error.php';
                            }
                        }
                        //If file does BETH not exist
                        else{

                            $class->Main();
                        }


                }

                
                
        }
        //If Beth Is not set
        else{

            $class->Main();
        }



        }

        // End Of Navigator Method


    }

    
?>