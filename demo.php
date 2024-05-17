<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id']))  {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Home Page</title>

</head>
<body>

<?php include 'components/user_header.php';?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>Draggable Marker</title>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <link rel="stylesheet" type="text/css" href="demo.css" /> 
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
  </head>
  <body id="markers-on-the-map">

    <div class="page-header">
        <h1>Cake Shops</h1>
    </div>

    <div id="map"></div>

    <form action="" method="GET">
        <input type="text" name="search" placeholder="Search for a cake...">
        <input type="submit" value="Search">
    </form>

    <?php
    function searchCakes($search) {
      
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
        $likeSearch = "%" . $search . "%";
        $stmt->bind_param("s", $likeSearch);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results were found
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Price: " . $row["price"] . "<br>";
            }
        } else {
            echo "No cakes found.";
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }

    // Check if the search form was submitted
    if (isset($_GET['search'])) {
        $search = $_GET['search'];

        // Display the results
        searchCakes($search);
    }
    ?>

    <!--<p><code></code><code></code> <code></code> <code></code></p>-->

    <script type="text/javascript" src='demo.js'></script>
  </body>
</html>