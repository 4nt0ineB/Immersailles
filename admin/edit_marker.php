<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (empty($id) || !is_numeric($id) || is_null($id)) {
        echo "Merci de saisir un ID de marqueur correct";
        die;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Édition d'un marqueur</title>
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
    <?php require_once("includes/head.html"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


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
                if (isset($_POST["editMarker"])){
                    if (substr($_POST["latitude"], 0, 2) === "En"){ // Le marqueur a été modifié mais pas re-placé sur la map
                        $errorMsg[] = "Le marqueur après avoir été enlevé de la carte, doit être placé à un autre endroit.";
                    }
                    if (!isset($errorMsg)){
                        $id = $_POST["id"];
                        $latitude = $_POST["latitude"];
                        $longitude = $_POST["longitude"];
                        $db->query("UPDATE MARKERS SET latitude=\"$latitude\", longitude=\"$longitude\" WHERE id_marker=$id;");
                        $successMsg = "Les modifications apportées ont bien été enregistrées.";
                    }
                }

                if (isset($_POST["deleteMarker"])){
                    $db->query("DELETE FROM MARKERS WHERE id_marker=$id;");
                    echo '<meta http-equiv="refresh" content="0;URL=manage_markers.php">';
                }

                ?>

                <div id="box">
                    <h3>Modification du marqueur n°<?php echo $id; ?></h3>
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
                    <div class="row">
                        <div class="col-md-9">
                            <div id="mapid" style="width: 100%; height: 628px;"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row">
                                <form method="post">
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                <div class="form-group col-md-12">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude du marqueur" readonly required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="latitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude du marqueur" readonly required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="objet">Objet</label>
                                    <select class="form-control select2" name="objet" id="objet">
                                        <option value="AL">Alabama</option>
                                        <option value="WY">Wyoming</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="form-control btn-success mb-2" name="editMarker">Enregistrer le marqueur</button>
                                    <button type="submit" class="form-control btn-danger" name="deleteMarker">Supprimer le marqueur</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    <br><br>
                    <a href="index.php" class="btn btn-dark">Retour à l'accueil</a>
                </div>
                <br>

            </div>

        </div>

    </div>


    </div>





    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
    <script src="../scripts/js/edit_marker.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>

</html>