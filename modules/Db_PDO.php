<?php

$db_config = include 'config/database.php';
$db = new PDO($db_config['dsn'], $db_config['username'], $db_config['password'], $db_config['options']);
yasCMS\Registry::getInstance()->getInstance()->set('db', $db);