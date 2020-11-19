<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Création d'un nouvel objet</title>
    <?php require_once("includes/head.html") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../scripts/js/inactivity.js"></script>
    <script src="../scripts/js/md5.min.js"></script>
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

                $isModify = isset($_GET["mod"]);
                if ($isModify) {
                    if (empty($_GET["mod"])){
                        echo "Merci de saisir un numéro d'objet"; die;
                    }
                    if (!is_numeric($_GET["mod"])){
                        echo "Merci de saisir un numéro d'objet correct"; die;
                    }
                    /*$infos = User::getUserInfo($_GET["mod"]);
                    if ($infos == 0){
                        echo "L'objet n'a pas été trouvé"; die;
                    }*/
                }

                if (isset($_REQUEST['createObject'])) // si le btn submitCourse est cliqué
                {
                    $nom = strip_tags($_REQUEST["nom"]); // on stock toutes les valeurs
                    $prenom = strip_tags($_REQUEST["prenom"]);
                    $email = strip_tags($_REQUEST["email"]);
                    if (isset($_REQUEST["role"])) {
                        $role = strip_tags($_REQUEST["role"]);
                    }
                    try {

                        if (strlen($prenom) < 3) { // si le nom est vide ou inférieur a 3 caractères
                            $errorMsg[] = "Merci de saisir un prénom valide";
                        }

                        if (!isset($role)) {
                            $errorMsg[] = "Merci de saisir un rôle valide";
                        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si l'email n'est pas valide
                            $errorMsg[] = "Merci de saisir une adresse électronique valide"; // on inscrit un message d'erreur dans un tableau (si il y en a plusieurs)
                        }

                        $idUTestmail = '';
                        if ($isModify) {
                            $idUTestmail = $infos["id_user"];
                        }
                        if (User::existEmail($email, $idUTestmail) > '0') {
                            $errorMsg[] = "Cette adresse email est déjà utilisée";
                        } else if (!isset($errorMsg)) { // si aucun msg d'erreur

                            if (!$isModify) {
                                if (User::createUser($nom, $prenom, $email, $role)) {
                                    $successMsg = "L'utilisateur a été créé avec succès. Redirection..."; // msg de succès
                                    header("refresh:2; manage_users.php?id=$id");
                                }
                            } else if ($isModify) {
                                if ((User::modifyUser(array(':name' => $nom, ':surname' => $prenom, ':email' => $email, ':role' => $role), $infos["id_user"]))) {
                                    $successMsg = "L'utilisateur a été modifié avec succès. Redirection..."; // msg de succès
                                    header("refresh:2; manage_users.php?");
                                }
                            }
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
                ?>

                <div id="box">
                    <h3><?php if ($isModify) echo "Modifier l'objet";
                        else echo "Création d'un nouvel objet"; ?></h3>
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

                    <!-- Erreur de lien -->
                    <div class="alert alert-warning alert-dismissible fade show" id="urlError" role="alert" style="display:none;">
                                <strong>Oups !</strong> Le lien saisi n'est pas correct. Le lien doit être sous la forme <b>https://www.wikidata.org/wiki/XXXX</b>
                    </div>
                    <!-- Fin erreur -->



                    <form method="POST" action="<?php if ($isModify) echo '"create_object.php?=' . $infos["id_object"]; ?>" style=" text-align: left;">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="urlwikidata">URL Wikidata <b style="color:red;">*</b></label>
                                <input type="url" pattern="https://www.wikidata.org/wiki/Special:EntityData/*" class="form-control" name="urlwikidata" id="urlwikidata" placeholder="https://www.wikidata.org/wiki/XXXX" required value="<?php if ($isModify) echo $infos["name"] ?>">
                                <center>
                                <button type="button" name="loadUrl" class="btn btn-dark mt-2" onclick="loadPreview(document.getElementById('urlwikidata').value)"><?php if ($isModify) echo "Modifier ";
                                                                                        else echo "Charger " ?>l'URL WikiDATA</button>
                                </center>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="previ">Prévisualisation du pop-up sur la carte</label>
                            <div class="float-right info-bubble" id="overlay" style="opacity:1;">
                        <div class="container">
                            <div class="row">
                                <div class="container container-img">
                                    <img src="../img/fauteuil.jpg" id="image">
                                    <!--div class="top-left">[Ici, la photo de l'objet]</!-->
                                    <div class="top-right"> <a href="#" onclick="hideOverlay()">X</a> </div>

                                    <div class="bottom-right" id="nom_objet">Libellé</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="container">
                                    <p><span class="label-info">Type d'objet :</span> </p>
                                    <p> <span class="label-info">Date d'arrivée et de départ :</span> <span id="date_a_objet"></span><span id="date_d_objet"></span></p>
                                    <p> <span class="label-info">Description :</span><br><span id="desc_objet"></span>
                                    </p>
                                    <p><span class="label-info">Liens utiles :</span><br> <a href="#">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</a></p>
                                </div>
                            </div>
                        </div>

                    </div>
                            </div>
                        </div>
                    </form>
                    <hr><br>
                    <a href="manage_objects.php" class="btn btn-dark">Retour</a>
                </div>
                <br>
            </div>

        </div>
    <br>

    </div>

    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->

    <script>

   function loadPreview(urlWikidata){

        if (urlWikidata.includes("https://www.wikidata.org/wiki/")){

            document.getElementById("urlError").style.display = "none"; // On vire l'erreur si on l'a affichée précedemment
            var endOfUrl = urlWikidata.split("https://www.wikidata.org/wiki/");
            var identifier = endOfUrl[1];
           
            var xhr = null;

            getXmlHttpRequestObject = function() {
                if (!xhr) {
                    xhr = new XMLHttpRequest();
                }
                return xhr;
            };

            updateLiveData = function() {
                var url = "https://www.wikidata.org/wiki/Special:EntityData/"+identifier+".json"; 
                xhr = getXmlHttpRequestObject();
                xhr.onreadystatechange = evenHandler;
                xhr.open("GET", url, true);
                xhr.send(null);

            };

            updateLiveData();


            function evenHandler() {
                // Check response is ready or not
                if (xhr.readyState == 4 && xhr.status == 200) {

                    var json1 = JSON.parse(xhr.responseText);

                    var infos = json1.entities[identifier];
                    $("#nom_objet").html(infos.labels.fr.value);

                    // partie image
                    var img = json1.entities[identifier].claims.P18[0].mainsnak.datavalue.value;
                    img = img.split(' ').join('_');
                    var hash = md5(img).substring(0, 2);

                    document.getElementById("image").src="https://upload.wikimedia.org/wikipedia/commons/"+hash[0]+"/"+hash[0]+hash[1]+"/"+img+"";
                    // fin partie image


                    $('#description').on('input',function(e){
                    $("#desc_objet").html($(this).val());
                    });

                    $('#dateArrivee').on('input',function(e){
                    $("#date_a_objet").html($(this).val());
                    });

                    $('#dateDepart').on('input',function(e){
                    $("#date_d_objet").html(' - '+$(this).val());
                    });
                }
            }

        } else {
            document.getElementById("urlError").style.display = "block";
        }

           

   }
   
   
    
    </script>
</body>

</html>