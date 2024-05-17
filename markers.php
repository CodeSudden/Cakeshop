<?php
include 'components/connect.php';

try {

    $sql = "SELECT * FROM location";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $markers = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $markers[] = array(
            "lat" => $row["latitude"],
            "lng" => $row["longitude"],
            "info" => $row["sellerId"],
            "shopname" => $row["shopname"],
            "url" => "view_seller.php?sid={$row['sellerId']}"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($markers);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>