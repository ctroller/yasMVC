<?php

namespace yasMVC\View;

abstract class AbstractView
{

    private $_file;
    private $_encoding;
    private $_escape;
    private $_strictVars = false;
    private $_scriptPaths;
    private $_jsScripts = array();

    public function __construct(\yasMVC\Http\Request $request = null)
    {
        $this->addScriptPath('tpl/');
        $this->setRequest($request);
        $this->init();
    }

    public function init()
    {
        
    }

    public function __get($key)
    {
        if ($this->_strictVars) {
            trigger_error('Key "' . $key . '" does not exist', E_USER_NOTICE);
        }

        return null;
    }

    public function __isset($key)
    {
        if ('_' != substr($key, 0, 1)) {
            return isset($this->$key);
        }

        return false;
    }

    public function __set($key, $val)
    {
        if ('_' != substr($key, 0, 1)) {
            $this->$key = $val;
            return;
        }

        throw new Exception('Setting private or protected class members is not allowed');
    }

    public function __unset($key)
    {
        if ('_' != substr($key, 0, 1) && isset($this->$key)) {
            unset($this->$key);
        }
    }

    public function setEscape($spec)
    {
        $this->_escape = $spec;
        return $this;
    }

    public function assign($spec, $value = null)
    {
        // which strategy to use?
        if (is_string($spec)) {
            // assign by name and value
            if ('_' == substr($spec, 0, 1)) {
                $e = new \Exception('Setting private or protected class members is not allowed');
                throw $e;
            }
            $this->$spec = $value;
        } elseif (is_array($spec)) {
            // assign from associative array
            $error = false;
            foreach ($spec as $key => $val) {
                if ('_' == substr($key, 0, 1)) {
                    $error = true;
                    break;
                }
                $this->$key = $val;
            }
            if ($error) {
                $e = new \Exception('Setting private or protected class members is not allowed');
                throw $e;
            }
        } else {
            $e = new \Exception('assign() expects a string or array, received ' . gettype($spec));
            $e->setView($this);
            throw $e;
        }

        return $this;
    }
    
    public function render($name)
    {
        $this->_file = $this->_script($name);
        $this->_run($this->_file);
    }

    public function escape($var)
    {
        if (in_array($this->_escape, array('htmlspecialchars', 'htmlentities'))) {
            return call_user_func($this->_escape, $var, ENT_COMPAT, $this->_encoding);
        }

        if (1 == func_num_args()) {
            return call_user_func($this->_escape, $var);
        }
        $args = func_get_args();
        return call_user_func_array($this->_escape, $args);
    }

    public function setEncoding($encoding)
    {
        $this->_encoding = $encoding;
        return $this;
    }

    public function addScriptPath($scriptPath)
    {
        $this->_scriptPaths[] = $scriptPath;
        return $this;
    }

    public function getScriptPaths()
    {
        return $this->_scriptPaths;
    }

    public function getEncoding()
    {
        return $this->_encoding;
    }

    public function strictVars($flag = true)
    {
        $this->_strictVars = ($flag) ? true : false;

        return $this;
    }

    protected function _script($name)
    {
        foreach ($this->_scriptPaths as $dir) {
            if (is_readable($dir . $name)) {
                return $dir . $name;
            }
        }

        $message = "script '$name' not found in path ("
                . implode(PATH_SEPARATOR, $this->_scriptPaths)
                . ")";
        $e = new \Exception($message);
        throw $e;
    }

    abstract protected function _run();

    public function addJSScript($scriptContent)
    {
        if (!array_key_exists('normal', $this->_jsScripts))
            $this->_jsScripts['normal'] = array();

        $this->_jsScripts['normal'][] = $scriptContent;
    }

    public function addJSScriptFile($fileName)
    {
        if (!array_key_exists('file', $this->_jsScripts))
            $this->_jsScripts['file'] = array();

        $this->_jsScripts['file'][] = $fileName;
    }

    public function getJSScripts()
    {
        return array_key_exists('normal', $this->_jsScripts) ? $this->_jsScripts['normal'] : array();
    }

    public function getJSScriptFiles()
    {
        return array_key_exists('file', $this->_jsScripts) ? $this->_jsScripts['file'] : array();
    }

    public function hasJSScripts()
    {
        return count($this->_jsScripts) > 0;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setRequest(\yasMVC\Http\Request $request)
    {
        if ($request === null) {
            $this->request = new yasMVC\Http\Request();
        } else {
            $this->request = $request;
        }
    }

}