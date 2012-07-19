<?php

namespace yasCMS;

class Registry implements \IteratorAggregate, \ArrayAccess, \Countable
{

    private $_array;
    private static $_instance;

    public static function getInstance()
    {
        if (self::$_instance === null)
            self::$_instance = new self;

        return self::$_instance;
    }

    private function __construct()
    {
        $this->_array = new \ArrayObject();
    }

    public function get($index, $default = null)
    {
        if (!$this->offsetExists($index)) {
            return $default;
        }

        return $this->offsetGet($index);
    }

    public function set($index, $value)
    {
        $this->offsetSet($index, $value);
    }

    // method required by the IteratorAggregate interface
    public function getIterator()
    {
        return $this->_array->getIterator();
    }

    // method required by the ArrayAccess interface
    public function offsetExists($index)
    {
        return $this->_array->offsetExists($index);
    }

    // method required by the ArrayAccess interface
    public function offsetGet($index)
    {
        return $this->_array->offsetGet($index);
    }

    // method required by the ArrayAccess interface
    public function offsetSet($index, $newval)
    {
        return $this->_array->offsetSet($index, $newval);
    }

    // method required by the ArrayAccess interface
    public function offsetUnset($index)
    {
        return $this->_array->offsetUnset($index);
    }

    // method required by the Countable interface
    public function count()
    {
        return $this->_array->count();
    }

}