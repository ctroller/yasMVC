<?php

namespace yasCMS\Controller;

use yasCMS\Http;

class Action
{

    private $scripts = array();

    public function __construct()
    {
        $this->request = new Http\Request();
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function parse($tpl, $doCache = false, $additionalCacheIdent = null)
    {
        $hashKey = $additionalCacheIdent . md5(( is_array($tpl) ? implode(';', $tpl) : $tpl ));
        $cacheFile = 'tpl_cache/' . $hashKey . '.html';
        if ($doCache && file_exists($cacheFile) && filemtime($cacheFile) > strtotime('-1 day')) {
            include $cacheFile;
            return;
        }

        $data = '';

        if (is_array($tpl)) {
            foreach ($tpl as $template) {
                $file = 'tpl/' . $template . '.php';
                if (file_exists($file)) {
                    include $file;
                    $data .= ob_get_contents();
                    ob_clean();
                }
            }
        } else {
            $file = 'tpl/' . $tpl . '.php';
            if (file_exists($file)) {
                include $file;
                $data .= ob_get_contents();
            }
        }

        ob_end_clean();

        if ($doCache)
            file_put_contents($cacheFile, $data);
        echo $data;
    }

    public function hasScripts()
    {
        return count($this->scripts) > 0;
    }

    public function getScripts()
    {
        return $this->scripts;
    }

    public function addScript($script)
    {
        $this->scripts[] = $script;
    }

}