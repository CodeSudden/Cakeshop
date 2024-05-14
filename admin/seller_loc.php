<?php
include '../components/connect.php';

if(isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>HERE Maps Integration</title>
    <style>
        #mapContainer {
            width: 100%;
            height: 500px;
        }
    </style>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"
            type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
</head>
<body>
    <div id="mapContainer"></div>
    <form id="locationForm" method="POST" action=" ">
        <input type="text" id="latitude" name="latitude" readonly>
        <input type="text" id="longitude" name="longitude" readonly>
        <input type="submit" value="Save Location">
    </form>
    <button onclick="getCurrentLocation()">Get Current Location</button>

    <script>
        // Initialize the platform object:
        var platform = new H.service.Platform({
            'apikey': '05won92Luh3ZiFm7H0ujLejWCaNvgIKEYbZtwIAUZtM'
        });

        // Obtain the default map types from the platform object
        var defaultLayers = platform.createDefaultLayers();

        // Instantiate (and display) a map object:
        var map = new H.Map(
            document.getElementById('mapContainer'),
            defaultLayers.vector.normal.map,
            {
                zoom: 10,
                center: { lat: 14.6386, lng: 121.0140 }
            }
        );

        // Enable the event system on the map instance:
        var mapEvents = new H.mapevents.MapEvents(map);

        // Instantiate the default behavior, providing the mapEvents object:
        var behavior = new H.mapevents.Behavior(mapEvents);

        // Add default UI components to the map
        var ui = H.ui.UI.createDefault(map, defaultLayers);

        // Function to add marker on the map
        function addMarkerToGroup(group, coordinate, html) {
            var marker = new H.map.Marker(coordinate);
            marker.setData(html);
            group.addObject(marker);
        }

        // Create a group to hold map markers
        var group = new H.map.Group();
        map.addObject(group);

        // Add event listeners:
        map.addEventListener('tap', function(evt) {
            var coord = map.screenToGeo(evt.currentPointer.viewportX, evt.currentPointer.viewportY);
            console.log('Tapped at ' + Math.abs(coord.lat.toFixed(4)) +
                ((coord.lat > 0) ? 'N' : 'S') + ' ' +
                Math.abs(coord.lng.toFixed(4)) + ((coord.lng > 0) ? 'E' : 'W'));
            document.getElementById('latitude').value = coord.lat.toFixed(4);
            document.getElementById('longitude').value = coord.lng.toFixed(4);

            // Clear existing markers
            group.removeAll();

            // Add a new marker at the tapped location
            addMarkerToGroup(group, {lat: coord.lat, lng: coord.lng}, 'User selected location');
        });

        // Function to get the current location of the user
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    // Update form fields
                    document.getElementById('latitude').value = lat.toFixed(4);
                    document.getElementById('longitude').value = lng.toFixed(4);

                    // Clear existing markers
                    group.removeAll();

                    // Add a new marker at the current location
                    addMarkerToGroup(group, {lat: lat, lng: lng}, 'Current location');

                    // Center the map on the current location
                    map.setCenter({lat: lat, lng: lng});
                    map.setZoom(17);  // Optional: Zoom in to the current location
                }, function(error) {
                    console.error("Geolocation error: " + error.message);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
    <?php
        echo $seller_id;
    ?>
</body>
</html>

<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cakeshop_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO location (lat, lng) VALUES (?, ?)");
    $stmt->bind_param("dd", $latitude, $longitude);

    // Execute the query
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
