<?php
require_once("../admin/includes/functions.php");
require_once("../class/user.php"); //attention les classes sont importés ici, car la plupart du temps les classe nécessite la bdd


define('HOST', '51.210.15.73');
define('DB_NAME', 'immersailles');
define('USER', 'immersailles');
define('PASS', 'root');


try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    $db->exec("set names utf8");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    User::$db = $db; // set de la bdd dans l'objet user
} catch (PDOException $e) {
    echo $e;
}
