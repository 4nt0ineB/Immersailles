<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des utilisateurs</title>
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
                    if (isset($_POST["createMarker"])){
                        $latitude = $_POST["latitude"];
                        $longitude = $_POST["longitude"];
                        $planID = $_POST["planid"]; 
                        $user_id = $row["id_user"];
                        if (strlen($latitude) == 0){
                            $errorMsg[] = "Vous devez placer le nouveau marqueur sur la carte sélectionnée.";
                        } else {
                            $db->query("INSERT INTO `MARKERS` (`id_marker`, `latitude`, `longitude`, `level`, `creator_date`, `id_object`, `id_map`, `id_user`, `id_year`) VALUES (NULL, \"$latitude\", \"$longitude\", 0, NOW(), NULL, $planID, $user_id, NULL)");
                            $successMsg = "Votre marqueur a été créé avec succès !";
                        }
                    }
                ?>

                <div id="box">
                    <h3>Création d'un nouveau marqueur</h3>
                    <br>
                    <p id="instructions">Cliquez quelque part sur la map pour placer votre marqueur</p>
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
                        <div class="col-md-3 mb-1">
                            <form method="post">
                            <select class="form-control select2" onchange="changeMap();" name="maplayer" id="maplayer">
                                <?php
                                $maps = $db->query("SELECT * FROM MAPS");
                                while ($map_item = $maps->fetch()) :  ?>
                                    <option value="<?php echo $map_item["id_map"]; ?>"><?php echo htmlspecialchars($map_item["libelle"]); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div id="mapid" style="width: 100%; height: 628px;"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude du marqueur" readonly required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude du marqueur" readonly required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="plan">Plan</label>
                                    <input type="hidden" class="form-control" name="planid" id="planid" readonly required>
                                    <input type="text" class="form-control" name="plan" id="plan" placeholder="Plan choisi" readonly required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="objet">Objet</label>
                                    <select class="form-control select2" name="objet" id="objet">
                                        <option value="AL">Alabama</option>
                                        <option value="WY">Wyoming</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="form-control btn-success mb-2" name="createMarker">Création du marqueur</button>
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
    <script src="../scripts/js/manage_map.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });

        document.getElementById("plan").value = document.getElementById("maplayer").options[document.getElementById("maplayer").selectedIndex].text; // pré remplissage de la case plan a droite

        document.getElementById("planid").value = document.getElementById("maplayer").options[document.getElementById("maplayer").selectedIndex].value; // pré remplissage de la case plan ID cachée a droite

        function changeMap() {
            var selectBox = document.getElementById("maplayer");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            changeMapLayer(selectedValue);
        }

        var LastMarkerPut = null;
        var MarkerToDelete;
        map.on('click', function(e) {

            var marker = new L.marker(e.latlng, {
                icon: immersaillesIcon
            }).addTo(map);
            document.getElementById("instructions").innerHTML = "Remplissez les champs sur la droite décrivant le marqueur";

            if (LastMarkerPut != null) {
                MarkerToDelete = LastMarkerPut;
            }
            LastMarkerPut = marker;
            var latitude = document.getElementById("latitude");
            var longitude = document.getElementById("longitude");
            latitude.value = e.latlng.lat;
            longitude.value = e.latlng.lng;

            if (MarkerToDelete != null) {
                map.removeLayer(MarkerToDelete);
            }

        });
    </script>
</body>

</html>