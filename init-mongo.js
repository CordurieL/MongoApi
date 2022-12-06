// to run this script, use the following command:
// mongo < init-mongo.js

db.createUser({
  user: "lucas",
  pwd: "lucas",
  roles: [
    {
      role: "readWrite",
      db: "firstmongodb",
    },
  ],
});

db.createCollection("poi");
db.poi.insertMany([
  {
    name: "Casa de la Cultura",
    description: "Casa de la Cultura de la ciudad de Cuenca",
    location: {
      type: "Point",
      coordinates: [-78.996, -2.9],
    },
  },
  {
    name: "Chiottes de Shrek",
    description: "Attention, Shrek est dans les chiottes",
    location: {
      type: "Point",
      coordinates: [-26.996, 2.9],
    },
  },
]);
