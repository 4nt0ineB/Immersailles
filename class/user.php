<?php
class User
{
    public static $db;
    private $idUser;
    private $name;
    private $sessionId;
    private $psswd_hash;
    public function __construct($idUser, $psswd)
    {
        $this->sessionId = "";
        $this->idUser = $idUser;
        $this->psswd_hash = $psswd;
    }
    public function getId()
    {
        return $this->idUser;
    }

    /**
     *  Définit après l'instanciation de l'utilisateur avant la connexion. 
     */
    public function setSession($id)
    {
        $this->sessionId = $id;
    }

    /** 
     * Associe le session_id de l'instance user, à son user correspondant dans la bdd 
     */
    public function connect()
    {
        DB::$db->query("UPDATE USERS SET session_id = '$this->sessionId' WHERE id_user = '$this->idUser'");
        return 1;
    }

    /** 
     * remet à NULL session_id de l'utilisateur 
     */
    public function disconnect()
    {

        DB::$db->query("UPDATE USERS SET session_id = default WHERE id_user = '$this->idUser'");
    }

    /** 
     * Si l'id de la session dans la db est différent du session_id de l'user (bdd) on détruit la session. 
     * retourne 0 si déconnecté, 1 si non 
     */
    public function refreshSession()
    {

        $result = DB::$db->query("SELECT session_id, pwd_hash FROM USERS WHERE id_user = $this->idUser")->fetch();
        if ($result["pwd_hash"] != $this->psswd_hash) {
            header("refresh:0; logout.php");
            return 0;
        }
        if ($result["session_id"] != $this->sessionId) {
            header("refresh:0; logout.php");
            return 0;
        }
        return 1;
    }

    /** 
     * Renvoie true si l'id de l'utilisateur existe 
     */
    public static function userExist($id)
    {
        return DB::$db->query("SELECT id_user FROM USERS WHERE id_user = $id")->rowCount();
    }

