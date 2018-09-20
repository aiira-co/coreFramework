<?php
 namespace Lynq\Router;

class Routes
{
    private $_routers = [];
    private $_path = [];

    public function setRouter(array $r)
    {
        $this->_routers = $r;
    }

    public function getRouter():array
    {
        return $this->_routers;
    }

    public function getPath(string $url)
    {
        $gen = $this->_pathGen();
        $gen->send($url);
        $val = $gen->current();
        if ($val) {
            // echo $val;
            // echo $gen->getReturn();
            // echo 'path is found at text ONE';
            return $this->_path;
        }

        $gen->next();

        $val = $gen->current();


        if ($val) {
            //  echo $val;
            // echo $gen->getReturn();
            //  echo 'path is found at text TWO';

            $gen->next();

            $val = $gen->current();
            if ($val) {
                // echo $val;
                // echo $gen->getReturn();
                // echo 'path is found at text THREE';
                return $this->_path;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }



    private function _pathGen()
    {

              // /case ONE
        $path = [];
        $found = false;


        // get the url
        $url = yield;

        for ($i = 0; $i < count($this->_routers); $i++) {
            // echo $this->_routers[$i]['path'].' </br>';
            if ($this->_routers[$i]['path'] == $url) {
                $this->_path =  $this->_routers[$i];
                $found = true;
            }
        }



        yield $found;




        // case 2
        $url = explode('/', $url);
        // print_r($url);



        for ($i = 0; $i < count($this->_routers); $i++) {
            // echo $this->_routers[$i]['path'].' </br>';
            $pathX = explode('/', $this->_routers[$i]['path']);

            if ($pathX[0] == $url[0]) {
                $this->_path =  $this->_routers[$i];
                $pathM = $pathX;
                $found = true;
            }
        }





        yield $found;

        // case 3


        $urlCount = count($url);
        $pathCount = count($pathM);
        if ($urlCount == $pathCount) {
            // print_r($pathM);

            //assign parameters
            //check is it has a params property
            $xPath = explode('/:', $this->_path['path']);
            if (isset($xPath[1])) {
                $this->checkParams($url, $xPath);
            }



            yield $found;
        } else {
            yield false;
        }


        return $path;
    }




    //going to make use of a generator


    public function checkParams(array $u, array $p)
    {
        for ($i = 1; $i < count($p); $i++) {
            if (isset($u[$i])) {
                // To be called with the params
                $_REQUEST[$p[$i]] = $u[$i];
            } else {
                die('The Parameter <b>'.$p[$i].'</b> is not set. <h2>Not found <i>$_GET['.$p[$i].']</i></h2>');
            }
        }
    }



    public function checkSession($url, $returnTo)
    {
        if (!CoreSession::IsLoggedIn()) {
            Core::redirect(BaseUrl.$url, $returnTo);
        }
    }
}
