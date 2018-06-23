<?php
require_once "env.php";
/**
 * Bootstrap the database
 */
try{
    $conn = new PDO("mysql:host=$db_host", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("CREATE DATABASE IF NOT EXISTS $db_name");
    /**
     * Create tables.
     */
    $conn->exec("USE $db_name");
    $conn->exec("CREATE TABLE IF NOT EXISTS todo (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        item LONGTEXT NOT NULL,
        priority INT,
        is_completed BOOLEAN not null default 0
        )");
    echo "DB successfully bootstrapped.";
}
catch(Exception $e){
    die("Error bootstrapping mysql " . $e->getMessage());
}
