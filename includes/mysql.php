<?php
//
require_once("../admin/includes/functions.php");
//attention les classes sont importés ici, car elles nécessitent la bdd
require_once("../class/MAP.php");
require_once("../class/USER.php");
require_once("../class/DB.php");
require_once("../class/OBJ.php");
require_once("../class/YEAR.php");

$DB = DB::getInstance();
$db = DB::$db;