    /** 
     * renvoie true si l'utilisateur a eté créé 
     */
    public static function createUser($nom, $prenom, $email, $role)
    {
        $insert_user = DB::$db->prepare("INSERT INTO USERS VALUES (NULL, :mdp, :nom, :prenom, :email, :roleU, NULL);");   // on insert le parcours
        $mdp = password_hash(generateRandomString(), PASSWORD_DEFAULT);
        $success = $insert_user->execute(array(':mdp' => $mdp, ':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':roleU' => $role));
        if ($success) {
            User::sendAccountCreation($email); // envoie du mail pour définir son mot de passe
        }
        return $success;
    }

    public static function deleteUser($id)
    {
        if (User::userExist($id)) {
            try {
                DB::$db->beginTransaction();
                DB::$db->query("DELETE FROM PSSWD_RECOVER WHERE id_user = $id");
                DB::$db->query("DELETE FROM USERS WHERE id_user = $id");
                DB::$db->commit();
                return 1;
            } catch (Exception $e) {
                DB::$db->rollBack();
                echo "Failed deleteUser:"; //. $e->getMessage();
                return 0;
            }
        }
        return 0;
    }

    /** 
     * Requete la bdd pour modifier l'utilisateur
     */
    public static function modifyUser($datas, $id)
    {
        try {
            DB::$db->beginTransaction();
            $result = DB::$db->prepare("UPDATE USERS SET name= :name, surname=:surname, email=:email, role=:role WHERE id_user=$id");
            $result = $result->execute($datas);
            $result = DB::$db->commit();
            return $result;
        } catch (Exception $e) {
            DB::$db->rollBack();
            echo "Failed modifyUser: "; //. $e->getMessage();
            return 0;
        }
    }

    /** 
     * Renvoie les données d'un utilisateur s'il existe 
     */
    public static function getUserInfo($id)
    {
        if (User::userExist($id)) {
            return DB::$db->query("SELECT * FROM USERS WHERE id_user = $id")->fetch();
        }
        return 0;
    }

    /** 
     * Renvoie true si l'email est attribué à un utilisateur 
     */
    public static function existEmail($email, $id = '')
    {
        $requete = "SELECT id_user FROM USERS WHERE email=\"$email\"";
        if (!empty($id)) {
            $requete .= " AND id_user != $id";
        }
        $x = DB::$db->query($requete)->rowCount();
        return $x;
    }

    /** 
     * Retourne le nombre d'utilisateurs ayant un session_id différent de NULL 
     */
    public static function numberConnectedUsers()
    {
        $r = DB::$db->query("SELECT count(*) AS nb FROM USERS WHERE session_id != ''")->fetch();
        return $r["nb"];
    }

    /** 
     * Retourne l'utilisateur associé  à un token valide (existe plus cooldown non dépassé) 
     */
    public static function isValidToken($token, $cooldown = "-1")
    {
        $nowNCooldown = date("Y-m-d H:i:s", strtotime($cooldown . " hour", strtotime(date("Y-m-d H:i:s")))); //heure actuelle - cooldown de 1h pour chaque nouveau token
        $existUser = DB::$db->query("SELECT id_user FROM PSSWD_RECOVER WHERE token=\"$token\" AND state = 0 AND date >= '$nowNCooldown'")->fetch();
        $existUser = $existUser["id_user"];
        return $existUser;
    }

    /** 
     * Envoie un mail de recup mdp avec un lien avec un token dans le GET 
     */
    public static function sendTokenRecovery($mail)
    {
        $r = DB::$db->query("SELECT id_user FROM USERS WHERE email = \"$mail\"")->fetch(); // id de l'user pour le mail donnée
        $id_user = $r["id_user"];
        if (!empty($id_user)) {
            $nowNCooldown = date("Y-m-d H:i:s", strtotime("-1 hour", strtotime(date("Y-m-d H:i:s")))); //heure actuelle - cooldown de 1h pour chaque nouveau token
            $actualToken = DB::$db->query("SELECT * FROM PSSWD_RECOVER WHERE date >= '$nowNCooldown' AND id_user = $id_user ")->rowCount(); //on cherche les token dont le cooldown de 2h n'est pas expiré
            if (($actualToken == 0)) {
                $token = generateRandomString(40);
                $to = $mail;
                $from = 'no-reply@immersailles.me';
                $fromName = 'no-reply';
                $subject = "Immersailles : Récupération du mot de passe";
                $htmlContent = ' <html>
                                    <head>
                                        <meta charset="utf8">
                                    </head>

                                    <body style="font-family: Tahoma;
                                        background-color: black;
                                        color: white;">
                                        <div id="box" style="width: 70%;
                                        margin: 0 auto;
                                        border-radius: 10px;
                                        padding: 5px;
                                        background-color: #353535;">
                                        <center>
                                        <img src="https://immersailles.me/img/logo_mini.png" style="width: 100px;">
                                        <p><h3>Réinitialisation de votre mot de passe</h3></p>
                                        <hr>
                                        <p>Vous avez perdu votre mot de passe ? Cela arrive même aux meilleurs !<br>
                                        <br>Cliquez sur le bouton pour le réinitialiser :</p>
                                        <br>
                                        <p><a href="https://immersailles.me/admin/recovery.php?re=' . $token . '" style="text-decoration: none;background-color: #C8AD7F;
                                        color: white;
                                        padding: 7px;
                                        border-radius: 5px;
                                        font-weight: bold;
                                        text-shadow: 1px 1px #6c5835;
                                        text-align: center;
                                        border: 2px solid #97815c;">Réinitialiser le mot de passe</a></p>
                                        <p><small>ATTENTION : Le lien de récupération ne sera valable que pendant une heure.</small></p>
                                        <p><small>Si vous n\'êtes pas à l\'origine de cette demande de réinitialisation, merci d\'ignorer cet e-mail.</small></p>
                                    </center>
                                    </div>
                                    </body>
                                    </html>';

                // Set content-type header for sending HTML email 
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // Additional headers 
                $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
                // Send email 
                $sendsuccess = mail($to, $subject, $htmlContent, $headers);
                if ($sendsuccess) {
                    $date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")));
                    DB::$db->query("INSERT INTO PSSWD_RECOVER VALUES(NULL, '$token', '$date', $id_user, 0)"); // envoie le token dans la bdd
                }
                return $sendsuccess;
            } else {
                return -1;
            }
        }
    }

    /** 
     * Envoie un mail de recup mdp avec un lien avec un token dans le GET 
     */
    public static function sendAccountCreation($mail)
    {
        $r = DB::$db->query("SELECT id_user FROM USERS WHERE email = \"$mail\"")->fetch(); // id de l'user pour le mail donnée
        $id_user = $r["id_user"];
        if (!empty($id_user)) {
            $token = generateRandomString(40);
            DB::$db->query("INSERT INTO PSSWD_RECOVER VALUES(NULL, '$token', NOW(), $id_user, 0)"); // def le token pour l'utilisateur
            $to = $mail;
            $from = 'no-reply@immersailles.me';
            $fromName = 'no-reply';
            $subject = "Immersailles : Création du compte";
            $htmlContent = ' <html>
                                <head>
                                    <meta charset="utf8">
                                </head>

                                <body style="font-family: Tahoma;
                                    background-color: black;
                                    color: white;">
                                    <div id="box" style="width: 70%;
                                    margin: 0 auto;
                                    border-radius: 10px;
                                    padding: 5px;
                                    background-color: #353535;">
                                    <center>
                                    <img src="https://immersailles.me/img/logo_mini.png" style="width: 100px;">
                                    <p><h3>Création du compte Immersailles</h3></p>
                                    <hr>
                                    <p>Bienvenue !<br>
                                    <br>Cliquez sur le bouton pour définir le mot de passe de votre compte :</p>
                                    <br>
                                    <p><a href="https://immersailles.me/admin/recovery.php?cr=' . $token . '" style="text-decoration: none;background-color: #C8AD7F;
                                    color: white;
                                    padding: 7px;
                                    border-radius: 5px;
                                    font-weight: bold;
                                    text-shadow: 1px 1px #6c5835;
                                    text-align: center;
                                    border: 2px solid #97815c;">Définir le mot de passe</a></p>
                                </center>
                                </div>
                                </body>
                                </html>';

            // Set content-type header for sending HTML email 
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // Additional headers 
            $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
            // Send email 
            return mail($to, $subject, $htmlContent, $headers);
        } else {
            return -1;
        }
    }
}
