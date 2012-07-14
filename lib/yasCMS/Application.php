<?php

namespace yasCMS;

class Application
{

    protected static $_instance;
    protected $controller;

    public static function getInstance()
    {
        if (self::$_instance === null) {
            $cls = get_called_class();
            self::$_instance = new $cls;
        }
        return self::$_instance;
    }

    public function run()
    {
        $found = $this->loadController();
        if (!$found) {
            require_once 'controller/errorController.class.php';
            $ctr_instance = new \errorController();
            $ctr_instance->errorAction();
        }

        $this->initSessionData($found);
    }

    protected function initSessionData()
    {
        $_SESSION['current_uri'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $_SESSION['current_controller'] = $this->controller;
    }

    protected function loadController()
    {
        $params = array();
        $controller = 'index';
        if (isset($_GET['params'])) {
            if (substr($_GET['params'], -1) == '/')
                $_GET['params'] = substr($_GET['params'], 0, -1);
            $prm = explode('/', $_GET['params']);
            $controller = $prm[0];
            $params = array_splice($prm, 1);
        }

        $this->controller = $controller;
        Registry::getInstance()->getInstance()->set('params', $params);
        $controller = 'controller/' . $controller . 'Controller.class.php';

        if (file_exists($controller)) {
            require_once $controller;
            $class = $page . 'Controller';
            $method = ( count($params) > 1 ? $params[0] . 'Action' : $controller . 'Action' );
            $ctr_instance = new $class();
            $ctr_instance->$method();
            return true;
        }

        return false;
    }

    public function getController() {
        return $this->controller;
    }
}