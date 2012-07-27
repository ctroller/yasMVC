<?php

session_start();

date_default_timezone_set('Europe/Zurich');

define('SCRIPT_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');
define('__LIB__', 'lib');

require_once 'lib/yasMVC/Loader/Autoloader.php';

$yasLoader = new yasMVC\Loader\AutoLoader();
$yasLoader->registerNamespace('yasMVC', __LIB__ );
$yasLoader->register();