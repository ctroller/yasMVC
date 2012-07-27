<?php

namespace yasCMS\Db\Statement;

use \PDOException;

class Pdo extends \yasCMS\Db\Statement
{

    protected $stmt;

    public function prepare($sql)
    {
        $this->stmt = $this->driver->getConnection()->prepare($sql);
    }

    public function setFetchMode($fetchMode)
    {
        try {
            $this->stmt->setFetchMode($fetchMode);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function fetch($style = null, $cursor = null, $offset = null)
    {
        if ($style === null) {
            $style = $this->fetchMode;
        }

        try {
            return $this->stmt->fetch($style, $cursor, $offset);
        } catch (PDOException $e) {
            
        }
    }

    public function fetchObject($class = 'stdClass', array $config = array())
    {
        try {
            return $this->stmt->fetchObject($class, $config);
        } catch (PDOException $e) {
            
        }
    }

    public function fetchColumn()
    {
        try {
            return $this->stmt->fetchColumn();
        } catch (PDOException $e) {
            
        }
    }

    public function _execute(array $params = null)
    {
        try {
            if ($params !== null) {
                return $this->stmt->execute($params);
            } else {
                return $this->stmt->execute();
            }
        } catch (PDOException $e) {
            
        }
    }

    public function fetchAll($style = null, $col = null)
    {
        if ($style === null) {
            $style = $this->fetchMode;
        }
        try {
            if ($style == \PDO::FETCH_COLUMN) {
                if ($col === null) {
                    $col = 0;
                }
                return $this->stmt->fetchAll($style, $col);
            } else {
                return $this->stmt->fetchAll($style);
            }
        } catch (PDOException $e) {
            
        }
    }

    public function rowCount()
    {
        try {
            return $this->stmt->rowCount();
        } catch (PDOException $e) {
            
        }
    }

}