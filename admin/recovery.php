<?php

require_once("../includes/mysql.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de gestion</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/style.css" />

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

                        $token = generateRandomString(40);
                        $date = date('Y-m-d H:i:s');
                        $mail = $_POST["email"];
                        $id_user = $db->query("SELECT id_user FROM USERS WHERE email = '$mail'")->fetch();
                        $id_user = $id_user["id_user"];
                        if (!empty($id_user)) {
                            $db->query("INSERT INTO PSSWD_RECOVER VALUES(NULL, '$token', NOW(), $id_user)");
                            $message = $token;
                            mail($mail, 'Récupération de mot de passe', $message, 'From: no-reply@immersailles.me');
                        }
                    } else {
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