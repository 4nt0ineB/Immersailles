<?php


class User
{
    public static $db;


    private $idUser;
    private $name;
    private $sessionId;

    public function __construct($idUser)
    {
        $this->sessionId = "";
        $this->idUser = $idUser;
    }

    public function getId()
    {
        return $this->idUser;
    }

    public function setSession($id)
    {
        $this->sessionId = $id;
    }

    public function connect()
    { /* associe le session_id de l'instance user, à son user correspondant dans la bdd */

        User::$db->query("UPDATE USERS SET session_id = '$this->sessionId' WHERE id_user = '$this->idUser'");
        return 1;
    }

    public function refreshSession()
    { /* si l'id de la session dans la db est différent du session_id de l'user (bdd) on détruit la session. 
        retourne 0 si déconnecté, 1 si non */

        $result = User::$db->query("SELECT session_id FROM USERS WHERE id_user = $this->idUser")->fetch();
        if ($result["session_id"] != $this->sessionId) {
            header("refresh:0; logout.php");
            return 0;
        }
        return 1;
    }
}
