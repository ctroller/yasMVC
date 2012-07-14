<?php

use yasCMS\Registry;

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