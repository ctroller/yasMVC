<?php

namespace yasCMS;

class ModuleLoader
{

    private static $loadedModules = array();

    public static function loadModule($moduleName)
    {
        if (!in_array($moduleName, self::$loadedModules)) {
            include_once 'modules/' . $moduleName . '.php';
            self::$loadedModules[] = $moduleName;
        }
    }

}