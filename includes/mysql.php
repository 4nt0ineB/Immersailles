<?php

define('HOST', 'localhost');
define('DB_NAME', 'immersailles');
define('USER', 'immersailles');
define('PASS', 'root');


try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    $db->exec("set names utf8");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection to database failed";
}
?>