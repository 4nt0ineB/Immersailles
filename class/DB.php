<?php

class DB
{
    private static $instance; // l'instance se détient elle-même pour pouvoir se comparer
    public static $db;

    /* Données de connexion */
    private $host = '51.210.15.73';
    private $db_name = 'immersailles';
    private $user = 'immersailles';
    private $psswd = 'root';

    public static function getInstance()
    {
        /* Seul moyen d'obtenir l'instance unique (singleton)  */
        if (self::$instance === null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    /**
     * Constructeur privé empêche autres instanciation.
     */
    private function __construct()
    {
        try {
            DB::$db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user, $this->psswd);
            DB::$db->exec("set names utf8");
            DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Impossible de se connecter à la base."; //$e;
        }
    }

    /**
     * Méthode __clone en privé pour éviter tout clonage.
     *
     * @return void
     */
    private function __clone()
    {
    }
}
