(function($){

  Drupal.behaviors.pageBranch = {
    attach: function(context, settings) {

      //Map
      var content;

      var branches = Drupal.settings.carbon.branches,
        marker = Drupal.settings.carbon.marker,
        features = [], f;

      var markStyle = new ol.style.Icon({
        src: marker,
        anchor: [.5,1]
      });

      $.each(branches, function(){
        var coords = this.coords;
        f = new ol.Feature({
          geometry: new ol.geom.Point(ol.proj.fromLonLat([coords[0], coords[1]])),
          content: this.content,
        });

        f.setStyle(new ol.style.Style({image : markStyle}));
        features.push(f);

      });

      var vectorSource = new ol.source.Vector({
        features: features
      });

      var vectorLayer = new ol.layer.Vector({
        source: vectorSource
      });

      var rasterLayer = new ol.layer.Tile({
        source: new ol.source.OSM({layer: 'osm'})
      });

      var view = new ol.View({
         	center: ol.proj.fromLonLat(Drupal.settings.carbon.center),
          zoom: 15
      });

      var map = new ol.Map({
        layers: [rasterLayer, vectorLayer],
        target: document.getElementById('map'),
        view: view,
        interactions: ol.interaction.defaults({mouseWheelZoom:false})
      });

      // Popover
      var element = document.getElementById('popover');

      var popup = new ol.Overlay({
        element: element,
        positioning: 'top-center',
        stopEvent: false
      });

      map.addOverlay(popup);

      map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
              return feature;
            });
        if (feature) {
          var mapsize = map.getSize(), pos = evt.pixel, placement;

          element.className = 'transparent';

          // $(element).popover('destroy');
          setTimeout(function(){
          popup.setPosition(evt.coordinate);
            element.innerHTML = feature.get('content');
            element.className = 'opaque';
            // $(element).popover({
            //   'placement': placement,
            //   'html': true,
            //   'content': feature.get('content')
            // });
            // $(element).popover('show');
          }, 500);
        } else {
          element.innerHTML = feature.get('content');
          element.className = 'opaque';
        // $(element).popover('destroy');
        }
      });

      // change mouse cursor when over marker
      map.on('pointermove', function(e) {
        if (e.dragging) {
          element.innerHTML = '';
          element.className = 'transparent';
          // $(element).popover('destroy');
          return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTarget().style.cursor = hit ? 'pointer' : '';
      });


      // Center branch
      $('.branches').on('click', '.branch', function(){
        var lat = parseFloat(this.dataset.lat), lon = parseFloat(this.dataset.lon);

        $this = $(this);
        $this.parent().find('.branch').removeClass('active');
        $this.addClass('active');

        var pan = ol.animation.pan({
          duration: 2000,
          source: /** @type {ol.Coordinate} */ (view.getCenter())
        });

        map.beforeRender(pan);

        view.setCenter(ol.proj.fromLonLat([lon, lat]));
        view.setZoom(16);
      });

    }
  }

}(jQuery));

