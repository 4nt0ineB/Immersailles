<?php

require_once("../includes/mysql.php");

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
                    <form method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Adresse email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre email">
                        </div>
                        <button type="submit" name="send" class="btn btn-primary">Envoyer</button>
                    </form>
                    <br>
                    <?php

                    if (isset($_POST["send"])) {
                        $mail = $_POST["email"];
                        $exec = User::sendTokenRecovery($mail);
                        if ($exec == -1) {
                    ?>
                            <div class="alert alert-success" role="alert">
                                Un mail de récupération à déjà été envoyé à cette adresse.
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
                            <div class="alert alert-success" role="alert">
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