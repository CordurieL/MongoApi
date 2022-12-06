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
collection.forEach(function (doc) {
  console.log(doc);
  console.log(doc.geometry.y + " " + doc.geometry.x);
  let places = doc.places != null?doc.places:"?";
  let capacity = doc.capacity != null?doc.capacity:"?";
  L.marker([doc.geometry.y, doc.geometry.x])
    .addTo(map)
    .bindPopup(
      doc.name + "<br>" + doc.address + "<br>" + places + "/" + capacity + " places disponibles"
    );
});

</script>