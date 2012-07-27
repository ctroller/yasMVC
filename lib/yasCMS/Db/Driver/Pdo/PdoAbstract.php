<?php

namespace yasMVC\Db\Driver\Pdo;

use yasMVC\Db\DatabaseException;

class PdoAbstract extends \yasMVC\Db\Driver
{

    protected $pdoType;
    protected $connection;

    protected function dsn()
    {
// baseline of DSN parts
        $dsn = $this->config;

// don't pass the username, password, charset, persistent and driver_options in the DSN
        unset($dsn['username']);
        unset($dsn['password']);
        unset($dsn['options']);
        unset($dsn['charset']);
        unset($dsn['persistent']);
        unset($dsn['driver_options']);

// use all remaining parts in the DSN
        foreach ($dsn as $key => $val) {
            $dsn[$key] = "$key=$val";
        }

        return $this->pdoType . ':' . implode(';', $dsn);
    }

    public function connect()
    {
        if ($this->connection) {
            return;
        }

        $dsn = $this->dsn();
        if (!in_array($this->pdoType, \PDO::getAvailableDrivers())) {
            throw new DatabaseException('PDO driver "' . $this->pdoType . '" not found!');
        }

        try {
            $this->connection = new \PDO(
                            $dsn,
                            $this->config['username'],
                            $this->config['password'],
                            $this->config['driver_options']
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PdoException $e) {
            throw new DatabaseException($e);
        }
    }

    protected function _beginTransaction()
    {
        $this->connect();
        $this->connection->beginTransaction();
    }

    protected function _commit()
    {
        $this->connect();
        $this->connection->commit();
    }
    
    protected function _rollBack() {
        $this->connect();
        $this->connection->rollBack();
    }
    
    public function lastInsertId()
    {
        $this->connect();
        return $this->connection->lastInsertId();
    }

}

?>
