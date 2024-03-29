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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
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
                        echo "Identificateur d'objet inexistant";
                        die;
                    }
                    if (!is_numeric($_GET["mod"])) {
                        echo "Syntaxe de l'identificateur d'objet erronée";
                        die;
                    }
                    $id_o = $_GET["mod"];
                    $data_o = DB::$db->query("SELECT * FROM OBJECTS WHERE id_object = $id_o");
                    if (!($data_o->rowCount() > 0)) {
                        echo "L'identificateur ne se rapporte à aucun objet répertorié";
                        die;
                    }
                    $data_o = $data_o->fetch();
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



                    <form method="POST" action="" style=" text-align: left;">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="urlwikidata">Importer les informations (URL Wikidata)</label>
                                <input type="url" pattern="http(s?)://www.wikidata.org/wiki/([a-zA-z0-9\-_]+){1,}" class="form-control" name="urlwikidata" id="urlwikidata" placeholder="https://www.wikidata.org/wiki/XXXX" required value="<?php if ($isModify) echo "https://www.wikidata.org/wiki/" . $data_o['id_wiki']; ?>">
                                <center>
                                    <button type="button" name="loadUrl" class="btn btn-dark mt-2" onclick="loadPreview(document.getElementById('urlwikidata').value)"><i class="fas fa-file-download"></i>&nbsp;<?php if ($isModify) echo "Modifier ";
                                                                                                                                                                                                                    else echo "Charger " ?>l'URL WikiDATA</button>
                                </center>
                                <?php if ($isModify) {
                                    echo '<script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        
                                        loadPreview(document.getElementById("urlwikidata").value, ' . $data_o['verticalAlign'] . ', ' . $data_o['zoomScale'] . ');
                                    }, false);
                                    </script>';
                                } ?>

                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="type">Type <b style="color:red;">*</b></label>
                                        <select class="form-control select2" name="type" id="type">
                                            <option <?php if ($isModify) {
                                                        if ($data_o['type'] == "person") {
                                                            echo " selected ";
                                                        }
                                                    }
                                                    ?>value="person">Personne</option>
                                            <option <?php if ($isModify) {
                                                        if ($data_o['type'] == "item") {
                                                            echo " selected ";
                                                        }
                                                    }
                                                    ?>value="item">Objet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="verticalAlign">Alignement vertical de la photo <b style="color:red;">*</b></label>
                                        <input id="verticalAlign" class="form-control w-100" name="verticalAlign" type="range" min="-150" max="150" value="<?php if ($isModify) {
                                                                                                                                                                echo $data_o['verticalAlign'];
                                                                                                                                                            } else {
                                                                                                                                                                echo 0;
                                                                                                                                                            } ?>" class="slider" oninput="updateSliderAlign(this.value)">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="backgroundZoom">Zoom sur la photo <b style="color:red;">*</b></label>
                                        <input id="backgroundZoom" class="form-control w-100" name="backgroundZoom" type="range" min="0" max="200" value="<?php if ($isModify) {
                                                                                                                                                                echo $data_o['zoomScale'];
                                                                                                                                                            } else {
                                                                                                                                                                echo 0;
                                                                                                                                                            } ?>" class="slider" oninput="updateSliderZoom(this.value)">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="libelle">Libellé <b style="color:red;">*</b></label>
                                        <input readonly type="text" class="form-control" name="libelle" id="libelle" placeholder="Libellé de l'objet/de la personne" required value="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="datenaissance">Année d'arrivée / Année de naissance <b style="color:red;">*</b></label>
                                        <input readonly type="number" class="form-control" name="datenaissance" id="datenaissance" placeholder="XXXX" required value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="datedeces">Année de départ / Année de décès <b style="color:red;">*</b></label>
                                        <input readonly type="number" class="form-control" name="datedeces" id="datedeces" placeholder="XXXX" required value="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="description">Description <b style="color:red;">*</b></label>
                                        <textarea readonly class="form-control" id="description" name="description" placeholder="Description de l'objet/de la personne"></textarea>
                                    </div>
                                </div>



                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <p><small style="color:grey;"><i>Les liens utiles sont générés automatiquements à partir de l'URL saisie, si elle est vide, il n'y en aura pas.</i></small></p>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12 text-center">
                                        <button type="submit" name="createObject" class="btn btn-success"><?php if ($isModify) echo "Modifier ";
                                                                                                            else echo "Ajouter " ?>l'objet</button>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group col-md-4">
                                <label for="previ">Prévisualisation du pop-up sur la carte</label>
                                <div class="float-right info-bubble" id="overlay" style="opacity:1;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="container container-img" id="imagePreview">
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
                    <?php
                    if (isset($_POST['createObject'])) {
                        $success = 0;
                        if (isset($_POST['createObject']) && !$isModify) {
                            if (OBJ::createObject(basename($_POST['urlwikidata']), $_POST['verticalAlign'], $_POST['backgroundZoom'], $_POST['type'])) {
                                $success = 1;
                            }
                        } else if (isset($_POST['createObject']) && $isModify) {
                            if (OBJ::updateObject($_GET['mod'], basename($_POST['urlwikidata']), $_POST['verticalAlign'], $_POST['backgroundZoom'], $_POST['type'])) {
                                $success = 1;
                            }
                        }

                        if ($success) {
                    ?>
                            <div class="alert alert-success" role="alert">
                                L'objet a été <?php echo ($isModify) ? 'modifié.' : 'créé. '; ?> Redirection...
                            </div>
                        <?php
                            echo '<meta http-equiv="refresh" content="1;URL=manage_objects.php">';
                        } else {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                L'objet n'a pas pu être <?php echo ($isModify) ? 'modifié.' : 'créé. Soit l\'objet existe déjà, soit il s\'agit d\'une erreur.'; ?> Redirection...
                            </div>
                    <?php
                            echo '<meta http-equiv="refresh" content="2;URL=create_element.php">';
                        }
                    }
                    ?>
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
        function updateSliderAlign(value) {
            document.getElementById("imagePreview").style.backgroundPosition = "50% calc(50% + " + value + "px)";
        }

        function updateSliderZoom(value) {
            document.getElementById("imagePreview").style.backgroundSize = "calc(100% + " + value + "px)";
        }

        function loadPreview(urlWikidata, align, zoom) {

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
                        $("#libelle").val(infos.labels.fr.value);


                        /* REMISE A ZERO DE TOUS LES CHAMPS SI JAMAIS ON CHANGE DE LIEN */
                        $("#date_a_objet").html("");
                        $("#date_d_objet").html("");
                        $("#type_objet").html("");
                        $("#desc_objet").html("");
                        $("#liens_objet").html("");

                        // partie image
                        var img = json1.entities[identifier].claims.P18[0].mainsnak.datavalue.value;
                        img = img.split(' ').join('_');
                        var hash = md5(img).substring(0, 2);
                        document.getElementById("imagePreview").style.background = "url('https://upload.wikimedia.org/wikipedia/commons/" + hash[0] + "/" + hash[0] + hash[1] + "/" + img + "')";
                        document.getElementById("imagePreview").style.backgroundSize = "cover";
                        document.getElementById("imagePreview").style.backgroundPosition = "50% calc(50% + 50px)";
                        document.getElementById("imagePreview").style.backgroundRepeat = "no-repeat";
                        if (typeof align !== 'undefined') {
                            updateSliderAlign(align);
                        }
                        if (typeof zoom !== 'undefined') {
                            updateSliderZoom(zoom);
                        }

                        // fin partie image

                        // Partie TYPE
                        if (infos.claims.P31[0].mainsnak.datavalue.value["numeric-id"] == 5) { // s'il s'agit d'un humain
                            if (infos.claims.P21[0].mainsnak.datavalue.value["numeric-id"] == 6581097) { // s'il s'agit d'un male
                                $("#type_objet").html("Humain (Homme)");
                            } else if (infos.claims.P21[0].mainsnak.datavalue.value["numeric-id"] == 6581072) { // s'il s'agit d'une femme
                                $("#type_objet").html("Humain (Femme)");
                            } else {
                                $("#type_objet").html("Humain");
                            }
                        } else {
                            $("#type_objet").html("Objet");
                        }

                        // Partie date arrivée date départ
                        if (infos.claims.P31[0].mainsnak.datavalue.value["numeric-id"] == 5) { // s'il s'agit d'un humain
                            $("#label_dates").html("Année de naissance :");
                            var date_naissance = infos.claims.P569[0].mainsnak.datavalue.value.time;
                            date_naissance = date_naissance.split("-");
                            date_naissance = String(date_naissance).substring(1, 5);
                            $("#date_a_objet").html(date_naissance);
                            $("#datenaissance").val(date_naissance);

                            if (typeof infos.claims.P570 !== 'undefined') {
                                $("#label_dates").html("Année de naissance et de mort :");
                                var date_deces = infos.claims.P570[0].mainsnak.datavalue.value.time;
                                date_deces = date_deces.split("-");
                                date_deces = String(date_deces).substring(1, 5);
                                $("#date_d_objet").html(" - " + date_deces);
                                $("#datedeces").val(date_deces);
                            }
                        } else {
                            $("#label_dates").html("Date d'arrivée et de départ :");
                            // TODO: faire dates des objets mtn
                        }

                        // Partie description 
                        if (infos.claims.P31[0].mainsnak.datavalue.value["numeric-id"] == 5) { // s'il s'agit d'un humain
                            $("#desc_objet").html(infos.descriptions.fr.value.charAt(0).toUpperCase() + infos.descriptions.fr.value.slice(1)); // On met avec une majuscule la String retournée
                            $("#description").val(infos.descriptions.fr.value.charAt(0).toUpperCase() + infos.descriptions.fr.value.slice(1));
                        }

                        // Partie liens utiles
                        if (typeof infos.claims.P6058 !== 'undefined') { // Si page Larousse
                            $("#liens_objet").append("<a href='https://www.larousse.fr/encyclopedie/" + infos.claims.P6058[0].mainsnak.datavalue.value + "' target='_blank'>Encyclopédie Larousse</a><br>");
                        }

                        if (typeof infos.claims.P268 !== 'undefined') { // Si page BNF
                            $("#liens_objet").append("<a href='https://catalogue.bnf.fr/ark:/12148/cb" + infos.claims.P268[0].mainsnak.datavalue.value + "' target='_blank'>Bibliothèque Nationale de France</a><br>");
                        }

                        if (typeof infos.claims.P214 !== 'undefined') { // Si page BNF
                            $("#liens_objet").append("<a href='https://viaf.org/viaf/" + infos.claims.P214[0].mainsnak.datavalue.value + "/' target='_blank'>Fichier d'autorité international virtuel</a><br>");
                        }

                        if (typeof infos.sitelinks !== 'undefined') { // Si page wikipedia
                            $("#liens_objet").append("<a href='" + infos.sitelinks.frwiki.url + "' target='_blank'>Wikipédia</a><br>");
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