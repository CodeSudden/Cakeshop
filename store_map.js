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

// Function to create a custom icon with label
function createIcon(label) {
  var iconUrl = 'https://img.icons8.com/fluency/48/marker.png';
  var icon = new H.map.Icon(iconUrl);

  return icon;
}

// Function to add a marker to the map
function addMarker(map, lat, lng, info, icon, url) {
  var markerIcon = icon || createIcon(info); // Use the provided icon or create one with the label
  var marker = new H.map.Marker({ lat: lat, lng: lng }, { icon: markerIcon });
  marker.addEventListener('tap', function () {
    window.location.href = url;  // Redirect to the URL when marker is clicked
  });
  map.addObject(marker);

  // Show label as an info bubble
  marker.addEventListener('pointerenter', function () {
    var bubble = new H.ui.InfoBubble({ lat: lat, lng: lng }, { content: `<a href="${url}" target="_blank">${info}</a>` });
    ui.addBubble(bubble);
  });
}

// Function to add a marker to the map
function currentloc(map, lat, lng, info, icon) {
  // Create a new marker object with the specified latitude, longitude, and optional icon
  var marker = new H.map.Marker({ lat: lat, lng: lng }, { icon: icon });
  // Add an event listener to the marker to handle 'tap' events (e.g., when the marker is clicked)
  marker.addEventListener('tap', function () {
    // Create a new info bubble (popup) at the marker's location with the specified info content
    var bubble = new H.ui.InfoBubble({ lat: lat, lng: lng }, { content: info });
    // Add the info bubble to the map's UI
    ui.addBubble(bubble);
  });
  // Add the marker object to the map
  map.addObject(marker);
}

// Fetch marker data from the server
async function fetchMarkersData() {
  try {
    let response = await fetch('markers.php');
    if (!response.ok) throw new Error('Network response was not ok');
    let data = await response.json();
    markersData = data;
    if (!searchResults || searchResults.length === 0) {
      markersData.forEach(marker => {
        addMarker(map, marker.lat, marker.lng, marker.shopname, null, marker.url);  // Pass the URL to the addMarker function
      });
    }
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

        currentloc(map, pos.lat, pos.lng, "Your Location", userIcon);
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

// Find the nearest cakeshop
function findNearestCakeshop() {
  if (navigator.geolocation) {
    map.removeObjects(map.getObjects());
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
      const nearestIcon = new H.map.Icon('https://img.icons8.com/fluency/48/marker.png');
      // Add marker for the nearest cakeshop on the map
      addMarker(map, nearestMarkerData.lat, nearestMarkerData.lng, nearestMarkerData.shopname, nearestIcon, nearestMarkerData.url);

      // Display list of nearest cakeshops
      const nearestCakeshopsDiv = document.createElement('div');
      nearestCakeshopsDiv.innerHTML = "<h3>Nearest Cakeshops:</h3>";
      distances.forEach(item => {
        const index = item.index;
        const distance = item.distance.toFixed(2);
        nearestCakeshopsDiv.innerHTML += `<p>${markersData[index].shopname} - ${distance} km</p>`;
      });

        // Get the container element with the class "contain"
        const containElement = document.querySelector('.contain');

        // Append the nearestCakeshopsDiv to the container element
        containElement.appendChild(nearestCakeshopsDiv);     
        document.getElementById('noResultsMessage').style.display = 'none';
    });
  } else {
    console.log('Error: Geolocation is not supported by this browser.');
  }
}

// Display search results on the map
function displaySearchResults() {
  const noResultsMessage = document.getElementById('noResultsMessage');
  if (typeof searchResults !== 'undefined' && searchResults.length > 0) {
    map.removeObjects(map.getObjects());
    searchResults.forEach(result => {
      addMarker(map, result.latitude, result.longitude, result.shopname, null, `view_seller.php?sid=${result.sellerId}`);
    });
    document.getElementById('clearSearch').style.display = 'block'; // Show the clear search button
    noResultsMessage.style.display = 'none'; // Hide the no results message
  } else {
    noResultsMessage.style.display = 'block'; // Show the no results message
    document.getElementById('clearSearch').style.display = 'none'; // Hide the clear search button
  }
}

// Clear search results and reload default markers
document.getElementById('clearSearch').addEventListener('click', function () {
  searchResults = []; // Clear the search results
  map.removeObjects(map.getObjects()); // Remove all markers
  fetchMarkersData(); // Reload the default markers
  document.getElementById('clearSearch').style.display = 'none'; // Hide the clear search button
  document.getElementById('noResultsMessage').style.display = 'none'; // Hide the no results message
});

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
displaySearchResults();
checkAndSetMarkers();
loadMarkersFromLocalStorage();