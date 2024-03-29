<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des marqueurs</title>
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
                            <select class="form-control select2" onchange="changeMap();" name="etage" id="etage">
                                <?php
                                $floors = $db->query("SELECT * FROM FLOORS");
                                while ($floor_item = $floors->fetch()) :  ?>
                                    <option value="<?php echo $floor_item["id_floor"]; ?>"><?php echo htmlspecialchars($floor_item["label"]); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-1">
                            <select class="form-control select2" onchange="changeMap();" name="date" id="date">
                                <?php
                                $years = $db->query("SELECT * FROM YEARS");
                                while ($year_item = $years->fetch()) :  ?>
                                    <option value="<?php echo $year_item["id_year"]; ?>"><?php echo htmlspecialchars($year_item["year"]); ?></option>
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
            var etage = document.getElementById("etage");
            var etageSelected = etage.options[etage.selectedIndex].value;

            var annee = document.getElementById("date");
            var anneeSelected = annee.options[annee.selectedIndex].value;

            changeMapLayer(etageSelected, anneeSelected);
        }
    </script>
</body>

</html>