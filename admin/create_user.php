<?php include("../includes/mysql.php"); ?>
<?php include("includes/checkperms.php"); ?>
<?php include("includes/functions.php"); ?>
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
                
                <?php
  if(isset($_REQUEST['createUser'])) // si le btn submitCourse est cliqué
  {
    $nom = strip_tags($_REQUEST["nom"]); // on stock toutes les valeurs
    $prenom = strip_tags($_REQUEST["prenom"]);
    $email = strip_tags($_REQUEST["email"]);
    if  (isset($_REQUEST["role"])){
        $role = strip_tags($_REQUEST["role"]);
    }
     try
     {

      if (empty($nom) || strlen($nom) < 3){ // si le nom est vide ou inférieur a 3 caractères
        $errorMsg[]="Merci de saisir un nom valide";
      }

      if (empty($prenom) || strlen($prenom) < 3){ // si le nom est vide ou inférieur a 3 caractères
        $errorMsg[]="Merci de saisir un prénom valide";
      }

      if (!isset($role)){
        $errorMsg[]="Merci de saisir un rôle valide";
      }

      else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // si l'email n'est pas valide
        $errorMsg[]="Merci de saisir une adresse électronique valide"; // on inscrit un message d'erreur dans un tableau (si il y en a plusieurs)
      }

      $email_exist = $db->query("SELECT * FROM USERS WHERE email=\"$email\"");
      if ($email_exist->rowCount() > 0){
        $errorMsg[]="Cette adresse email est déjà utilisée";
      }

      else if(!isset($errorMsg)) // si aucun msg d'erreur
      {

       $insert_user=$db->prepare("INSERT INTO USERS VALUES (NULL, :mdp, :nom, :prenom, :email, :roleU, NULL);");   // on insert le parcours

       $mdp = password_hash(generateRandomString(), PASSWORD_DEFAULT);

       if($insert_user->execute(array(':mdp'=>$mdp, ':nom'=>$nom,':prenom'=>$prenom, ':email'=>$email, ':roleU'=>$role))){

        $successMsg="L'utilisateur a été créé avec succès. Redirection..."; // msg de succès
        header("refresh:3; manage_users.php?id=$id");
       }
      }
     }
     catch(PDOException $e)
     {
      echo $e->getMessage();
     }
    }
   ?>

                <div id="box">
                    <h3>Création d'un nouvel utilisateur</h3>
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
                    <form method="POST" style="text-align: left;"> 
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" required>
                        </div>
                        <div class="form-group col-md-6">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle de l'utilisateur</label>
                        <select id="role" name="role" class="form-control" required>
                            <option selected disabled>Rôle</option>
                            <option value="1">Administrateur</option>
                        </select>
                    </div>
                    <button type="submit" name="createUser" class="btn btn-dark">Ajouter l'utilisateur</button>
                    </form>
                    <br><hr><br>
                    <a href="manage_users.php" class="btn btn-dark">Retour à l'accueil</a>
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