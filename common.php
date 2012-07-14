<?php

session_start();

use yasCMS\Registry;

date_default_timezone_set('Europe/Zurich');

define('SCRIPT_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');
define('__LIB__', 'lib');

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/lib');

require_once 'lib/Zend/Loader/StandardAutoloader.php';
$autoLoader = new Zend\Loader\StandardAutoloader(array(
            'fallback_autoloader' => true,
            'namespaces' => array(
                'Tse' => __LIB__ . '/Tse',
                'yasCMS' => __LIB__ . '/yasCMS'
            )
        ));
$autoLoader->register();


$db_config = include 'config/database.php';
$db = new PDO($db_config['dsn'], $db_config['username'], $db_config['password'], $db_config['options']);
Registry::getInstance()->getInstance()->set('db', $db);
$languages = array('de', 'en');
Registry::getInstance()->getInstance()->set('languages', $languages);

$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$session_lang = &$_SESSION['language'];
if ($session_lang === null) {
    $cookie_lang = &$_COOKIE['language'];
    if ($cookie_lang !== null) {
        $session_lang = $cookie_lang;
    } else if (in_array($browser_lang, $languages)) {
        $session_lang = $browser_lang;
    } else {
        $session_lang = $languages[0];
    }
}

$_SESSION['language'] = $session_lang;
setcookie('language', $session_lang, time() + (60 * 60 * 24 * 30));
Registry::getInstance()->getInstance()->set('lang', $session_lang);

Registry::getInstance()->getInstance()->set('nav', include( 'modules/navigation.php'));
//rvDPXGWm0Iuly6d
$salt = 'tsetroller2012*)69]3s>:P}Q-$1';
$bcrypt = new Zend\Crypt\Password\Bcrypt(array('salt' => $salt));