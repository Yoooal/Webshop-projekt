<?php

// $databaseConfig = [
//     "dsn"             => "mysql:host=blu-ray.student.bth.se;dbname=jopg16;",
//     "username"        => "jopg16",
//     "password"        => "biG9QxodFm3h",
//     "driver_options"  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::ATTR_EMULATE_PREPARES => true],
// ];

$databaseConfig = [
    "dsn"             => "mysql:host=localhost;dbname=webshop;",
    "username"        => "user",
    "password"        => "pass",
    "driver_options"  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::ATTR_EMULATE_PREPARES => true],
];

return $databaseConfig;
