<?php

namespace yasMVC\Controller;

use yasMVC\Http;
use yasMVC\View\View;

abstract class Action
{

    protected $view;
    private $scripts = array();

    public function __construct()
    {
        $this->request = new Http\Request();
        $this->view = new View($this->request);
        $this->init();
    }

    public function init()
    {
        
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function hasScripts()
    {
        return count($this->scripts) > 0;
    }

    public function getScripts()
    {
        return $this->scripts;
    }

    public function addScript($script)
    {
        $this->scripts[] = $script;
    }

    public function render($fname = null)
    {
        $controller = $this->request->getController();
        $action = $this->request->getAction();

        return $this->view->render(strtolower($controller) . '/' . strtolower($action) . ( $fname === null ? '.phtml' : '/' . $fname ));
    }

}