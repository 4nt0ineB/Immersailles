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

                <div id="box">
                    <h3>Création d'un nouveau plan</h3>
                    <br>
                    <?php
                    $modifyMap = (isset($_GET["mod"]) ? true : false); // booleen pour condition si modification de la map


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

                    if (isset($_POST["createMap"])) {
                        $success = 0;
                        if (isset($_POST["createMap"]) && !$modifyMap) {
                            if (MAP::createMap($_POST['statut'], $_POST['imgName'], $_POST['libelle'], 1)) {
                                $success = 1;
                            }
                        } else if ($modifyMap) {
                            if (MAP::modifyMap($_POST['idMap'], $_POST['statut'], $_POST['imgName'], $_POST['libelle'], 1)) {
                                $success = 1;
                            }
                        }

                        if ($success) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo 'Le plan a été' . (($modifyMap) ? 'modifié' : 'créé') . '. Redirection...';
                                ?>
                            </div>
                        <?php
                            header("refresh:2, login.php"); // redirection
                        } else {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo 'Le plan a été' . (($modifyMap) ? 'modifié' : 'créé');
                                ?>
                            </div>
                    <?php
                            header("refresh:2, login.php"); // refresh
                        }
                    }



                    ?>


                    <form method="POST" style=" text-align: left;">
                        <?php
                        if ($modifyMap) {

                            $mapId = $_GET['mod'];
                            echo '<input type="hidden" name="idMap" value="' . $mapId . '">';

                            $mapData = DB::$db->query("SELECT * FROM MAPS WHERE id_map = $mapId")->fetch();
                        }

                        ?>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="libelle">Libellé <b style="color:red;">*</b></label>
                                <input type="text" class="form-control" name="libelle" id="libelle" pattern="[a-zA-Z0-9]{4,}" placeholder="Libellé du plan" required title="Minimum 4 caractères de chiffres et de lettres" <?php if ($modifyMap) echo 'value="' . $mapData['libelle'] . '"'; ?>>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fichier">Fichier <b style="color:red;">*</b></label>
                                <select multiple class="form-control" id="exampleFormControlSelect2" name="imgName">
                                    <?php

                                    $path    = './upload';
                                    $files = scandir($path);
                                    $files = array_diff(scandir($path), array('.', '..'));
                                    foreach ($files as $map) {

                                        if ($modifyMap) {
                                            echo '<option ';
                                            echo (basename($mapData['lien']) == $map) ? "selected" : " ";
                                            echo  ' value="' . $map . '">' . $map . '</option>';
                                        } else {
                                            echo '<option value="' . $map . '">' . $map . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <small class="form-text text-muted">Si votre plan n'apparaît pas dans la liste, merci de le téléverser dans le dossier /upload depuis un client FTP.</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="statut">Statut <b style="color:red;">*</b></label><br>
                                <div class="form-row text-center">
                                    <div class="col-md-6">
                                        Actif<br>
                                        <input type="radio" name="statut" <?php
                                                                            if ($modifyMap) {
                                                                                if ($mapData['status']) {
                                                                                    echo 'checked';
                                                                                }
                                                                            }
                                                                            ?> id="statut" value="true">
                                    </div>
                                    <div class="col-md-6">
                                        Inactif<br>
                                        <input type="radio" name="statut" <?php
                                                                            if ($modifyMap) {
                                                                                if (!$mapData['status']) {
                                                                                    echo 'checked';
                                                                                }
                                                                            }
                                                                            ?> id="statut" value="false">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="createMap" class="btn btn-dark">Créer le plan</button>
                    </form>
                    <br>
                    <hr><br>
                    <a href="manage_maps.php" class="btn btn-dark">Retour</a>
                </div>
                <br>
            </div>

        </div>

    </div>


    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>