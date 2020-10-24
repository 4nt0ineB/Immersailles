<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Immersailles</title>

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
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/timeline.css" />
    <style>
        @media (min-width:992px) {
            .vertical-nav {
                position: fixed;
                top: 56px;
                left: 0;
                width: 200px;
                height: auto;
                background-color: #ffffff;
                float: right;
                padding-top: 30px
            }
        }

        .rightnav ul {
            background-color: #ffffff;
        }

        .rightnav li a {
            display: block;
            color: #000;
            padding: 12px 10px;
        }

        /* Change the link color on hover */
        .rightnav li a:hover {
            background-color: #555;
            color: white;
        }


.timelineleft {
    padding-left: 50px;
    overflow: visible;
    padding-bottom: 50px;
}

        .entry {
            margin-left: -10px;
            position: relative;
            border-radius: 5px;
            height: 100px;
            overflow: visible;

        }

        .core span {
    vertical-align: middle;
    display: table-cell;
    padding-top: 5px;
}

        .core {
            width: inherit;
            height: inherit;
            display: table;
            text-align: end;
        }

       .entry:before {
    content: "";
    position: absolute;
    width: 3px;
    height: 150%;
    display: block;
    border-radius: 0px;
    border: 1px solid #646464;
    background: #646464;
    left: -25.7%;
}
.core:before {
    content: '';
    display: block;
    position: absolute;
    border: 6px solid #C8AD7F;
    background: #C8AD7F;
    top: 45%;
    left: -31.9%;
    border-radius: 12px;
}
.box_timeline {
    position: relative;
    z-index: 888;
    padding-right: 5px;
    border-top-right-radius: 8px;
    top: 80px;
    background-color: rgb(255 255 255 / 64%);
    box-shadow: 1px 1px 5px rgb(0 0 0 / 68%);
    border-bottom-right-radius: 8px;
}

    </style>

</head>

<body class="d-flex flex-column min-vh-100">
    <!--Navbar-->
    <?php include("includes/navbar.php"); ?>
    <!--Fin navbar -->

    <!--Div before Map container-->
    <div class="container change-section">
        <div class="row">
            <div class="col-lg">
                <div class="row">
                    <h5 id="title-nav2">Trier par <span style="color: #aabbd4">Objets (330)</span></h5>
                </div>
                <ul class="nav2">
                    <li><a href="">Tout(330)</a></li>
                    <li><a href="">Oeuvres d'art (120)</a></li>
                    <li><a href=""> Mobilier (100)</a></li>
                    <li><a href="">Décoration (110)</a></li>
                </ul>
            </div>
            <div class="col-lg text-center my-auto">

                <h2 id="title-current-place">Aile Ouest du château - RDC</h2>
            </div>
            <div class="col-lg">

            </div>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-md-12">
            <!--MAP-->
            <div id="mapid" style="width: 100%; height: 575px;">

                <div id="noscroll">
                    <div class="float-right info-bubble" id="overlay">
                        <div class="container">
                            <div class="row">
                                <div class="container container-img">
                                    <img src="img/fauteuil.jpg">
                                    <!--div class="top-left">[Ici, la photo de l'objet]</!-->
                                    <div class="top-right"> <a href="#" onclick="hideOverlay()">X</a> </div>

                                    <div class="bottom-right" id="nom_objet">NOM DE L'OBJET</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="container">
                                    <p><span class="label-info">Type d'objet :</span> Oeuvre d'art - Fauteuil</p>
                                    <p> <span class="label-info">Date d'arrivée et de départ :</span> 1682</p>
                                    <p> <span class="label-info">Localisation :</span> appartement de Louis XIV</p>
                                    <p> <span class="label-info">Description :</span><br>Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                        ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur.
                                    </p>
                                    <p><span class="label-info">Liens utiles :</span><br> Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>

                    </div>

   
                    <div class="float-left box_timeline timelineleft">
                <div class="entry">
                    <div class="core">
                        <span>Information 3</span>
                    </div>
                </div>
                <br /><br />
                <div class="entry">
                    <div class="core">
                        <span><a href="#" id="rdc">RDC</a></span>
                    </div>
                </div>
                <br /><br />
                <div class="entry">
                    <div class="core">
                       <span><a href="#" id="etage1">Étage 1</a></span>
                    </div>
                </div>

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
                            <li><a href="#0" data-date="00/00/2001" class="selected">2001</a></li>
                            <li><a href="#0" data-date="01/01/2002">2002</a></li>

                            <li><a href="#0" data-date="23/00/2020">2020</a></li>
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