var request = new XMLHttpRequest();
	  request.open("GET", "../././api.php", false);
	  request.send(null);
	  var jsonInterprete = JSON.parse(request.responseText);
	  var jsonMarkers = jsonInterprete.Markers;
	  var jsonMaps = jsonInterprete.Maps;


var map = L.map('mapid', {
			attributionControl: false,
            crs: L.CRS.Simple,
            zoom: -1.8,
            minZoom:-1.8,
            maxZoom:1
        });

    map.setMaxBounds(new L.LatLngBounds([2319+250,0], [0,6507])); // +250 au cas ou un marqueur est super en haut, pour pouvoir cliquer sur modif


    var bounds = [[0,0], [2319,6507]];
	var image = L.imageOverlay('../././admin/upload/plan_1735.png', bounds).addTo(map);
	var currentMapLayer = image;
	var markersDisplayed = [];

	map.fitBounds(bounds);

	/*map.on('click', function(e) {
    console.log("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);
});*/

	var immersaillesIcon = L.icon({
    iconUrl: '../././img/marker.png',
    iconSize:     [38, 50], // la taille de l'icone
    iconAnchor: [38/2,50], // ancre de l'icone par rapport au point lat lng
    popupAnchor:  [0, -40] // ancre du popup par rapport au marqueur
});
	
	createMarkers(1);

function createMarkers(map_id){
	for(let i = 0; i < jsonMarkers.length; i++) { // pour chaque marqueur
		var obj = jsonMarkers[i]; // on crée une variable temp.
		if (typeof obj.latitude === 'undefined'){ // si le marqueur a une latitude nulle c meme pas la peine de continuer, c le tableau vide
			// ne rien faire
		} else if (obj.map == map_id){ // sinon
			var marker = L.marker([obj.latitude, obj.longitude], {icon: immersaillesIcon}).addTo(map).bindPopup('Titre<br><a href="edit_marker.php?id='+obj.id+'">Modifier</a>');
			markersDisplayed.push(marker);
		}
	}
}

function changeMapLayer(value){
	for(let i = 0; i < jsonMaps.length; i++) {
		var layer = jsonMaps[i];
		if (layer.id == value){
			map.removeLayer(currentMapLayer);
			if (document.getElementById('plan') !== null){ // Si il y a un input plan, on met le nom du plan séléctionné à l'intérieur
				document.getElementById("plan").value = layer.libelle;
			}
			var newBounds = [[0,0], [layer.hauteur, layer.largeur]];
			var newMap = L.imageOverlay(layer.lien, newBounds).addTo(map);
			map.fitBounds(newBounds);
			map.setMaxBounds(new L.LatLngBounds([layer.hauteur+250,0], [0,layer.largeur])); // +250 au cas ou un marqueur est super en haut, pour pouvoir cliquer sur modif
			currentMapLayer = newMap;
			for (var j = 0; j < markersDisplayed.length; j++) {
				map.removeLayer(markersDisplayed[j]);
			}
			markersDisplayed = [];
			createMarkers(layer.id);
		}
	}
  }



  function changeMapLayer2(etage, annee){
	  console.log(etage);
	  console.log(annee);
	for(let i = 0; i < jsonMaps.length; i++) {
		var layer = jsonMaps[i];
		if (layer.etage == etage && layer.annee == annee){
			console.log("oui");
			console.log(layer.libelle);
			if (map.hasLayer(currentMapLayer)){
				map.removeLayer(currentMapLayer);
			}
			if (document.getElementById('plan') !== null){ // Si il y a un input plan, on met le nom du plan séléctionné à l'intérieur
				document.getElementById("plan").value = layer.libelle;
			}
			var newBounds = [[0,0], [layer.hauteur, layer.largeur]];
			console.log(layer.lien);
			var newMap = L.imageOverlay(layer.lien, newBounds).addTo(map);
			map.fitBounds(newBounds);
			map.setMaxBounds(new L.LatLngBounds([layer.hauteur+250,0], [0,layer.largeur])); // +250 au cas ou un marqueur est super en haut, pour pouvoir cliquer sur modif
			currentMapLayer = newMap;
			for (var j = 0; j < markersDisplayed.length; j++) {
				map.removeLayer(markersDisplayed[j]);
			}
			markersDisplayed = [];
			createMarkers(layer.id);
		} else {
			map.removeLayer(currentMapLayer);
			for (var j = 0; j < markersDisplayed.length; j++) {
				map.removeLayer(markersDisplayed[j]);
			}
		}
	}
}
