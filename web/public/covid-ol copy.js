var map;

function initialize_map() {
   map = new ol.Map({
    target: 'map',
    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM()
      })
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([3.41, 45.82]),
      zoom: 3
    })
  });
}

function add_map_point(lat, lng) {
  var vectorLayer = new ol.layer.Vector({
      source:new ol.source.Vector({
      features: [new ol.Feature({
              geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
          })]
      }),
      style: new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0.5, 0.5],
            anchorXUnits: "fraction",
            anchorYUnits: "fraction",
            src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
        })
      })
  });

  map.addLayer(vectorLayer); 

}


function add_map_circle(latitude,longitude, radius){
  var layer = new ol.layer.Vector({
    source: new ol.source.Vector({
      projection: 'EPSG:4326',
      features: [new ol.Feature(new ol.geom.Circle(ol.proj.fromLonLat([longitude, latitude]), radius))]
    }),
    style: [
      new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: 'red',
          width: 2
        }),
        fill: new ol.style.Fill({
          color: 'rgba(255, 0, 0, 0.3)'
        })
      })
    ]
  });
  map.addLayer(layer);
}
