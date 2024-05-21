<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

?>

<?php include 'components/user_header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>Find Cake Shops</title>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <link rel="stylesheet" type="text/css" href="store_map.css" />
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
</head>
<body id="markers-on-the-map">

<div class="page-header">
    <h1>Find Cake Shops</h1>
</div>

<div id="map"></div>

<div class="contain">
    <button class="btn-nearest" onclick="findNearestCakeshops()">Find Nearest Cakeshop</button>
    <button class="btn-clear" id="clearSearch">Clear Search</button>
        <form class="search" action="" method="GET">
            <input type="text" name="search" placeholder="Search for a cake...">
            <button class="btn-sbmt" type="submit" class="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
            
        <div id="search-results"></div>
    <?php
    function searchCakes($search) {
        global $conn; // Declare $conn as global to access it inside the function

        // Prepare the SQL statement
        $stmt = $conn->prepare("
            SELECT p.id, p.name, p.price, l.latitude, l.longitude, l.shopname, l.sellerId 
            FROM products p 
            JOIN location l ON p.seller_Id = l.sellerId 
            WHERE p.name LIKE ?
        ");
        $likeSearch = "%" . $search . "%";
        $stmt->bindParam(1, $likeSearch, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return results as JSON
        return json_encode($result);
    }

    // Check if the search form was submitted
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        echo '<script>var searchResults = ' . searchCakes($search) . ';</script>';
        ?>    <div id="noResultsMessage">Cake not found </div>
        <?php
    } else {
        echo '<script>var searchResults = [];</script>';
    }
    ?>

</div>

<script type="text/javascript" src='store_map.js'></script>
</body>
</html>
