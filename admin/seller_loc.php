<?php
include '../components/connect.php';

if(isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:login.php');
}

// Prepare the SQL statement with a placeholder
$stmt = $conn->prepare("SELECT name FROM `sellers` WHERE id = :seller_id");
$stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
$stmt->execute();
$shopname = $stmt->fetchColumn();

// Query to get the seller's current location
$latitude = null;
$longitude = null;

if ($seller_id !== '') {
    $stmt = $conn->prepare("SELECT latitude, longitude FROM location WHERE sellerId = :sellerId LIMIT 1");
    $stmt->bindParam(':sellerId', $seller_id, PDO::PARAM_INT);
    $stmt->execute();
    $location = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($location) {
        $latitude = $location['latitude'];
        $longitude = $location['longitude'];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Location</title>
    <style>
        body{
            height: auto;
            width: auto;
            margin-top: 120px;
        }
        .title{
            text-align: center;
        }
        #mapContainer {            
            width: 50%;
            height: 500px;
            margin-top: 70px;
            margin: auto;
        }
        .LocationForm{
            padding: 50px;
            margin: auto;
            width: 50%;
            height: auto;
        }
        button{
            color: black;
            background-color: pink;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
        }
        button:hover{
            cursor: pointer;
            background-color: rgb(204, 165, 171);
        }
        .loc-sbmt{
            padding: 10px;
            border-radius: 10px;
        }
    </style>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
</head>
<body>
    <h1 class="title">Pin your store Location</h1>
    <div id="mapContainer">
        <button onclick="goback()">Go back</button>
        <button class="btn-currloc" onclick="getCurrentLocation()">Get Current Location</button>
    </div>
    <div class="LocationForm">
        <form id="locationForm" method="POST" action="">
            <input type="hidden" id="shopname" name="shopname" value="<?= $shopname ?>">
            <input type="hidden" id="sellerId" name="sellerId" value="<?= $seller_id ?>">
            Latitude: <input class="lat" type="text" id="latitude" name="latitude" value="<?= $latitude !== null ? $latitude : '' ?>" >
            Longitude: <input class="lng" type="text" id="longitude" name="longitude" value="<?= $longitude !== null ? $longitude : '' ?>" >
            <input class="loc-sbmt" type="submit" value="Save Location">
        </form>
    </div>
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

        <?php if ($latitude !== null && $longitude !== null): ?>
            // Add a marker for the seller's location
            addMarkerToGroup(group, {lat: <?= $latitude ?>, lng: <?= $longitude ?>}, 'Seller Location');
            map.setCenter({lat: <?= $latitude ?>, lng: <?= $longitude ?>});
            map.setZoom(15);
        <?php endif; ?>

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

        function goback() {
            window.location.href = 'dashboard.php';
        }
    </script>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if required POST parameters are set
        if (isset($_POST['sellerId']) && $_POST['shopname'] && isset($_POST['latitude']) && isset($_POST['longitude'])) {
            $seller_id = $_POST['sellerId'];
            $shopname = $_POST['shopname'];
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];

            // Validate the inputs
            if (is_numeric($seller_id) && is_numeric($latitude) && is_numeric($longitude)) {
                // Prepare and bind
                $stmt = $conn->prepare("
                    INSERT INTO location (sellerId, latitude, longitude, shopname) 
                    VALUES (:sellerId, :latitude, :longitude, :shopname)
                    ON DUPLICATE KEY UPDATE
                    latitude = VALUES(latitude),
                    longitude = VALUES(longitude)
                ");

                // Bind parameters
                $stmt->bindParam(':sellerId', $seller_id, PDO::PARAM_INT);
                $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
                $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);
                $stmt->bindParam(':shopname', $shopname, PDO::PARAM_STR);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<script>window.location.href = 'seller_loc.php';</script>";
                } else {
                    echo "<script>alert('Error: Could not execute the query')</script>";
                }
            } else {
                echo "<script>alert('Invalid input values.')</script>";
            }
        } else {
            echo "<script>alert('All fields are required.')</script>";
        }
    }

// Close the connection
$conn = null;
?>
