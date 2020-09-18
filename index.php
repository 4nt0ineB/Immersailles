<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style/style.css" />

</head>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href=""><img src="img/logo_mini.png" /> <i>IMMERSAILLES</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link scroll" href="">A PROPOS <span class="sr-only">(current)</span></a>
                    </li>

                    <!--
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
            -->
                </ul>
            </div>
        </div>
    </nav>
    <!--Fin navbar -->

    <!--Div before Map container-->
    <div class="container change-section">
        <div class="row">
            <div class="col-lg">
                <div class="row">
                    <h5 id="title-nav2">Trier par <span style="color: #c4c9d1">Objets (330)</span></h5>
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
    <div class="map">

        <div class="float-right info-bubble">
            <div class="container">
                <div class="row">
                    <div class="container container-img">
                        <img src="img/fauteuil.jpg">
                        <div class="top-left">[Ici, la photo de l'objet]</div>
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

            <div class="col-lg my-auto">
                <div class="row justify-content-center">
                    <h2 id="title-current-place">Règne de Louis XIV</h2>
                </div>
                <div class="row timeline-div ">
                    <br>
                </div>

            </div>
            <div class="col-lg my-auto">
                <div class="row justify-content-center">
                    <h2 id="title-current-place">Règne de Louis XIV</h2>
                </div>
                <div class="row timeline-div ">
                    <br>
                </div>
            </div>
            <div class="col-lg text-center my-auto">
                <div class="row justify-content-center">
                    <h2 id="title-current-place">Règne de Louis XIV</h2>
                </div>
                <div class="row timeline-div ">
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!--Timeline navigation-->

    <!-- Footer -->
    <footer class="page-footer font-small white">
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
        <div id=" footp" class="footer-copyright text-center py-3">
            Copyright © 2020 x Inc. Tous droit réservés
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
</body>

</html>