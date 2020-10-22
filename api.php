<?php

   try{
        $db=new PDO(
            'mysql:host=51.210.15.73;dbname=immersailles','immersailles','root',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

header('Content-Type: application/json');

$markersList = $db->query("SELECT * FROM MARKERS");
$mapList = $db->query("SELECT * FROM MAPS");

$data = array();

    $i = 0;
    foreach ($mapList as $map) {
            $i+=1;
            $data["Maps"][] = array();
            $data["Maps"][$i]["id"] = $map["id_map"];
            $data["Maps"][$i]["hauteur"] = $map["hauteur"];
            $data["Maps"][$i]["largeur"] = $map["largeur"];
            $data["Maps"][$i]["lien"] = $map["lien"];
            $data["Maps"][$i]["libelle"] = $map["libelle"];
            $data["Maps"][$i]["zoom"] = $map["zoom"];
    }


    $i = 0;
    foreach ($markersList as $marker) {
            $i+=1;
            $data["Markers"][] = array();
            $data["Markers"][$i]["id"] = $marker["id_marker"];
            $data["Markers"][$i]["latitude"] = $marker["latitude"];
            $data["Markers"][$i]["longitude"] = $marker["longitude"];
            $data["Markers"][$i]["map"] = $marker["id_map"];
            $data["Markers"][$i]["level"] = $marker["level"];
    }


    echo json_encode($data, JSON_PRETTY_PRINT);

    

?>

