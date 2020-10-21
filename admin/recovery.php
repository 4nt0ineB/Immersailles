<?php


require_once("../includes/mysql.php");

if (isset($_SESSION["user"])) {
    if (!empty($_SESSION["user"])) { // l'utilisateur est déjà connecté
        header("location:index.php"); // redirection
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mot de passe perdu</title>
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

                <h2 id="title-current-place" style="padding: 10px;">Réinitialiser le mot de passe</h2>
                <div id="box">
                    <?php

                    if (isset($_POST["sendpass"])) {
                        $id_user = $_POST["id_user"];
                        $mdp = $_POST["pass1"];
                        if ($db->query("UPDATE USERS set mdp=\"$mdp\" WHERE id_user=$id_user")) {
                            $db->query("")
                    ?>
                            <div class="alert alert-success" role="alert">
                                Votre mot de passe à été changé avec succès.
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                Une erreur est survenue votre demande n'a pas pu être prise en compte.
                            </div>

                        <?php
                        }
                    }



                    if (isset($_GET["re"])) {
                        $existUser = "";
                        if ($_GET["re"]) {
                            $token = htmlspecialchars($_GET["re"]);
                            if (!empty("$token")) {
                                $existUser = $db->query("SELECT id_user FROM PSSWD_RECOVER WHERE token=\"$token\"");
                            }
                        }
                        if (!empty($existUser)) {
                        ?>
                            <form method="POST" action="recovery.php">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nouveau mot de passe</label>
                                    <input type="password" required name="pass1" class="form-control" id="password" placeholder="Mot de passe">
                                    <br>
                                    <input type="password" required name="pass2" class="form-control" id="confirm_password" placeholder="Confirmer le mot de passe">
                                    <input type="hidden" name="id_user" value="<?php echo $existUser; ?>" </div> <button type="submit" name="sendpass" class="btn btn-primary">Envoyer</button>
                            </form>
                            <br>
                            <script src="../scripts/js/confirmpsswd.js"></script> <!-- js correspondance mdp-->
                        <?php


                        }
                    } else {
                        ?>


                        <form method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Adresse email</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre email">
                            </div>
                            <button type="submit" name="send" class="btn btn-primary">Envoyer</button>
                        </form>
                        <br>
                        <?php
                    }

                    if (isset($_POST["send"])) {
                        $mail = $_POST["email"];
                        $exec = User::sendTokenRecovery($mail);
                        if ($exec == -1) {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                Un mail de récupération à déjà été envoyé à cette adresse. Patientez une heure entres deux demandes.
                            </div>

                        <?php

                        } elseif ($exec == 0) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                Si vous possedez un compte un mail de récupération vous sera envoyé.
                            </div>

                        <?php

                        } else {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                Une erreur est survenue votre demande n'a pas pu être prise en compte.
                            </div>

                    <?php
                        }
                    }




                    ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>