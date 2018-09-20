<?php namespace Lynq\Router;

class ActivatedRoute
{
    protected $params = [];
    public function __construct()
    {
        foreach ($_REQUEST as $key => $value) {
            // clean it of any html params
            // for $_GET only: Remove an html tags and quotes
            if (!(is_array($value) || ($value instanceof Traversable))) {
                $this->params[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } else {
                $this->params[$key] = $value;
            }
        }
    }

    private function getParam($param, $args = [])
    {
        // Check if the param exists
        if (! array_key_exists($param, $this->params)) {
            throw new \Exception("The Service: $service_name does not exist.");
        }
        if (! empty($args)) {
            return $this->services[$service_name]($args);
        }
        // Return the existing Param
        return $this->params[$param];
    }

    public function __set($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function __get($key)
    {
        return $this->getParam($key);
    }
    // function set($key, $value){
    // 		$this->$key = $value;
    // }
}
