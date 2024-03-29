<?php

require_once('./class/DB.php');
try {
    $DB = DB::getInstance();
    $db = DB::$db;
} catch (PDOException $e) {
    echo $e->getMessage();
}

header('Content-Type: application/json');

$markersList = $db->query("SELECT * FROM MARKERS");
$mapList = $db->query("SELECT * FROM MAPS");
$objectsList = $db->query("SELECT * FROM OBJECTS");
$floorsList = $db->query("SELECT * FROM FLOORS");
$yearsList = $db->query("SELECT * FROM YEARS");

$data = array();

$i = 0;
foreach ($mapList as $map) {
    $i += 1;
    $data["Maps"][] = array();
    $data["Maps"][$i]["id"] = $map["id_map"];
    $data["Maps"][$i]["hauteur"] = $map["hauteur"];
    $data["Maps"][$i]["largeur"] = $map["largeur"];
    $data["Maps"][$i]["lien"] = $map["lien"];
    $data["Maps"][$i]["libelle"] = $map["libelle"];
    $data["Maps"][$i]["zoom"] = $map["zoom"];
    $data["Maps"][$i]["etage"] = $map["id_floor"];
    $data["Maps"][$i]["annee"] = $map["id_year"];
    $data["Maps"][$i]["source"] = $map["src"];
}

$i = 0;
foreach ($floorsList as $floor) {
    $i += 1;
    $data["Floors"][] = array();
    $data["Floors"][$i]["id"] = $floor["id_floor"];
    $data["Floors"][$i]["label"] = $floor["label"];
    $data["Floors"][$i]["identifier"] = $floor["identifier"];
}


$i = 0;
foreach ($markersList as $marker) {
    $i += 1;
    $data["Markers"][] = array();
    $data["Markers"][$i]["id"] = $marker["id_marker"];
    $data["Markers"][$i]["latitude"] = $marker["latitude"];
    $data["Markers"][$i]["longitude"] = $marker["longitude"];
    $data["Markers"][$i]["map"] = $marker["id_map"];
    $data["Markers"][$i]["object"] = $marker["id_object"];
}

$i = 0;
foreach ($objectsList as $object) {
    $i += 1;
    $data["Objects"][] = array();
    $data["Objects"][$i]["id"] = $object["id_object"];
    $data["Objects"][$i]["wikidata"] = $object["id_wiki"];
    $data["Objects"][$i]["type"] = $object["type"];
    $data["Objects"][$i]["verticalAlign"] = $object["verticalAlign"];
    $data["Objects"][$i]["zoomScale"] = $object["zoomScale"];
}

$i = 0;
foreach ($yearsList as $year) {
    $i += 1;
    $data["Years"][] = array();
    $data["Years"][$i]["id"] = $year["id_year"];
    $data["Years"][$i]["year"] = $year["year"];
    $data["Years"][$i]["label"] = $year["label"];
}


echo json_encode($data, JSON_PRETTY_PRINT);
