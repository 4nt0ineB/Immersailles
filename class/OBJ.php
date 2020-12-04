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
    public static function createObject($id_wiki, $verticalAlign = 0, $zoomScale = 0, $type)
    {
        if (DB::$db->query("SELECT id_object FROM OBJECTS WHERE id_wiki = \"$id_wiki\"")->rowCount() > 0) {
            return false;
        }
        return DB::$db->query("INSERT INTO OBJECTS VALUES(DEFAULT, \"$id_wiki\", $verticalAlign, $zoomScale, \"$type\")");
    }

    /**
     * Met à jour un objet
     */
    public static function updateObject($id_objet, $id_wiki, $verticalAlign = 0, $zoomScale = 0, $type)
    {
        return DB::$db->query("UPDATE OBJECTS SET id_wiki = \"$id_wiki\", verticalAlign = $verticalAlign, zoomScale= $zoomScale, type=\"$type\" WHERE id_object = $id_objet");
    }

    /**
     * Supprime l'objet avec l'id donné
     */
    public static function deleteObject($id_objet)
    {
        return DB::$db->query("DELETE FROM OBJECTS WHERE id_object = $id_objet");
    }
}
