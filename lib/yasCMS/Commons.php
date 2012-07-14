<?php

namespace yasCMS;

class Commons
{

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

}