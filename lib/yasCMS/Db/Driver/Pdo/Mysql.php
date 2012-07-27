<?php

namespace yasMVC\Db\Driver\Pdo;

use yasMVC\Db\Statement\Pdo as Statement;

class Mysql extends PdoAbstract
{

    protected $pdoType = 'mysql';

    public function prepare($sql)
    {
        $this->connect();
        return new Statement($this, $sql);
    }

}

?>
