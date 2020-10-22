var request = new XMLHttpRequest();
	  request.open("GET", "../././api.php", false);
	  request.send(null);
	  var jsonInterprete = JSON.parse(request.responseText);
	  var jsonMarkers = jsonInterprete.Markers;
	  var jsonMaps = jsonInterprete.Maps;

var idMarker = document.getElementById("id").value;
var objMarker;

for(let i = 0; i < jsonMarkers.length; i++) { // pour chaque marqueur
		objMarker = jsonMarkers[i]; // on crée une variable temp.
		if (objMarker.id == idMarker){ // si le marqueur trouvé correspond a celui en cours d'édition
			setMapParameters(objMarker.map);
		}
}

function setMapParameters(id){

	var obj;

	for(let  j = 0; j < jsonMaps.length; j++) { // pour chaque marqueur
		var map = jsonMaps[j]; // on crée une variable temp.
		if (map.id == id){ // si le marqueur trouvé correspond a celui en cours d'édition
			obj = map;
		}
	}

	var map = L.map('mapid', {
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
	    L.marker([objMarker.latitude, objMarker.longitude], {icon: immersaillesIcon}).addTo(map);
	    document.getElementById("latitude").value = objMarker.latitude; 
        document.getElementById("longitude").value = objMarker.longitude;

}



