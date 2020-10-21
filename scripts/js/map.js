var map = L.map('mapid', {
            crs: L.CRS.Simple,
            zoom: -1.8,
            minZoom:-1.8
        });

    map.setMaxBounds(new L.LatLngBounds([2319,0], [0,6507]));


    var bounds = [[0,0], [2319,6507]];
	var image = L.imageOverlay('http://localhost/Immersailles/admin/upload/plan_1735.png', bounds).addTo(map);

	map.fitBounds(bounds);

	map.on('click', function(e) {
    console.log("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);
});


        var div = L.DomUtil.get('noscroll');
  L.DomEvent.on(div, 'mousewheel', L.DomEvent.stopPropagation);
  L.DomEvent.on(div, 'click', L.DomEvent.stopPropagation);