var map;
var confirmedLayer, deathLayer, recoverLayer, activeLayer;


function makeLayer( r, v, b) {
  return new ol.layer.Vector({
    source: new ol.source.Vector({}),
    style: [
      new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: `rgba(${r}, ${v}, ${b})`,
          width: 2
        }),
        fill: new ol.style.Fill({
          color: `rgba(${r}, ${v}, ${b}, 0.3)`
        })
      })
    ]
  });
}

function initialize_map() {

  confirmedLayer = makeLayer(255, 130, 0);
  deathLayer = makeLayer(255, 0, 0);
  recoverLayer = makeLayer(0, 255, 0);
  activeLayer = makeLayer(130, 130, 0);


   map = new ol.Map({
    target: 'map',
    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM()
      }),
      confirmedLayer,
      deathLayer,
      recoverLayer,
      activeLayer,
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([3.41, 45.82]),
      zoom: 2.5
    })
  });


 //add_map_point(45.0, 2.0);
}

function add_map_point(lat, lng) {
  var geom = new ol.Feature(new ol.geom.Circle(ol.proj.fromLonLat([lng, lat]), 20000));
  deathLayer.getSource().addFeature(geom);
}


function add_map_circle(layer, latitude,longitude, radius){
  var geom = new ol.Feature(new ol.geom.Circle(ol.proj.fromLonLat([longitude, latitude]), radius));
  layer.getSource().addFeature(geom);
}


function switchLayer( layer) {
  confirmedLayer.setVisible(false);
  deathLayer.setVisible(false);
  recoverLayer.setVisible(false);
  activeLayer.setVisible(false);

  layer.setVisible(true);
}