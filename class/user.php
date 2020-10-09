<?php


class User
{
    public static $db;


    private $idUser;
    private $name;
    public $sessionId;

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

    //UPDATE USERS SET session_id = 16r9bhvvoqnlg90r34rdumpd6v; WHERE id_user = 1
    //UPDATE USERS SET session_id = 16r9bhvvoqnlg90r34rdumpd6v; WHERE id_user = 1


    public function connect()
    {
        User::$db->query("UPDATE USERS SET session_id = '$this->sessionId' WHERE id_user = '$this->idUser'");
        return 1;
    }

    public function refreshSession()
    { // si l'id de la session dans la db est différent du session_id de l'user on détruit la session.
        //retourn 0 si déconnecté 1 si non

        $result = User::$db->query("SELECT session_id FROM USERS WHERE id_user = $this->idUser")->fetch();
        if ($result["session_id"] != $this->sessionId) {
            header("refresh:0; logout.php");
            return 0;
        }
        return 1;
    }
}
