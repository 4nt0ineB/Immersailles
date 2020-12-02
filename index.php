<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Carte interactive du Château de Versailles. Découvrez les personnages historiques et les trésors du château de Versailles en parcourant ses étages et le temps.">
    <title>Immersailles</title>
    <link rel="icon" href="../img/logo_mini.png">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./scripts/js/md5.min.js"></script>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/timeline.css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-F4VEN54R8E"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-F4VEN54R8E');
    </script>

</head>

<body class="d-flex flex-column min-vh-100">
    <!--Navbar-->
    <?php include("includes/navbar.php"); ?>
    <!--Fin navbar -->

    <!--Div before Map container-->

    <div class="row">
        <div class="col-lg">
            <div class="row">
                <!--<span style="color: #aabbd4">Objets (330)</span>-->
                <span style="font-size:20px;" class="pl-4">Trier par&nbsp;
                    <ul class="nav2">
                        <li><a href="">Tout(330)</a></li>
                        <li><a href="">Oeuvres d'art (120)</a></li>
                        <li><a href=""> Mobilier (100)</a></li>
                        <li><a href="">Décoration (110)</a></li>
                    </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!--MAP-->
            <div id="mapid" style="width: 100%; height: 575px;">

                <div id="noscroll" style="display:none;">
                    <div class="float-right info-bubble" id="overlay">
                        <div class="container">
                            <div class="row">
                                <div class="container container-img" id="imagePreview" style="background:url(./img/loader.gif)">
                                    <div class="top-right"> <a href="#" onclick="hideOverlay()">X</a> </div>

                                    <div class="bottom-right" id="nom_objet"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="container">
                                    <p><span class="label-info">Type :</span> <span id="type_objet"></span></p>
                                    <p> <span class="label-info" id="label_dates">Date d'arrivée et de départ :</span> <span id="date_a_objet"></span><span id="date_d_objet"></span></p>
                                    <p> <span class="label-info">Description :</span><br><span id="desc_objet"></span></p>
                                    <p><span class="label-info">Liens utiles :</span><br> <span id="liens_objet"></span></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="noscroll_left">
                    <div class="float-left box_timeline timelineleft" id="leftTimeline">

                        <?php
                        require_once('./class/DB.php');
                        try {
                            $DB = DB::getInstance();
                            $db = DB::$db;
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        $floors = DB::$db->query("SELECT * FROM FLOORS");
                        while ($f = $floors->fetch()) {
                        ?>

                            <div class="entry">
                                <a href="#" id="<?= htmlspecialchars($f["identifier"]) ?>" style="display: block;height: 100%;outline: none;color:#C8AD7F !important;" onclick="getYearsByFloor('<?= htmlspecialchars($f['identifier']) ?>');colorClickedLink('<?= htmlspecialchars($f['identifier']) ?>')">
                                    <div id="core_<?= htmlspecialchars($f["identifier"]) ?>" class="core">
                                        <span><?= htmlspecialchars($f["label"]) ?></span>
                                    </div>
                                </a>
                            </div>

                        <?php } ?>


                    </div>


                </div>

            </div>
        </div>




    </div><br>

    </div>

    <!--MAP-->

    <!--Timeline navigation-->
    <div class="container change-section timeline-nav" style="margin-top: -12px;">

        <div class="cd-horizontal-timeline" style="width: 100%;">
            <div class="timeline">
                <div class="events-wrapper">
                    <div class="events">
                        <ol style="list-style-type: none;">
                            <?php
                            $years = DB::$db->query("SELECT DISTINCT year,MAPS.id_map,YEARS.id_year FROM YEARS,MAPS WHERE YEARS.id_year = MAPS.id_year GROUP BY year ASC");
                            $first_row = true;
                            while ($y = $years->fetch()) {
                                if ($first_row) {
                                    echo '<li><a href="#0" onclick="changeMapLayer(' . $y["id_map"] . ');getFloorsByYear(' . $y["id_year"] . ')" data-date="00/00/' . $y["year"] . '" class="selected">' . $y["year"] . '</a></li>';
                                    $first_row = false;
                                } else {
                                    echo '<li><a href="#0" onclick="changeMapLayer(' . $y["id_map"] . ');getFloorsByYear(' . $y["id_year"] . ')" data-date="00/00/' . $y["year"] . '">' . $y["year"] . '</a></li>';
                                }
                            ?>
                            <?php }  ?>

                        </ol>
                        <span class="filling-line" aria-hidden="true"></span>
                    </div>
                    <!-- .events -->
                </div>
                <!-- .events-wrapper -->

                <ul class="cd-timeline-navigation" style="list-style-type: none;">
                    <li><a href="#0" class="prev inactive">Prev</a></li>
                    <li><a href="#0" class="next">Next</a></li>
                </ul>
                <!-- .cd-timeline-navigation -->
            </div>
            <!-- .timeline -->

        </div>
    </div>
    <!--Timeline navigation-->

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
    <!-- Footer -->
    <script src="scripts/js/map.js"></script>
    <script src="scripts/js/timeline.js"></script>
    <script src="scripts/js/timelineleft.js"></script>
</body>

</html>