var request = new XMLHttpRequest();
	  request.open("GET", "././api.php", false);
	  request.send(null);
	  var jsonInterprete = JSON.parse(request.responseText);
	  var jsonMarkers = jsonInterprete.Markers;


var map = L.map('mapid', {
            crs: L.CRS.Simple,
            zoom: -1.8,
            minZoom:-1.8,
            maxZoom:1
        });

    map.setMaxBounds(new L.LatLngBounds([2319,0], [0,6507]));


    var bounds = [[0,0], [2319,6507]];
	var image = L.imageOverlay('././admin/upload/plan_1735.png', bounds).addTo(map);

	map.fitBounds(bounds);

	map.on('click', function(e) {
    console.log("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);
});

	var immersaillesIcon = L.icon({
    iconUrl: '././img/marker.png',

    iconSize:     [38, 50],
    iconAnchor: [38/2,50],
    popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
});

for(let i = 0; i < jsonMarkers.length; i++) {
		
	var obj = jsonMarkers[i];

if (typeof obj.latitude === 'undefined'){ // si le marqueur a une latitude nulle c meme pas la peine de continuer, c le tableau vide
			// ne rien faire
} else  {
	L.marker([obj.latitude, obj.longitude], {icon: immersaillesIcon}).addTo(map).on('click', onClick);
}

}

	function onClick(){
		document.getElementById("overlay").style.opacity = "1";
		document.getElementById("nom_objet").innerHTML = "Objet marqueur";
	}

	function hideOverlay(){
		if (document.getElementById("overlay").style.opacity == "1"){
			document.getElementById("overlay").style.opacity = "0";
		}
	}

	


        var div = L.DomUtil.get('noscroll');
  L.DomEvent.on(div, 'mousewheel', L.DomEvent.stopPropagation);
  L.DomEvent.on(div, 'click', L.DomEvent.stopPropagation);