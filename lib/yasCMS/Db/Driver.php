<?php

namespace yasCMS\Db;

abstract class Driver
{

    protected $connection;
    protected $errno = 0;
    protected $error = '';
    protected $config;

    const FETCH_ASSOC = 2;
    const FETCH_BOTH = 4;
    const FETCH_BOUND = 6;
    const FETCH_CLASS = 8;
    const FETCH_CLASSTYPE = 262144;
    const FETCH_COLUMN = 7;
    const FETCH_FUNC = 10;
    const FETCH_GROUP = 65536;
    const FETCH_INTO = 9;
    const FETCH_LAZY = 1;
    const FETCH_NAMED = 11;
    const FETCH_NUM = 3;
    const FETCH_OBJ = 5;
    const FETCH_ORI_ABS = 4;
    const FETCH_ORI_FIRST = 2;
    const FETCH_ORI_LAST = 3;
    const FETCH_ORI_NEXT = 0;
    const FETCH_ORI_PRIOR = 1;
    const FETCH_ORI_REL = 5;
    const FETCH_SERIALIZE = 524288;
    const FETCH_UNIQUE = 196608;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public static function factory($driver, array $config)
    {
        $driverClassName = 'yasCMS\\Db\\Driver\\' . $driver;
        try {
            $driver = new $driverClassName($config);
            return $driver;
        } catch (Exception $e) {
            return false;
        }
    }

    public function beginTransaction()
    {
        $this->connect();
        $this->_beginTransaction();
        return $this;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function getErrno()
    {
        return $this->errno;
    }

    public function setErrno($errno)
    {
        $this->errno = $errno;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function commit()
    {
        $this->connect();
        $this->_commit();
        return $this;
    }

    /**
     * Roll back a transaction and return to autocommit mode.
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function rollBack()
    {
        $this->connect();
        $this->_rollBack();
        return $this;
    }

    abstract protected function connect();

    abstract protected function _beginTransaction();

    abstract protected function _commit();

    abstract protected function _rollBack();
    
    abstract public function lastInsertId();
}