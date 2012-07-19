<?php

namespace yasCMS;

class Application
{

    protected static $_instance;
    protected $request;

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
        Session::set('current_uri', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        Session::set('current_controller', $this->getRequest()->getController());
    }

    protected final function loadController()
    {
        $this->setRequest();
        $controllerFile = 'controller/' . $this->request->getController() . 'Controller.class.php';

        if (file_exists($controllerFile)) {
            include_once $controllerFile;
            $class = $this->request->getController() . 'Controller';
            $action = ( $this->request->getAction() ? $this->request->getAction() . 'Action' : $this->request->getController() . 'Action' );

            $ctr_instance = new $class();
            if (method_exists($ctr_instance, $action))
                call_user_func(array($ctr_instance, $action));
            else
                call_user_func(array($ctr_instance, $this->request->getController() . 'Action'));

            return true;
        }

        return false;
    }

    private final function setRequest()
    {
        $this->request = new Http\Request();
    }

    public final function getRequest()
    {
        return $this->request;
    }

}