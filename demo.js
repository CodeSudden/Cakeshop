
var api = "05won92Luh3ZiFm7H0ujLejWCaNvgIKEYbZtwIAUZtM";


var mapContainer = document.getElementById('map');


mapContainer.style.border = '5px solid pink';


var platform = new H.service.Platform({apikey: api});
var defaultLayers = platform.createDefaultLayers();
var map = new H.Map(mapContainer, defaultLayers.vector.normal.map, {
  center: {lat:14.679440, lng: 120.540780},
  zoom: 12,
  pixelRatio: window.devicePixelRatio || 1
});

window.addEventListener('resize', () => map.getViewPort().resize());

var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
var ui = H.ui.UI.createDefault(map, defaultLayers, 'en-US');


function addMarker(map, lat, lng, info, icon) {
  var marker = new H.map.Marker({lat: lat, lng: lng}, {
    icon: icon
  });

  // Add event listener to the marker
  marker.addEventListener('tap', function(evt) {
    
    var bubble = new H.ui.InfoBubble({lat: lat, lng: lng}, {
      content: info
    });
    
    ui.addBubble(bubble);
  });

  map.addObject(marker);
}


var markersData = [
  {lat:14.679440, lng: 120.540780, info: "Cakeshop 1"},
  {lat: 14.677100, lng: 120.541650, info: "Cakeshop 2" },
  {lat: 14.678820, lng: 120.542030, info: "Cakeshop 3"},
  {lat: 14.681177330323592, lng: 120.53736108004638, info: "Cakeshop 4"},
  {lat: 14.67806388643619, lng: 120.53875113957264, info: "Cakeshop 5"},
  {lat: 14.687765072646256,  lng: 120.54361124837475, info: "Cakeshop 6"},
  {lat: 14.673645026379802,  lng: 120.51054349411339 , info: "Cakeshop 7"},
  {lat: 14.678298299955369,   lng: 120.53939345534666, info: "Cakeshop 8" },
  {lat: 14.68257143982315,  lng: 120.53771257856249, info: "Cakeshop 9"  }
];


function updateMarkers() {
 
  if (navigator.geolocation) {
      navigator.geolocation.watchPosition(
          function(position) {
              const pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
              };

              // Remove existing user marker
              map.removeObjects(map.getObjects());

              // Add user marker with customized icon
              addMarker(map, pos.lat, pos.lng, "Your Location", userIcon);

              // Add markers from markersData to the map
              markersData.forEach(function(data) {
                  addMarker(map, data.lat, data.lng, data.info, null); // Use null icon for existing markers
              });

              // Center the map on the user's location
              map.setCenter(pos);
          },
          function() {
              console.log('Error: The Geolocation service failed.');
          }
      );
  } else {
      console.log('Error: Your browser doesn\'t support geolocation.');
  }
}

// Call the function to update markers with live location
updateMarkers();

// Customize marker icon for users
var userIcon = new H.map.Icon('https://img.icons8.com/color/48/000000/marker.png');

// Function to calculate distance between two points
function calculateDistance(lat1, lon1, lat2, lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = (lat2 - lat1) * Math.PI / 180;  // deg2rad below
  var dLon = (lon2 - lon1) * Math.PI / 180;
  var a =
    0.5 - Math.cos(dLat) / 2 +
    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
    (1 - Math.cos(dLon)) / 2;

  return R * 2 * Math.asin(Math.sqrt(a));
}

// Function to find nearest cakeshop
function findNearestCakeshop() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var userLat = position.coords.latitude;
      var userLng = position.coords.longitude;

      // Calculate distance from user to each cakeshop
      var distances = [];
      markersData.forEach(function(data, index) {
        var distance = calculateDistance(userLat, userLng, data.lat, data.lng);
        distances.push({ index: index, distance: distance });
      });

      // Sort distances array by distance
      distances.sort(function(a, b) {
        return a.distance - b.distance;
      });

      
      var nearestCakeshopsDiv = document.createElement('div');
      nearestCakeshopsDiv.innerHTML = "<h3>Nearest Cakeshops:</h3>";
      distances.forEach(function(item) {
        var index = item.index;
        var distance = item.distance.toFixed(2); 
        nearestCakeshopsDiv.innerHTML += "<p>" + markersData[index].info + " - " + distance + " km</p>";
      });

     
      document.body.appendChild(nearestCakeshopsDiv);
    });
  } else {
    console.log('Error: Geolocation is not supported by this browser.');
  }
}


var findNearestButton = document.createElement('button');
findNearestButton.textContent = 'Find Nearest Cakeshop';
findNearestButton.style.backgroundColor = 'pink';
findNearestButton.style.color = 'white';
findNearestButton.style.borderRadius = '10px'; 
findNearestButton.style.padding = '10px 20px'; 
findNearestButton.style.fontSize = '16px'; 
findNearestButton.addEventListener('click', findNearestCakeshop);
document.body.appendChild(findNearestButton);


function checkAndSetMarkers() {
  if (localStorage.getItem('markersAdded') !== 'true') {
    
    markersData.forEach(function(data) {
      localStorage.setItem(data.info, JSON.stringify({lat: data.lat, lng: data.lng}));
    });
    localStorage.setItem('markersAdded', 'true');
  }
}


checkAndSetMarkers();


function loadMarkersFromLocalStorage() {
  for (var i = 0; i < localStorage.length; i++) {
    var key = localStorage.key(i);
    if (key !== 'markersAdded') {
      var markerData = JSON.parse(localStorage.getItem(key));
      addMarker(map, markerData.lat, markerData.lng, key, null);
    }
  }
}


loadMarkersFromLocalStorage();
