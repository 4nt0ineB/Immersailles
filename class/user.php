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
        $sessionId = $id;
    }



    public function connect()
    {
        if (empty($this->idUser) || empty($this->session_id)) {
            return 0;
        }
        $r = User::$db->query("UPDATE USERS SET session_id = $this->sessionId; WHERE id_user = $this->idUser;");
        return 1;
    }

    public function refreshSession()
    { // si l'id de la session dans la db est différent du session_id de l'user on détruit la session.
        $result = User::$db->query("SELECT session_id FROM USERS WHERE id_user = $this->idUser");
        if ($result != $this->sessionId) {
            session_destroy();
            header("refresh:0; index.php");
        }
    }
}
