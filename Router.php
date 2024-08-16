
<?php

use Controller\ProjController;
class Router
{
    private $links = array();
    private $defaultRoute = array();


    public function addURL($url, $controller, $action)
    {
        #$newURL = self::convertForm($url);
        $this->links[$url] = array("controller" => $controller , "action" => $action);
    }
    public function convertForm($string)
    {
        $arr = explode("/", $string);
        array_splice($arr,0,1);
        $newForm = implode("/", $arr);
        return $newForm;
    }
    public function dispatch($url)
    {
        $newURL = self::convertForm($url);
        if (array_key_exists($this->convertForm($url), $this->links))
        {
            $controller = $this->links[$newURL]["controller"];
            $action = $this->links[$newURL]["action"];
            
            $controller::$action();

        }
        else
        {

            $controller = $this->defaultRoute["controller"];
            $action = $this->defaultRoute["action"];
            $controller::$action();
        }
    }

    public function addDefaultRoute($controller, $action)
    {
        $this->defaultRoute["controller"] = $controller;
        $this->defaultRoute["action"] = $action;
    }
}



?>
