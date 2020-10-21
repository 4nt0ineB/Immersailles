var map = L.map('mapid', {
            center: [50.99, 10.191],
            zoom: 6,
            minZoom:6,
            maxBounds:[[55.3915921070334,20.610351562500004],[47.17477833929906,1.7138671875000002]]
        });



        var basemap = L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png");
        basemap.addTo(map);

        var div = L.DomUtil.get('noscroll');
  L.DomEvent.on(div, 'mousewheel', L.DomEvent.stopPropagation);
  L.DomEvent.on(div, 'click', L.DomEvent.stopPropagation);