<?php

session_start();

date_default_timezone_set('Europe/Zurich');

define('SCRIPT_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');
define('__LIB__', 'lib');

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/lib');

require_once 'lib/yasCMS/Loader/Autoloader.php';

$yasLoader = new yasCMS\Loader\AutoLoader();
$yasLoader->registerNamespace('yasCMS', __LIB__ );
$yasLoader->register();