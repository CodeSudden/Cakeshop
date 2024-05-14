<?php
include 'components/connect.php';

try {
    // Prepare SQL statement to select all saved cakes
    $stmt = $conn->query("SELECT * FROM saved_cakes");
    
    // Fetch all saved cakes
    $savedCakes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Encode the fetched data as JSON
    $jsonResponse = json_encode($savedCakes);
    
    // Output the JSON response
    echo $jsonResponse;
} catch(PDOException $e) {
    // Handle any errors
    echo json_encode(array("error" => $e->getMessage()));
}

// Close the connection
$conn = null;
?>
