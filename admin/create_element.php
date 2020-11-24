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
                    if (empty($_GET["mod"])) {
                        echo "Merci de saisir un numéro d'objet";
                        die;
                    }
                    if (!is_numeric($_GET["mod"])) {
                        echo "Merci de saisir un numéro d'objet correct";
                        die;
                    }
                    /*$infos = User::getUserInfo($_GET["mod"]);
                    if ($infos == 0){
                        echo "L'objet n'a pas été trouvé"; die;
                    }*/
                }

                if (isset($_REQUEST['createObject'])) // si le btn submitCourse est cliqué
                {
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
                                <input type="url" pattern="https://www.wikidata.org/wiki/*" class="form-control" name="urlwikidata" id="urlwikidata" placeholder="https://www.wikidata.org/wiki/XXXX" required value="<?php if ($isModify) echo $infos["name"] ?>">
                                <center>
                                    <button type="button" name="loadUrl" class="btn btn-dark mt-2" onclick="loadPreview(document.getElementById('urlwikidata').value)"><?php if ($isModify) echo "Modifier ";
                                                                                                                                                                        else echo "Charger " ?>l'URL WikiDATA</button>
                                </center>

                                <br>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="verticalAlign">Alignement vertical de la photo <b style="color:red;">*</b></label>
                                        <input id="verticalAlign" class="form-control w-100" name="verticalAlign" type="range" min="-150" max="150" value="0" class="slider" id="myRange" oninput="updateSlider(this.value)">
                                    </div>

                                    <div class="form-group col-md-6">
                                        cc
                                    </div>
                                </div>

                            </div>


                            <div class="form-group col-md-4">
                                <label for="previ">Prévisualisation du pop-up sur la carte</label>
                                <div class="float-right info-bubble" id="overlay" style="opacity:1;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="container container-img" id="imagePreview">
                                                <!--div class="top-left">[Ici, la photo de l'objet]</!-->
                                                <div class="top-right"> <a href="#" onclick="hideOverlay()">X</a> </div>

                                                <div class="bottom-right" id="nom_objet">Libellé</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="container">
                                                <p><span class="label-info">Type :</span> <span id="type_objet"></span></p>
                                                <p> <span class="label-info" id="label_dates">Date d'arrivée et de départ :</span> <span id="date_a_objet"></span><span id="date_d_objet"></span></p>
                                                <p> <span class="label-info">Description :</span><br><span id="desc_objet"></span>
                                                </p>
                                                <p><span class="label-info">Liens utiles :</span><br> <span id="liens_objet"></span></p>
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
        function updateSlider(value) {
            document.getElementById("imagePreview").style.backgroundPosition = "50% calc(50% + " + value + "px)";
        }

        function loadPreview(urlWikidata) {

            if (urlWikidata.includes("https://www.wikidata.org/wiki/")) {

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
                    var url = "https://www.wikidata.org/wiki/Special:EntityData/" + identifier + ".json";
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


                        /* REMISE A ZERO DE TOUS LES CHAMPS SI JAMAIS ON CHANGE DE LIEN */
                        $("#date_a_objet").html("");
                        $("#date_d_objet").html(""); // remise à zéro si il y avait une personne décédée avant
                        $("#type_objet").html("");
                        $("#desc_objet").html("");
                        $("#liens_objet").html("");

                        // partie image
                        var img = json1.entities[identifier].claims.P18[0].mainsnak.datavalue.value;
                        img = img.split(' ').join('_');
                        var hash = md5(img).substring(0, 2);

                        //background: url(https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Louis_XIV_of_France.jpg/800px-Louis_XIV_of_France.jpg);

                        document.getElementById("imagePreview").style.background = "url(https://upload.wikimedia.org/wikipedia/commons/" + hash[0] + "/" + hash[0] + hash[1] + "/" + img + ")";
                        document.getElementById("imagePreview").style.backgroundSize = "cover";
                        document.getElementById("imagePreview").style.backgroundPosition = "50% calc(50% + 50px)";
                        document.getElementById("imagePreview").style.backgroundRepeat = "no-repeat";

                        // fin partie image

                        // Partie TYPE
                        if (infos.claims.P31[0].mainsnak.datavalue.value["numeric-id"] == 5){ // s'il s'agit d'un humain
                            if (infos.claims.P21[0].mainsnak.datavalue.value["numeric-id"] == 6581097){ // s'il s'agit d'un male
                                $("#type_objet").html("Humain (Homme)");
                            } else if(infos.claims.P21[0].mainsnak.datavalue.value["numeric-id"] == 6581072){ // s'il s'agit d'une femme
                                $("#type_objet").html("Humain (Femme)");
                            } else {
                                $("#type_objet").html("Humain");
                            }
                        } else {
                            $("#type_objet").html("Objet");
                        }

                        // Partie date arrivée date départ
                        if (infos.claims.P31[0].mainsnak.datavalue.value["numeric-id"] == 5){ // s'il s'agit d'un humain
                            $("#label_dates").html("Année de naissance :");
                            var date_naissance = infos.claims.P569[0].mainsnak.datavalue.value.time;
                            date_naissance = date_naissance.split("-");
                            date_naissance = String(date_naissance).substring(1, 5);
                            $("#date_a_objet").html(date_naissance);

                            if (typeof infos.claims.P570 !== 'undefined') {
                                $("#label_dates").html("Année de naissance et de mort :");
                                var date_deces = infos.claims.P570[0].mainsnak.datavalue.value.time;
                                date_deces = date_deces.split("-");
                                date_deces = String(date_deces).substring(1, 5);
                                $("#date_d_objet").html(" - "+date_deces);
                            }
                        } else {
                            $("#label_dates").html("Date d'arrivée et de départ :");
                            // TODO: faire dates des objets mtn
                        }

                        // Partie description 
                        if (infos.claims.P31[0].mainsnak.datavalue.value["numeric-id"] == 5){ // s'il s'agit d'un humain
                            $("#desc_objet").html(infos.descriptions.fr.value.charAt(0).toUpperCase() + infos.descriptions.fr.value.slice(1)); // On met avec une majuscule la String retournée
                        }

                        // Partie liens utiles
                        if (typeof infos.claims.P6058 !== 'undefined'){ // Si page Larousse
                            $("#liens_objet").append("<a href='https://www.larousse.fr/encyclopedie/"+infos.claims.P6058[0].mainsnak.datavalue.value+"' target='_blank'>Encyclopédie Larousse</a><br>");
                        }

                        if (typeof infos.claims.P268 !== 'undefined'){ // Si page BNF
                            $("#liens_objet").append("<a href='https://catalogue.bnf.fr/ark:/12148/cb"+infos.claims.P268[0].mainsnak.datavalue.value+"' target='_blank'>Bibliothèque Nationale de France</a><br>");
                        }

                        if (typeof infos.claims.P214 !== 'undefined'){ // Si page BNF
                            $("#liens_objet").append("<a href='https://viaf.org/viaf/"+infos.claims.P214[0].mainsnak.datavalue.value+"/' target='_blank'>Fichier d'autorité international virtuel</a><br>");
                        }

                        if (typeof infos.sitelinks !== 'undefined'){ // Si page wikipedia
                            $("#liens_objet").append("<a href='"+infos.sitelinks.frwiki.url+"' target='_blank'>Wikipédia</a><br>");
                        }


                    }
                }

            } else {
                document.getElementById("urlError").style.display = "block";
            }



        }
    </script>
</body>

</html>