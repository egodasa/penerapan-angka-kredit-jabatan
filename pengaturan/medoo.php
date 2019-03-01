<?php
$db_server = "localhost";
$db_username = "root";
$db_password = "mysql";
$db_database = "db_pangkat";

use Medoo\Medoo;

// Initialize
$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $db_database,
    'server' => $db_server,
    'username' => $db_username,
    'password' => $db_password
]);

?>
