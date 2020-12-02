var request = new XMLHttpRequest();
request.open("GET", "././api.php", false);
request.send(null);
var jsonInterprete = JSON.parse(request.responseText);
var jsonMarkers = jsonInterprete.Markers;
var jsonMaps = jsonInterprete.Maps;
var jsonObjects = jsonInterprete.Objects;


var map = L.map('mapid', {
			attributionControl: false,
            crs: L.CRS.Simple,
            zoom: -1.8,
            minZoom:-1.8,
            maxZoom:1
        });

    map.setMaxBounds(new L.LatLngBounds([2319,0], [0,6507]));


    var bounds = [[0,0], [2319,6507]];
	var image = L.imageOverlay('././admin/upload/plan_1735.png', bounds).addTo(map);
	var currentMapLayer = image;
	var markersDisplayed = [];

	map.fitBounds(bounds);

	var immersaillesIcon = L.icon({
    iconUrl: '././img/marker.png',

    iconSize:     [38, 50],
    iconAnchor: [38/2,50],
    popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
});
	
createMarkers(1);

	function createMarkers(map_id){
		for(let i = 0; i < jsonMarkers.length; i++) { // pour chaque marqueur
			var obj = jsonMarkers[i]; // on crée une variable temp.
			if (typeof obj.latitude === 'undefined'){ // si le marqueur a une latitude nulle c meme pas la peine de continuer, c le tableau vide
				// ne rien faire
            } else if (obj.map == map_id){ // sinon
				var marker = L.marker([obj.latitude, obj.longitude], {icon: immersaillesIcon}).addTo(map).on('click', onClick);
                marker.objectID = obj.object;
				markersDisplayed.push(marker);
			}
		}
	}

	function changeMapLayer(value){
		for(let i = 0; i < jsonMaps.length; i++) {
			var layer = jsonMaps[i];
			if (layer.id == value){
				map.removeLayer(currentMapLayer);
				var newBounds = [[0,0], [layer.hauteur, layer.largeur]];
				var newMap = L.imageOverlay(layer.lien, newBounds).addTo(map);
				map.setMaxBounds(new L.LatLngBounds([layer.hauteur,0], [0,layer.largeur])); 
				currentMapLayer = newMap;
				for (var j = 0; j < markersDisplayed.length; j++) {
					map.removeLayer(markersDisplayed[j]);
				}
				markersDisplayed = [];
				createMarkers(layer.id);
			}
		}
	  }

	function onClick(e){
        var marker = e.target;

        document.getElementById("noscroll").style.display = "block";
        setTimeout(function(){ // On attends 500 ms avant de cacher le bloc noscroll
            document.getElementById("overlay").style.opacity = "1";

            for(let i = 0; i < jsonObjects.length; i++) {
                var object = jsonObjects[i];
                if (object.id == marker.objectID){

                var wikidata = object.wikidata;
                var verticalAlign = object.verticalAlign;
                var zoomScale = object.zoomScale;

                var xhr = null;

                getXmlHttpRequestObject = function() {
                    if (!xhr) {
                        xhr = new XMLHttpRequest();
                    }
                    return xhr;
                };

                updateLiveData = function() {
                    var url = "https://www.wikidata.org/wiki/Special:EntityData/" + wikidata + ".json";
                    xhr = getXmlHttpRequestObject();
                    xhr.onreadystatechange = evenHandler;
                    xhr.open("GET", url, true);
                    xhr.send(null);

                };

                updateLiveData();


                function evenHandler() {

                    /* AJAX LOADER IMMERSAILLES */
                    document.getElementById("imagePreview").style.background = "url(./img/loader.gif)";
                    document.getElementById("imagePreview").style.backgroundSize = "20%";
                    document.getElementById("imagePreview").style.backgroundPosition = "center";
                    document.getElementById("imagePreview").style.backgroundRepeat = "no-repeat";

                    var loading_img = "<img src='./img/loader.gif' style='width:32px;'>";
                    $("#date_a_objet").html(loading_img);
                    $("#nom_objet").html(loading_img);
                    $("#date_d_objet").html(""); // vide pr eviter double icône chargement
                    $("#type_objet").html(loading_img);
                    $("#desc_objet").html(loading_img);
                    $("#liens_objet").html(loading_img);
                    /* FIN LOADER CUSTOM IMMERSAILLES */


                    // Check response is ready or not
                    if (xhr.readyState == 4 && xhr.status == 200) {

                        var json1 = JSON.parse(xhr.responseText);
                        var infos = json1.entities[wikidata];
                        $("#nom_objet").html(infos.labels.fr.value);
                        $("#libelle").val(infos.labels.fr.value);


                        /* REMISE A ZERO DE TOUS LES CHAMPS SI JAMAIS ON CHANGE DE LIEN */
                        $("#date_a_objet").html("");
                        $("#date_d_objet").html("");
                        $("#type_objet").html("");
                        $("#desc_objet").html("");
                        $("#liens_objet").html("");

                        // partie image
                        var img = json1.entities[wikidata].claims.P18[0].mainsnak.datavalue.value;
                        img = img.split(' ').join('_');
                        var hash = md5(img).substring(0, 2);

                        document.getElementById("imagePreview").style.background = "url('https://upload.wikimedia.org/wikipedia/commons/" + hash[0] + "/" + hash[0] + hash[1] + "/" + img + "')";
                        document.getElementById("imagePreview").style.backgroundSize = "calc(100% + " + zoomScale + "px)";
                        document.getElementById("imagePreview").style.backgroundPosition = "50% calc(50% + "+ verticalAlign +"px)";
                        document.getElementById("imagePreview").style.backgroundRepeat = "no-repeat";

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

                }
            }

        }, 0);

        
	}

	function hideOverlay(){
		if (document.getElementById("overlay").style.opacity == "1"){
			document.getElementById("overlay").style.opacity = "0";
        }
        setTimeout(function(){ // On attends 500 ms avant de cacher le bloc noscroll
            document.getElementById("noscroll").style.display = "none";
        }, 500);
	}

	
    var div_left = L.DomUtil.get('noscroll_left');
	L.DomEvent.on(div_left, 'mousewheel', L.DomEvent.stopPropagation);
    L.DomEvent.on(div_left, 'click', L.DomEvent.stopPropagation);
    
    document.getElementById("noscroll_left").addEventListener('mouseover', function () {
        map.dragging.disable();
    });

    document.getElementById("noscroll_left").addEventListener('mouseout', function () {
        map.dragging.enable();
    });



    var div = L.DomUtil.get('noscroll');
	L.DomEvent.on(div, 'mousewheel', L.DomEvent.stopPropagation);
	L.DomEvent.on(div, 'click', L.DomEvent.stopPropagation);
	document.getElementById("noscroll").addEventListener('mouseover', function () {
        map.dragging.disable();
    });

    document.getElementById("noscroll").addEventListener('mouseout', function () {
        map.dragging.enable();
    });