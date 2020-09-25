<?php include("../includes/mysql.php"); ?>
<?php include("includes/checkperms.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Se connecter</title>
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
    <link rel="stylesheet" href="../style/style.css" />

</head>

<body class="d-flex flex-column min-vh-100">
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href=""><img src="../img/logo_mini.png" /> <i>IMMERSAILLES</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link scroll" href="">A PROPOS <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a href=""><span class="dot"></span> </a>
                    </li>
                    <li class="nav-item">
                        <a href=""><span class="dot"></span></a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!--Fin navbar -->
    <!--Div before Map container-->
    <div class="container change-section">
        
        <div class="row h-100 align-self-center">
    
            <div class="col-lg text-center">

                <h2 id="title-current-place" style="padding: 10px;">Panel de gestion</h2>


                <div id="box">
                    Bienvenue <?php echo $row["name"]; ?>
                    <br>
                    <a href="logout.php">Se déconnecter</a>
                </div>
            
            </div>

            </div>
            
        </div>


    </div>



    

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
</body>

</html>