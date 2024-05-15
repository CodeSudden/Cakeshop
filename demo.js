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

  marker.addEventListener('tap', function(evt) {
    var bubble = new H.ui.InfoBubble({lat: lat, lng: lng}, {
      content: info
    });
    ui.addBubble(bubble);
  });

  map.addObject(marker);
}

var markersData = [];

function fetchMarkersData() {
  fetch('markers.php')
    .then(response => response.json())
    .then(data => {
      markersData = data;
      markersData.forEach(function(marker) {
        addMarker(map, marker.lat, marker.lng, marker.info, null);
      });
    })
    .catch(error => console.error('Error fetching markers data:', error));
}

function updateMarkers() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(
      function(position) {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        map.removeObjects(map.getObjects());

        addMarker(map, pos.lat, pos.lng, "Your Location", userIcon);

        markersData.forEach(function(data) {
          addMarker(map, data.lat, data.lng, data.info, null);
        });

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

fetchMarkersData();
updateMarkers();

var userIcon = new H.map.Icon('https://img.icons8.com/color/48/000000/marker.png');

function calculateDistance(lat1, lon1, lat2, lon2) {
  var R = 6371;
  var dLat = (lat2 - lat1) * Math.PI / 180;
  var dLon = (lon2 - lon1) * Math.PI / 180;
  var a = 0.5 - Math.cos(dLat) / 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * (1 - Math.cos(dLon)) / 2;

  return R * 2 * Math.asin(Math.sqrt(a));
}

function findNearestCakeshop() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var userLat = position.coords.latitude;
      var userLng = position.coords.longitude;

      var distances = [];
      markersData.forEach(function(data, index) {
        var distance = calculateDistance(userLat, userLng, data.lat, data.lng);
        distances.push({ index: index, distance: distance });
      });

      distances.sort(function(a, b) {
        return a.distance - b.distance;
      });

      // Change the icon for the closest cakeshop
      var closestIndex = distances[0].index;
      var closestCakeshop = markersData[closestIndex];
      addMarker(map, closestCakeshop.lat, closestCakeshop.lng, closestCakeshop.info, closestIcon);

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

var closestIcon = new H.map.Icon('https://img.icons8.com/ios-glyphs/30/marker--v1.png');

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

function loadMarkersFromLocalStorage() {
  for (var i = 0; i < localStorage.length; i++) {
    var key = localStorage.key(i);
    if (key !== 'markersAdded') {
      var markerData = JSON.parse(localStorage.getItem(key));
      addMarker(map, markerData.lat, markerData.lng, key, null);
    }
  }
}

checkAndSetMarkers();
loadMarkersFromLocalStorage();
