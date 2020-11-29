<?php
class OBJ
{
    private $id_objet;
    private $id_wiki;
    private $verticalAlign;
    private $zoomScale;

    /**
     * Créer un nouvel objet dans la base de données s'il n'existe pas déjà
     */
    public static function createObject($id_wiki, $verticalAlign = 0, $zoomScale = 0)
    {
        if (DB::$db->query("SELECT id_object FROM OBJECTS WHERE id_wiki = $id_wiki")->rowCount() > 0) {
            return false;
        }
        return DB::$db->query("INSERT INTO OBJECT VALUES(DEFAULT, $id_wiki, $verticalAlign, $zoomScale");
    }

    /**
     * Met à jour un objet
     */
    public static function updateObject($id_objet, $id_wiki, $verticalAlign = 0, $zoomScale = 0)
    {
        return DB::$db->query("UPDATE OBJECT SET id_wiki = $id_wiki, verticalAlign = $verticalAlign, zoomScale= $zoomScale WHERE id_object = $id_objet");
    }
}
