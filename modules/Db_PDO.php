<?php

$db_config = include 'config/database.php';
$db = new PDO($db_config['dsn'], $db_config['username'], $db_config['password'], $db_config['options']);
yasMVC\Registry::getInstance()->getInstance()->set('db', $db);