<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Création d'une nouvelle année</title>
    <?php require_once("includes/head.html") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="../scripts/js/inactivity.js"></script>
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
                    <h3>Création d'une nouvelle année</h3>
                    <br>
                    <?php
                    $modifyYear = (isset($_GET["mod"]) ? true : false); // booleen pour condition si modification de la map


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

                    if (isset($_POST["createYear"])) {
                        $success = 0;

                        if (isset($_POST["createYear"]) && !$modifyYear) {
                            if (MAP::createMap($_POST['statut'], $_POST['imgName'], $_POST['libelle'], 1, $_POST['etage'], $_POST['annee'])) {
                                $success = 1;
                            }
                        } else if ($modifyYear) {
                            if (MAP::modifyYear($_POST['idYear'], $_POST['statut'], $_POST['imgName'], $_POST['libelle'], 1,  $_POST['etage'], $_POST['annee'])) {
                                $success = 1;
                            }
                        }

                        if ($success) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo 'L\'année a été' . (($modifyYear) ? ' modifié' : ' créé') . '. Redirection...';
                                ?>
                            </div>
                        <?php
                            header("refresh:2, manage_maps.php"); // redirection
                        } else {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                <?php echo 'L\'année n\'a pas été' . (($modifyYear) ? ' modifiée' : ' créée');
                                ?>
                            </div>
                    <?php
                            //header("refresh:5, login.php"); // refresh
                        }
                    }



                    ?>


                    <form method="POST" style=" text-align: left;">
                        <?php
                        if ($modifyYear) {

                            $yearId = $_GET['mod'];
                            echo '<input type="hidden" name="idYear" value="' . $yearId . '">';

                            $yearData = DB::$db->query("SELECT * FROM YEARS WHERE id_year = $yearId")->fetch();
                        }

                        ?>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="annee">Année à insérer <b style="color:red;">*</b></label>
                                <input type="number" class="form-control" name="annee" id="annee" placeholder="Année" required <?php if ($modifyYear) echo 'value="' . $yearData['year'] . '"'; ?>>
                            </div>
                        </div>



                        <button type="submit" name="createMap" class="btn btn-dark"><?php echo ($modifyYear) ? "Modifier l'année" : "Créer l'année"; ?> </button>
                    </form>
                    <br>
                    <hr><br>
                    <a href="manage_years.php" class="btn btn-dark">Retour</a>
                </div>
                <br>
            </div>

        </div>

    </div>


    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>

</html>