<?php

session_start();

use yasCMS\ModuleLoader;

date_default_timezone_set('Europe/Zurich');

define('SCRIPT_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');
define('__LIB__', 'lib');

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/lib');

require_once 'lib/Zend/Loader/StandardAutoloader.php';
$autoLoader = new Zend\Loader\StandardAutoloader(array(
            'fallback_autoloader' => true,
            'namespaces' => array(
                'yasCMS' => __LIB__ . '/yasCMS'
            )
        ));
$autoLoader->register();

ModuleLoader::loadModule('Db_PDO');
ModuleLoader::loadModule('Language');
ModuleLoader::loadModule('Navigation');