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

$data = array();

    for ($i=0; $i < $markersList->rowCount(); $i++) { 
        $marker = $db->query("SELECT * FROM MARKERS WHERE id_marker=$i")->fetch();

            $data["Markers"][] = array();
            $data["Markers"][$i]["id"] = $marker["id_marker"];
            $data["Markers"][$i]["latitude"] = $marker["latitude"];
            $data["Markers"][$i]["longitude"] = $marker["longitude"];
            $data["Markers"][$i]["level"] = $marker["level"];
    }


    echo json_encode($data, JSON_PRETTY_PRINT);

    

?>