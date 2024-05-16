// HERE Maps API Key
var api = "05won92Luh3ZiFm7H0ujLejWCaNvgIKEYbZtwIAUZtM";

// Map container setup
var mapContainer = document.getElementById('map');
mapContainer.style.border = '5px solid pink';

// Initialize HERE Maps platform and map
var platform = new H.service.Platform({ apikey: api });
var defaultLayers = platform.createDefaultLayers();
var map = new H.Map(mapContainer, defaultLayers.vector.normal.map, {
  center: { lat: 14.679440, lng: 120.540780 },
  zoom: 12,
  pixelRatio: window.devicePixelRatio || 1
});

// Adjust map viewport on window resize
window.addEventListener('resize', () => map.getViewPort().resize());

// Enable map events and UI components
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
var ui = H.ui.UI.createDefault(map, defaultLayers, 'en-US');

// Function to add a marker to the map
function addMarker(map, lat, lng, info, icon) {
  var marker = new H.map.Marker({ lat: lat, lng: lng }, { icon: icon });
  marker.addEventListener('tap', function () {
    var bubble = new H.ui.InfoBubble({ lat: lat, lng: lng }, { content: info });
    ui.addBubble(bubble);
  });
  map.addObject(marker);
}

// Fetch marker data from server
async function fetchMarkersData() {
  try {
    let response = await fetch('markers.php');
    if (!response.ok) throw new Error('Network response was not ok');
    let data = await response.json();
    markersData = data;
    markersData.forEach(marker => {
      addMarker(map, marker.lat, marker.lng, marker.info, null);
    });
  } catch (error) {
    console.error('Error fetching markers data:', error);
  }
}

// Update markers based on user's location
function updateMarkers() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(
      function (position) {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        map.removeObjects(map.getObjects());
        addMarker(map, pos.lat, pos.lng, "Your Location", userIcon);

        markersData.forEach(data => {
          addMarker(map, data.lat, data.lng, data.info, null);
        });

        map.setCenter(pos);
      },
      function () {
        console.log('Error: The Geolocation service failed.');
      }
    );
  } else {
    console.log('Error: Your browser doesn\'t support geolocation.');
  }
}

// Calculate distance between two coordinates
function calculateDistance(lat1, lon1, lat2, lon2) {
  const R = 6371; // Radius of the Earth in kilometers
  const dLat = (lat2 - lat1) * Math.PI / 180;
  const dLon = (lon2 - lon1) * Math.PI / 180;
  const a = 0.5 - Math.cos(dLat) / 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * (1 - Math.cos(dLon)) / 2;

  return R * 2 * Math.asin(Math.sqrt(a));
}

// Find the nearest cakeshop to the user and add a marker for it
function findNearestCakeshop() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
      const userLat = position.coords.latitude;
      const userLng = position.coords.longitude;

      const distances = markersData.map((data, index) => ({
        index: index,
        distance: calculateDistance(userLat, userLng, data.lat, data.lng)
      }));

      distances.sort((a, b) => a.distance - b.distance);

      // Find the nearest cakeshop
      const nearest = distances[0];
      const nearestMarkerData = markersData[nearest.index];

      // Create a marker icon for the nearest cakeshop
      const nearestIcon = new H.map.Icon('https://img.icons8.com/material-two-tone/48/marker.png');

      // Add marker for the nearest cakeshop on the map
      addMarker(map, nearestMarkerData.lat, nearestMarkerData.lng, nearestMarkerData.info, nearestIcon);

      // Display list of nearest cakeshops
      const nearestCakeshopsDiv = document.createElement('div');
      nearestCakeshopsDiv.innerHTML = "<h3>Nearest Cakeshops:</h3>";
      distances.forEach(item => {
        const index = item.index;
        const distance = item.distance.toFixed(2);
        nearestCakeshopsDiv.innerHTML += `<p>${markersData[index].info} - ${distance} km</p>`;
      });

      document.body.appendChild(nearestCakeshopsDiv);
    });
  } else {
    console.log('Error: Geolocation is not supported by this browser.');
  }
}

// Add a button to find the nearest cakeshop
const findNearestButton = document.createElement('button');
findNearestButton.textContent = 'Find Nearest Cakeshop';
findNearestButton.style.backgroundColor = 'pink';
findNearestButton.style.color = 'white';
findNearestButton.style.borderRadius = '10px';
findNearestButton.style.padding = '10px 20px';
findNearestButton.style.fontSize = '16px';
findNearestButton.addEventListener('click', findNearestCakeshop);
document.body.appendChild(findNearestButton);

// Check and store markers in local storage
function checkAndSetMarkers() {
  if (localStorage.getItem('markersAdded') !== 'true') {
    markersData.forEach(data => {
      localStorage.setItem(data.info, JSON.stringify({ lat: data.lat, lng: data.lng }));
    });
    localStorage.setItem('markersAdded', 'true');
  }
}

// Load markers from local storage
function loadMarkersFromLocalStorage() {
  for (let i = 0; i < localStorage.length; i++) {
    const key = localStorage.key(i);
    if (key !== 'markersAdded') {
      const markerData = JSON.parse(localStorage.getItem(key));
      addMarker(map, markerData.lat, markerData.lng, key, null);
    }
  }
}

// User icon for current location
const userIcon = new H.map.Icon('https://img.icons8.com/color/48/000000/marker.png');

// Fetch and update markers on load
fetchMarkersData();
updateMarkers();
checkAndSetMarkers();
loadMarkersFromLocalStorage();
