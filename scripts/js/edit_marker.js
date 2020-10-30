		var request = new XMLHttpRequest();
		request.open("GET", "../././api.php", false);
		request.send(null);
	 	var jsonInterprete = JSON.parse(request.responseText);
	  	var jsonMarkers = jsonInterprete.Markers;
	  	var jsonMaps = jsonInterprete.Maps;
		var idMarker = document.getElementById("id").value;
		var objMarker;
		var markerEdit = [];

for(let i = 0; i < jsonMarkers.length; i++) { // pour chaque marqueur
		objMarker = jsonMarkers[i]; // on crée une variable temp.
		if (objMarker.id == idMarker){ // si le marqueur trouvé correspond a celui en cours d'édition
			

	var obj;

	for(let  j = 0; j < jsonMaps.length; j++) { // pour chaque marqueur
		var map = jsonMaps[j]; // on crée une variable temp.
		if (map.id == objMarker.map){ // si le marqueur trouvé correspond a celui en cours d'édition
			obj = map;
		}
	}

	var map = L.map('mapid', {
				attributionControl: false,
	            crs: L.CRS.Simple,
	            zoom: obj.zoom,
	            minZoom: obj.zoom,
	            maxZoom:1
	        });

	    map.setMaxBounds(new L.LatLngBounds([obj.hauteur+250,0], [0,obj.largeur])); // +250 au cas ou un marqueur est super en haut, pour pouvoir cliquer sur modif
		var bounds = [[0,0], [obj.hauteur, obj.largeur]];
		var image = L.imageOverlay(obj.lien, bounds).addTo(map);
		var currentMapLayer = image;
		map.fitBounds(bounds);

		var immersaillesIcon = L.icon({
	    iconUrl: '../././img/marker.png',
	    iconSize:     [38, 50], // la taille de l'icone
	    iconAnchor: [38/2,50], // ancre de l'icone par rapport au point lat lng
	    popupAnchor:  [0, -40] // ancre du popup par rapport au marqueur
	});

		/* AFFICHAGE DU MARQUEUR EN QUESTION */
	    var markerEdition = L.marker([objMarker.latitude, objMarker.longitude], {icon: immersaillesIcon}).addTo(map);
	    markerEdit.push(markerEdition); // Je le met dans un tableau pour etre sur qu'il y en est qu'un affiché quand on va ensuite vouloir le changer de place
	    markerEdition.bindPopup('Titre<br><a href="#" onclick="changeMarkerPosition();">Modifier la position</a>'); // Je lui met une popup
	    document.getElementById("latitude").value = objMarker.latitude;  // Je met sa position dans les cases à droite
        document.getElementById("longitude").value = objMarker.longitude;

		}
}

function changeMarkerPosition(marker){
		document.getElementById("latitude").value = "En attente d'un clic sur la carte..."; // On affiche ça dans les input histoire de bloquer le formulaire
		document.getElementById("longitude").value = "En attente d'un clic sur la carte...";

		map.removeLayer(markerEdit[0]); // Je vire l'ancien marker de la map
		markerEdit = [];

		map.on('click', function(e) { // A chaque clic sur la map
			if (markerEdit.length == 0){ // si aucun marqueur n'est placé
				// J'en place un nouveau
				var newMarker = L.marker([e.latlng.lat, e.latlng.lng], {icon: immersaillesIcon}).addTo(map).bindPopup('Titre<br><a href="#" onclick="changeMarkerPosition();">Modifier la position</a>');
		    	markerEdit.push(newMarker); // que je place dans un tableau
		    	document.getElementById("latitude").value = e.latlng.lat; // et je complète les input à droite
				document.getElementById("longitude").value = e.latlng.lng;
			}
		});
}






