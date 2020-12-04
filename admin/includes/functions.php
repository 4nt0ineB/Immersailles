<?php
function getRole($number)
{
    if ($number == 1) {
        return "Administrateur";
    } else if ($number == 2) {
        return "Contributeur";
    } else if ($number == 3) {
        return "Bloqué";
    }
}

function getStatus($status)
{
    if ($status == 1) {
        return "<b><FONT color='green'>Actif</FONT></b>";
    } else {
        return "<b><FONT color='red'>Inactif</FONT></b>";
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getWikidataDetails($id)
{
    $wikiData = file_get_contents('https://www.wikidata.org/wiki/Special:EntityData/' . $id . '.json');
    return json_decode($wikiData);
}
