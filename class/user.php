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
    {
        /* associe le session_id de l'instance user, à son user correspondant dans la bdd */
        User::$db->query("UPDATE USERS SET session_id = '$this->sessionId' WHERE id_user = '$this->idUser'");
        return 1;
    }
    public function disconnect()
    {
        /* remet à NULL session_id de l'utilisateur */
        User::$db->query("UPDATE USERS SET session_id = default WHERE id_user = '$this->idUser'");
    }
    public function refreshSession()
    {
        /* si l'id de la session dans la db est différent du session_id de l'user (bdd) on détruit la session. 
        retourne 0 si déconnecté, 1 si non */
        $result = User::$db->query("SELECT session_id FROM USERS WHERE id_user = $this->idUser")->fetch();
        if ($result["session_id"] != $this->sessionId) {
            header("refresh:0; logout.php");
            return 0;
        }
        return 1;
    }
    public static function numberConnectedUsers()
    {
        /* Retourne le nombre d'utilisateurs ayant un session_id différent de NULL */
        $r = User::$db->query("SELECT count(*) AS nb FROM USERS WHERE session_id != ''")->fetch();
        return $r["nb"];
    }
    public static function sendTokenRecovery($mail)
    {
        /* Envoie un mail de recup mdp avec un lien avec un token dans le GET */
        $r = User::$db->query("SELECT id_user FROM USERS WHERE email = \"$mail\"")->fetch(); // id de l'user pour le mail donnée
        $id_user = $r["id_user"];
        if (!empty($id_user)) {
            $nowNCooldown = date("Y-m-d H:i:s", strtotime("-2 hour", strtotime(date("Y-m-d H:i:s")))); //heure actuelle - cooldown de 2h pour chaque nouveau token
            $actualToken = User::$db->query("SELECT * FROM PSSWD_RECOVER WHERE date < '$nowNCooldown' AND id_user = $id_user ")->rowCount(); //on cherche les token dont le cooldown de 2h n'est pas expiré
            $rr "SELECT * FROM PSSWD_RECOVER WHERE date < '$nowNCooldown' AND id_user = $id_user";
            if (($actualToken == 0)) {
                $token = generateRandomString(40);
                User::$db->query("INSERT INTO PSSWD_RECOVER VALUES(NULL, '$token', NOW(), $id_user)"); // def le token pour l'utilisateur
                $to = $mail;
                $from = 'no-reply@immersailles.me';
                $fromName = 'no-reply';
                $subject = "Récupération de mot de passe";
                $htmlContent = ' 
                    <html> 
                    <head> 
                        <meta charset="UTF-8" />
                    </head>
                    <body> 
                        <h3 style="background-color: black; color: white;">Demande de récupération de mot de passe</h3> 
                        <p>Vous avez effectué une demande de récupération de mot de passe. 
                            <br>Si vous n\'êtes pas à l\'origine de cette demande ignorez ce mail .
                        </p>
                        <br>
                        <p> Le lien de récupération ne sera valable que pendant deux heures.</p>
                        <p>'.$rr.'</p>
                        <a href="https://immersailles.me/admin/recovery.php?re=' . $token . '">réinitialiser le mot de passe</a>
                    </body> 
                    </html>';

                // Set content-type header for sending HTML email 
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // Additional headers 
                $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
                // Send email 
                return mail($to, $subject, $htmlContent, $headers);
            }
        }
    }
}
