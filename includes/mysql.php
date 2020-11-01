<?php
require_once("../admin/includes/functions.php");
//attention les classes sont importés ici, car la plupart du temps les classe nécessite la bdd
require_once("../class/USER.php");
require_once("../class/DB.php");

$DB = DB::getInstance();
$db = DB::$db;
