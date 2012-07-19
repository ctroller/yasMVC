<?php

namespace yasCMS\Http;

class Request
{

    private $controller;
    private $action;
    private $params;

    public function __construct()
    {
        $parts = explode('/', str_replace(SCRIPT_PATH, '', $_SERVER['REQUEST_URI']));
        $parts = array_filter($parts);

        $this->controller = ($c = array_shift($parts)) ? $c : 'index';
        $this->action = ($c = array_shift($parts)) ? $c : 'index';
        $this->params = (isset($parts[0])) ? $parts : array();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function hasParams()
    {
        return count($this->params) > 0;
    }

    public function getParam($index, $default = null)
    {
        return array_key_exists($index, $this->params) ? $this->params[$index] : $default;
    }

}