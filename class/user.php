<?php


class User{

    private $idUser;
    private $name;
    private $sessionId;
    public static $db;

    
    public function getId(){
        return $this->idUser;
    }

    public function setSession($id){
        $sessionId = $id;
    }

    public function createUser($db, $idUser){
        $this.$sessionId = "no";
        $this.$idUser = $idUser;
        $this.$db = $db;
    }

    public function connect(){
        return (User::$db->query("UPDATE USERS SET session_id = $this->sessionId"));
    }

    public function refreshSession(){ // si l'id de la session dans la db est différent du session_id de l'user on détruit la session.
        $result = User::$db->query("SELECT session_id FROM USERS WHERE id_user = $this->idUser");
        if($result != $this->sessionId){
            session_destroy();
            header("refresh:0; index.php");
        }

    }

    
    







}
?>