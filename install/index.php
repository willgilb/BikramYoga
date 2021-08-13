<?php

declare(strict_types=1);

require_once '../config.php';
require_once '../bootstrap.php';
require_once '../autoload.php';

use Model\Install;

$install = new Install;

$string = "CREATE TABLE IF NOT EXISTS `user_test` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	`email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	`pwhash` char(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `email` (`email`),
	UNIQUE KEY `username` (`username`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";


//var_dump($install->fromString($string));

//var_dump($install->fromFile('db.sql'));