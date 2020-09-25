<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style/style.css" />

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
            <div class="col-lg"></div>
        </div>
    </div>

    <!--MAP-->
    <div class="map" style="background-image: url('img/plan2.png');">


        <div class="float-right info-bubble">
            <div class="container">
                <div class="row">
                    <div class="container container-img">
                        <img src="img/fauteuil.jpg">
                        <!--div class="top-left">[Ici, la photo de l'objet]</!-->
                        <div class="top-right"> <a href="">X</a> </div>

                        <div class="bottom-right">NOM DE L'OBJET</div>
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


    </div><br>

    </div>
    <!--MAP-->

    <!--Timeline navigation-->
    <div class="container change-section timeline-nav">

        <div class="row">

            <div id="lineCont"> 
                <br>
                <div id="line"></div>
                <div id="span">Date Placeholder</div>
              </div>
              <br>
              <br>
              <br>
        </div>
    </div>
    <!--Timeline navigation-->

    <!-- Footer -->
    <footer class="page-footer mt-auto font-small white">
        <!-- Copyright -->
        <div class="row justify-content-center .links">
            <div class="col-1">
                <p></p>
            </div>
            <div class="col-1">
                <div class="row title-footer">
                    <p>Crédits</p>
                </div>
                <div class="row link-footer">
                    <a href="">Lorem</a>
                </div>
                <div class="row link-footer">
                    <a href="">Lorem</a>
                </div>
            </div>
            <div class="col-2 ">
                <div class="row title-footer">
                    <p>Mentions légales</p>
                </div>
                <div class="row link-footer">
                    <a href="">Lorem</a>
                </div>
            </div>
            <div class="col-1">
                <div class="row title-footer">
                    <p>Lorem</p>
                </div>
                <div class="row link-footer">
                    <a href="">Lorem</a>
                </div>
            </div>
            <div class="col-2">
                <div class="row title-footer">
                    <p>Lorem</p>
                </div>
                <div class="row link-footer">
                    <a href="">Lorem</a>
                </div>
            </div>
        </div>
        <div id="footp" class="footer-copyright text-center py-3">
            Copyright © 2020 x Inc. Tous droit réservés
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
    <script src="timeline.js"></script>
</body>

</html>