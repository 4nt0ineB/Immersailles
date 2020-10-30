<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Création d'un nouvel utilisateur</title>
    <?php require_once("includes/head.html") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    <h3>Création d'un nouveau plan</h3>
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
                    <form method="POST" style=" text-align: left;">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="libelle">Libellé <b style="color:red;">*</b></label>
                                <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libellé du plan" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fichier">Fichier <b style="color:red;">*</b></label>
                                <input type="file" class="form-control-file" name="fichier" id="fichier" required>
                                <small id="fileHelp" class="form-text text-muted">Merci de joindre l'image de la carte en PNG (20Mo max.).</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="statut">Statut <b style="color:red;">*</b></label><br>
                                <div class="form-row text-center">
	                                <div class="col-md-6">
	                                	Actif<br>
	                                	<input type="radio" name="statut" id="statut" value="actif">
	                            	</div>
	                                <div class="col-md-6">
	                                	Inactif<br>
	                                	<input type="radio" name="statut" id="statut" value="inactif">
	                            	</div>
                            	</div>
                            </div>
                        </div>
                        <button type="submit" name="createMap" class="btn btn-dark">Créer la carte</button>
                    </form>
                    <br>
                    <hr><br>
                    <a href="manage_maps.php" class="btn btn-dark">Retour</a>
                </div>
                <br>
            </div>

        </div>

    </div>


    </div>





    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>