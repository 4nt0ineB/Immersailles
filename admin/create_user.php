<?php include("../includes/mysql.php"); ?>
<?php include("includes/checkperms.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Création d'un nouvel utilisateur</title>
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
    <link rel="stylesheet" href="../style/style.css" />
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
                    <h3>Création d'un nouvel utilisateur</h3>
                    <br>
                    <form style="text-align: left;"> 
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" placeholder="E-mail" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" placeholder="Nom" required>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle de l'utilisateur</label>
                        <select id="role" class="form-control" required>
                            <option selected disabled>Rôle</option>
                            <option>...</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark">Ajouter l'utilisateur</button>
                    </form>
                    <br><hr><br>
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
</body>

</html>