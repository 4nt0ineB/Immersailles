<?php require_once("../includes/mysql.php");
?>

<?php session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION["user"]->refreshSession()) {
        header("location:index.php"); // redirection user déjà connecté
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de gestion</title>
    <?php require_once("includes/head.html") ?>


</head>

<body class="d-flex flex-column min-vh-100">
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../"><img src="../img/logo_mini.png" /> <i>IMMERSAILLES</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link scroll" href="">A PROPOS <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a href=""><span class="dot"></span> </a>
                    </li>
                    <li class="nav-item">
                        <a href=""><span class="dot"></span></a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!--Fin navbar -->
    <!--Connexion container-->
    <div class="container change-section">
        <div class="row"><br></div>
        <div class="row"><br></div>
        <div class="row"><br></div>
        <div class="row"><br></div>
        <div class="row"><br></div>

        <div class="row">

            <div class="col-lg text-center">

                <h2 id="title-current-place" style="padding: 10px;">Connexion</h2>


                <div id="box">
                    <?php
                    if (isset($_SESSION["logged"])) // si une session est déjà lancée
                    {
                        header("location: index.php"); // redirection vers l'index
                    }

                    if (isset($_REQUEST['send'])) //si le formulaire "send" reçu
                    {

                        $email = strip_tags($_REQUEST["email"]);
                        $password  = strip_tags($_REQUEST["pass"]);

                        if (empty($email)) {
                            $errorMsg[] = "Veuillez saisir le login administrateur"; // add msg d'erreu
                        } else if (empty($password)) {
                            $errorMsg[] = "Veuillez saisir le mot de passe administrateur"; // add msg d'erreu
                        } else {
                            try {
                                $select_registered_users = $db->prepare("SELECT * FROM USERS WHERE email=:email"); // on selectionne les utilisateurs avec ce pseudo ou cet email
                                $select_registered_users->execute(array(':email' => $email));
                                $row = $select_registered_users->fetch(); // avec la methode de recherche

                                if ($select_registered_users->rowCount() > 0) // si + de zéro lignes
                                {

                                    if ($email == $row["email"]) {
                                        if (password_verify($password, $row["pwd_hash"])) {
                                            $user = new User($row["id_user"], $row["pwd_hash"]); // nouvel user
                                            $user->setSession(session_id()); // definition user session_id
                                            $user->connect();
                                            $_SESSION["user"] = $user; // stock obj user dans la session
                                            $loginMsg = "Connecté avec succès ! Redirection...";
                                            header("refresh:2; index.php");   // redirection

                                        } else // vérif mdp échoue
                                        {
                                            $errorMsg[] = "Mauvais mot de passe";
                                        }
                                    } else { // données entrées et ddb != 
                                        $errorMsg[] = "Mauvais login";
                                    }
                                } else { // vérif mdp échoue
                                    $errorMsg[] = "Mauvais login";
                                }
                            } catch (PDOException $e) {
                                $e->getMessage();
                            }
                        }
                    }
                    ?>
                    <?php
                    if (isset($errorMsg)) // si tableau errorMsg initialisé
                    {
                        foreach ($errorMsg as $error) {
                    ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Oups !</strong> <?php echo $error // on affiche la variable ; 
                                                        ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                    }
                    if (isset($loginMsg)) // si un message de succès est initialisé
                    {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $loginMsg; // on affiche le msg 
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Adresse email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre email">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe</label>
                            <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Votre mot de passe">
                        </div>
                        <button type="submit" name="send" class="btn btn-primary">Se connecter</button><br>


                    </form>
                    <br>


                    <a href="recovery.php" style="font-size: 11px; float: right; top: 10px;color: black;">Mot de passe oublié</a>
                    <br>


                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>