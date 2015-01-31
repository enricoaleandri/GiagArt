<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 05/06/14
 * Time: 23.17
 * To change this template use File | Settings | File Templates.
 */
class Response
{
    protected $content;
    protected $code;
    protected $location;
    protected $hasmap = array();
    protected $hasmap_error = array();

    public $code_text = array(
                        200 => "OK",
                        404 => "Not Found",
                        500 => "Server Error"
    );

    public function __construct($content = "", $code = 200)
    {
        $this->content = $content;
        $this->code = $code;
    }
    public function setProperty($key, $value)
    {
        $this->hasmap[$key] = $value;
    }
    public function getProperty($key)
    {
        return $this->hasmap[$key];
    }

    public function setError($key, $value)
    {
        $this->hasmap_error[$key] = $value;
    }
    public function getError($key)
    {
        return $this->hasmap_error[$key];
    }
    public function addContent($content)
    {
        $this->content .= $content;
    }
    public function setCode($code)
    {
        $this -> code = $code;
    }
    public function setLocation($location)
    {
        $this -> location = $location;
    }
    public function render()
    {
        if(!headers_sent())
        {
            switch($this -> code)
            {
                case 302:
                {
                    header('Location: ' . $this -> location, true, $this->code);
                    die();
                    break;
                }
                case 200:
                case 404:
                {
                    header("HTTP/1.0 " . $this->code . " " . $this->code_text[$this->code]);
                    break;
                }
            }
        }
        echo $this->content;
    }
}