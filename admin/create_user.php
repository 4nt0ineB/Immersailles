<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Création d'un nouvel utilisateur</title>
    <?php require_once("includes/head.html") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../scripts/js/inactivity.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!--Navbar-->
    <?php include("includes/navbar.php"); ?>
    <!--Fin navbar -->

    <div class="container change-section">

        <div class="row h-100 align-self-center">

            <div class="col-md-12 text-center">

                <h2 id="title-current-place" style="padding: 10px;">Panel de gestion</h2>

                <?php


                $isModify = isset($_GET["mod"]);
                if ($isModify) {
                    $infos = User::getUserInfo($_GET["mod"]);
                }

                if (isset($_REQUEST['createUser'])) // si le btn submitCourse est cliqué
                {
                    $nom = strip_tags($_REQUEST["nom"]); // on stock toutes les valeurs
                    $prenom = strip_tags($_REQUEST["prenom"]);
                    $email = strip_tags($_REQUEST["email"]);
                    if (isset($_REQUEST["role"])) {
                        $role = strip_tags($_REQUEST["role"]);
                    }
                    try {

                        if (strlen($prenom) < 3) { // si le nom est vide ou inférieur a 3 caractères
                            $errorMsg[] = "Merci de saisir un prénom valide";
                        }

                        if (!isset($role)) {
                            $errorMsg[] = "Merci de saisir un rôle valide";
                        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si l'email n'est pas valide
                            $errorMsg[] = "Merci de saisir une adresse électronique valide"; // on inscrit un message d'erreur dans un tableau (si il y en a plusieurs)
                        }

                        $idUTestmail = '';
                        if ($isModify) {
                            $idUTestmail = $infos["id_user"];
                        }
                        if (User::existEmail($email, $idUTestmail) > '0') {
                            $errorMsg[] = "Cette adresse email est déjà utilisée";
                        } else if (!isset($errorMsg)) { // si aucun msg d'erreur

                            if (!$isModify) {
                                if (User::createUser($nom, $prenom, $email, $role)) {
                                    $successMsg = "L'utilisateur a été créé avec succès. Redirection..."; // msg de succès
                                    header("refresh:2; manage_users.php?id=$id");
                                }
                            } else if ($isModify) {
                                if ((User::modifyUser(array(':name' => $nom, ':surname' => $prenom, ':email' => $email, ':role' => $role), $infos["id_user"]))) {
                                    $successMsg = "L'utilisateur a été modifié avec succès. Redirection..."; // msg de succès
                                    header("refresh:2; manage_users.php?");
                                }
                            }
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
                ?>

                <div id="box">
                    <h3><?php if ($isModify) echo "Modifier l'utilisateur";
                        else echo "Création d'un nouvel utilisateur"; ?></h3>
                    <br>
                    <?php
                    if (isset($errorMsg)) // si le tableau errorMsg est initialisé
                    {
                        foreach ($errorMsg as $error) // pour chaque ligne du tableau on initalise une variable
                        {
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
                    if (isset($successMsg)) // si un message de succès est initialisé
                    {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $successMsg; // on affiche ce message 
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <form method="POST" action="<?php if ($isModify) echo '"create_user.php?=' . $infos["id_user"]; ?>" style=" text-align: left;">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="email">Adresse e-mail</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required value="<?php if ($isModify) echo $infos["email"] ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required value="<?php if ($isModify) echo $infos["name"] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom" required value="<?php if ($isModify) echo $infos["surname"] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Rôle de l'utilisateur</label>
                            <select id="role" name="role" class="form-control" required>
                                <option <?php if (!$isModify) echo "selected"; ?> disabled>Rôle</option>
                                <option <?php if ($isModify && $infos["role"] == "1") echo "selected"; ?> value="1">Administrateur</option>
                                <option <?php if ($isModify && $infos["role"] == "2") echo "selected"; ?> value="2">Contributeur</option>
                                <option <?php if ($isModify && $infos["role"] == "3") echo "selected"; ?> value="3">Bloqué</option>
                            </select>
                        </div>
                        <button type="submit" name="createUser" class="btn btn-dark"><?php if ($isModify) echo "Modifier ";
                                                                                        else echo "Ajouter" ?>l'utilisateur</button>
                    </form>
                    <br>
                    <hr><br>
                    <a href="manage_users.php" class="btn btn-dark">Retour</a>
                </div>
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