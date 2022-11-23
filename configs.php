<?php

$DB_SERVER = getenv("MVC_SERVER") ?: "192.168.10.15";
$DB_DATABASE = getenv("MVC_DB") ?: "fantoche";
$DB_USER = getenv("MVC_USER") ?: "fantoche";
$DB_PASSWORD = getenv("MVC_TOKEN") ?: "QUl7YhWm";
$DEBUG = getenv("MVC_DEBUG") ?: true;

return array(
    "DB_USER" => $DB_USER,
    "DB_PASSWORD" => $DB_PASSWORD,
    "DB_DSN" => "mysql:host=$DB_SERVER;port=3306;dbname=$DB_DATABASE;charset=utf8",
    "DEBUG" => $DEBUG
);

