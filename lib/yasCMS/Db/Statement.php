<?php

namespace yasMVC\Db;

abstract class Statement
{

    protected $driver = null;
    protected $stmt = null;
    protected $sql = null;
    protected $fetchMode = Driver::FETCH_ASSOC;

    public function __construct($driver, $sql)
    {
        $this->driver = $driver;
        $this->sql = $sql;
        $this->prepare($sql);
    }

    abstract public function prepare($sql);

    abstract public function setFetchMode($fetchMode);

    public function execute(array $params = null)
    {
        return $this->_execute($params);
    }

}

?>
