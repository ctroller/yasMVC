<?php

namespace yasMVC\Loader;

class Moduleloader
{

    private static $loadedModules = array();

    public static function loadModule($moduleName)
    {
        if (!in_array($moduleName, self::$loadedModules)) {
            include_once 'modules/' . $moduleName . '.php';
            self::$loadedModules[] = $moduleName;
        }
    }

    public static function loadModules(array $modules)
    {
        foreach ($modules as $module) {
            self::loadModule($module);
        }
    }

}