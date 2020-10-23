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


                <div id="box">
                    <h3>Gestion des marqueurs</h3>
                    <br>
                    <div class="row float-right" style="margin: 10px auto;"><a href="create_marker.php" class="btn btn-dark">Créer un nouveau marqueur</a></div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <select class="form-control select2" onchange="changeMap();" name="maplayer" id="maplayer">
                                <?php
                                $maps = $db->query("SELECT * FROM MAPS");
                                while ($map_item = $maps->fetch()) :  ?>
                                    <option value="<?php echo $map_item["id_map"]; ?>"><?php echo htmlspecialchars($map_item["libelle"]); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div id="mapid" style="width: 100%; height: 628px;"></div>
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

        function changeMap() {
            var selectBox = document.getElementById("maplayer");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            changeMapLayer(selectedValue);
        }
    </script>
</body>

</html>