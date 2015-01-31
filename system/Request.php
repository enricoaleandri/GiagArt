<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 03/06/14
 * Time: 16.54
 * To change this template use File | Settings | File Templates.
 */


class Request
{
    protected $get = array();
    protected $post = array();
    protected $parameters = array();
    protected $request = array();
    protected $action;
    protected $controller;
    protected $view;

    public function  __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
        $this->parameters = array();
    }

    public function is_set($name)
    {
        if(isset($this->get[$name]) || isset($this->post[$name]) || isset($this->request[$name]) || isset($this->parameters[$name]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getServerVar($id)
    {
        return isset($_SERVER[$id]) ? $_SERVER[$id] : '';
    }
    public function get($name)
    {
        if(isset($this->parameters[$name]))
        {
            return $this->parameters[$name];
        }
        if(isset($this->get[$name]))
        {
            return $this->get[$name];
        }
        if(isset($this->post[$name]))
        {
            return $this->post[$name];
        }
        if(isset($this->request[$name]))
        {
            return $this->request[$name];
        }
        Logger::log(Logger::$INFO, "No data found for key : $name");
        return "";
    }
    public function set($key, $value)
    {

        Logger::log(Logger::$INFO, "Added parameter in a Request $key = $value");
        $this->parameters[$key] = $value;
    }

    public function toString()
    {
        $request = array();
        $request['POST'] = $_POST;
        $request['GET'] = $_GET;
        $request['REQUEST'] =  $_REQUEST;
        $request['FILE'] =  $_FILES;
        $request['PARAMETERS'] =  $this->parameters;
        return print_r($request, true);
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }


}


?>