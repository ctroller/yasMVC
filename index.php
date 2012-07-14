<?php

use yasCMS\Registry;
include 'common.php';

$params = array();
$page = 'index';
if (isset($_GET['params'])) {
    if (substr($_GET['params'], -1) == '/')
        $_GET['params'] = substr($_GET['params'], 0, -1);
    $prm = explode('/', $_GET['params']);
    $page = $prm[0];
    $params = array_splice($prm, 1);
}

Registry::getInstance()->getInstance()->set('page', $page);
Registry::getInstance()->getInstance()->set('params', $params);
Registry::getInstance()->getInstance()->set('keywords',array());

$controller = 'controller/' . $page . 'Controller.class.php';
// check if controller exists
if (file_exists($controller)) {
    require_once $controller;
    $class = $page . 'Controller';
    $method = ( count($params) > 1 ? $params[0] . 'Action' : $page . 'Action' );
    $ctr_instance = new $class();
    $ctr_instance->$method();
} else {
    // check if a PAGE exists
    $sql = "SELECT * FROM page_content AS pc LEFT JOIN page AS p ON p.page_id = pc.page_id WHERE page_identifier = :ident AND language_code = :lang AND visible = 1";
    $db = Registry::getInstance()->get('db');
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ident', $page, PDO::PARAM_STR);
    $stmt->bindParam(':lang', Registry::getInstance()->get('lang'), PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $ctr_instance = new yasCMS\Page($stmt->fetch());
        $ctr_instance->displayPage();
    } else {
        require_once 'controller/errorController.class.php';
        $ctr_instance = new errorController();
        $ctr_instance->errorAction();
    }
}

$_SESSION['current_uri'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['current_controller'] = $page;
?>