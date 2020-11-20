<?php
class MAP
{
    private $id_map;
    private $status;
    private $hauteur;
    private $largeur;
    private $lien;
    private $libelle;
    private $zoom;
    private static $pathToMapImg = "http://immersailles.me/admin/upload/";

    public function __construct($îd_map, $status, $hauteur, $largeur, $lien, $libelle, $zoom)
    {
        $this->id_map;
        $this->status;
        $this->hauteur;
        $this->largeur;
        $this->lien;
        $this->libelle;
        $this->zoom;
    }

    /** 
     * Créer un plan dans la base de données
     */
    public static function createMap($status, $nomImage, $libelle, $zoom)
    {
        $infos_image = @getImageSize('../admin/upload/' . $nomImage);
        $largeur = $infos_image[0]; // largeur de l'image
        $hauteur = $infos_image[1]; // hauteur de l'image
        $lien = MAP::$pathToMapImg . $nomImage;
        try {
            return DB::$db->query("INSERT INTO MAPS VALUES(DEFAULT, $status, $hauteur, $largeur, '$lien', \"$libelle\", $zoom)");
        } catch (Exception $e) {
            return false;
        }
    }

    /** 
     * Met à jour un les données d'un plan
     */
    public static function modifyMap($id, $status, $nomImage, $libelle, $zoom)
    {
        try {
            DB::$db->beginTransaction();
            $infos_image = @getImageSize('../admin/upload' . $nomImage);
            $largeur = $infos_image[0]; // largeur de l'image
            $hauteur = $infos_image[1]; // hauteur de l'image
            $lien = MAP::$pathToMapImg . $nomImage;
            $result = DB::$db->query("UPDATE MAPS SET status = $status, hauteur = $largeur, hauteur = $hauteur, lien = $lien, libelle = $libelle, zoom = $zoom WHERE id_map = $id");
            $result = DB::$db->commit();
            return $result;
        } catch (Exception $e) {
            DB::$db->rollBack();
            echo "Failed modify map: "; //. $e->getMessage();
            return 0;
        }
    }
}
