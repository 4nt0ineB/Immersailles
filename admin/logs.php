<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de gestion</title>
    <?php require_once("includes/head.html") ?>
    <script src="../scripts/js/inactivity.js"></script>

    <style>
        .console {
            background-color: #474747;
            color: white;
            font-family: Consolas, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New;
            font-size: 12px;
            text-align: left;
            padding-left: 10px;
            border-radius: 5px;
            border: 1px solid black;
            max-height: 500px;
            overflow-y: scroll;

        }
    </style>

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
                    <h3>Historique des connexions</h3>
                    <div class="container">



                        <div class="row" style="margin-top: 10px;">
                            <div class="col-lg-2">

                            </div>
                            <div class="col">
                                <div class="console">
                                    <i>
                                        <?php
                                        $q = DB::$db->query("SELECT * FROM `SESSIONS` NATURAL JOIN (SELECT id_user, name, surname FROM USERS) USERS ORDER BY session_date");
                                        while ($s = $q->fetch()) {
                                            echo ' -> ' . $s['surname'] . ' ' . $s['name'] . ' pour session ' . $s['id_s'] . ': ' . $s['session_info'] . ' - last seen ' . $s['session_date'] . ' <br>';
                                        }
                                        ?>

                                    </i>
                                </div>
                            </div>
                            <div class="col-lg-2">

                            </div>
                        </div>

                        <br><br>
                        <a href="index.php" class="btn btn-dark">Retour à l'accueil</a>
                    </div>
                </div>

            </div>

        </div>

    </div>


    </div>

    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>