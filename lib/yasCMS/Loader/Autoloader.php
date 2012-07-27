<?php

namespace yasMVC\Loader;

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

class Autoloader
{

    private $namespaces = array();
    private $prefixes = array();
    private $useIncludePath = false;

    public function setUseIncludePath($useIncludePath)
    {
        $this->useIncludePath = (bool) $useIncludePath;
    }

    public function registerNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $paths) {
            $this->registerNamespace($namespace, $paths);
        }
    }

    public function registerNamespace($namespace, $paths)
    {
        $this->namespaces[$namespace] = (array) $paths;
    }

    public function registerPrefixes(array $prefixes)
    {
        foreach ($prefixes as $prefix => $paths) {
            $this->registerPrefix($prefix, $paths);
        }
    }

    public function registerPrefix($prefix, $paths)
    {
        $this->prefixes[$prefix] = (array) $paths;
    }

    public function autoload($class)
    {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return false;
        }

        $file = $this->findFile($class);
        if ($file)
            include $file;
    }

    public function findFile($class)
    {
        $className = ltrim($class, '\\');
        if (false !== $lastNsPos = strrpos($className, '\\')) {
            // we got a namespace
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $normalizedClass = str_replace('\\', DS, $namespace) . DS . str_replace('_', DS, $className) . '.php';

            foreach ($this->namespaces as $ns => $dirs) {
                if (0 !== strpos($namespace, $ns)) {
                    continue;
                }

                foreach ($dirs as $dir) {
                    $file = $dir . DS . $normalizedClass;
                    if (is_file($file)) {
                        return $file;
                    }
                }
            }
        } else {
            // PEAR? I love PEARs.
            $normalizedClass = str_replace('_', DS, $class) . '.php';
            foreach ($this->prefixes as $prefix => $dirs) {
                if (0 !== strpos($class, $prefix)) {
                    continue;
                }

                foreach ($dirs as $dir) {
                    $file = $dir . DS . $normalizedClass;
                    if (is_file($file)) {
                        return $file;
                    }
                }
            }
        }

        if ($this->useIncludePath && $file = stream_resolve_include_path($normalizedClass)) {
            return $file;
        }
    }

    public function register()
    {
        spl_autoload_register(array($this, 'autoload'), true);
    }

    public function unregister()
    {
        spl_autoload_unregister(array($this, 'autoload'));
    }

}
