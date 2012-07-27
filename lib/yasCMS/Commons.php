<?php

namespace yasCMS;

class Commons
{
    public static function internalRedirect($url)
    {
        $protocol = 'http';
        if (Http\Request::getServer('HTTPS') == 'on') {
            $protocol .= 's';
        }

        self::redirect($protocol . '://' . $_SERVER['HTTP_HOST'] . SCRIPT_PATH . $url);
    }

    public static function redirect($url)
    {
        header('HTTP/1.1 301 Moved Permanently');
        $hasProtocol = strstr($url, '://') !== false;
        if ($hasProtocol) {
            header('Location: ' . $url);
        } else {
            $protocol = 'http';
            if ($_SERVER['HTTPS'] == 'on') {
                $protocol .= 's';
            }

            header('Location: ' . $protocol . '://' . $url);
        }

        header('Connection: close');
    }

    public static function onOff($value)
    {
        return $value == 'on' ? 1 : 0;
    }

}