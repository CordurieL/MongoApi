<?php
// Code source permettant d'accéder aux données parking du Grand Nancy
require __DIR__ . '/vendor/autoload.php';

$m = new MongoDB\Client('mongodb://mongo');
$db = $m->selectDatabase('firstmongodb');
$collection = $db->selectCollection('pis');

include("index.html");

?>
<script>
  var map = L.map("map").setView([48.69, 6.18], 14);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

const collection = <?php echo json_encode($collection->find()->toArray()); ?>;

let redMarker = L.icon({
  iconUrl: "https://github.com/pointhi/leaflet-color-markers/blob/master/img/marker-icon-red.png?raw=true",
  iconSize: [25, 41]
});
let blueMarker = L.icon({
  iconUrl: "https://github.com/pointhi/leaflet-color-markers/blob/master/img/marker-icon-blue.png?raw=true",
  iconSize: [25, 41]
});
let orangeMarker = L.icon({
  iconUrl: "https://github.com/pointhi/leaflet-color-markers/blob/master/img/marker-icon-orange.png?raw=true",
  iconSize: [25, 41]
});

collection.forEach(function (doc) {
  let places = doc.places != null?doc.places:"?";
  let capacity = doc.capacity != null?doc.capacity:"?";
  let iconDisplayed = blueMarker;
  if (places == "?" || capacity == "?") {
    iconDisplayed = orangeMarker;
  } else if (places == 0) {
    iconDisplayed = redMarker;
  }
    L.marker([doc.geometry.y, doc.geometry.x], {icon: iconDisplayed})
    .addTo(map)
    .bindPopup(
      doc.name + "<br>" + doc.address + "<br>" + places + "/" + capacity + " places disponibles"
    )
});


</script>