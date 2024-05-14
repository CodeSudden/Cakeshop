<?php
include 'components/connect.php';

// Get the cake_id, rating, and feedback values from the POST data
$cake_id = $_POST['cake_id'];
$rating = $_POST['rating'];
$feedback = $_POST['feedback'];

// Prepare the SQL statement to insert the rating and feedback into the database
$insert_query = "INSERT INTO cake_ratings (cake_id, rating, feedback) VALUES (:cake_id, :rating, :feedback)";
$insert_statement = $conn->prepare($insert_query);

// Bind the parameters
$insert_statement->bindParam(':cake_id', $cake_id);
$insert_statement->bindParam(':rating', $rating);
$insert_statement->bindParam(':feedback', $feedback);

// Execute the query
if ($insert_statement->execute()) {
    // Rating and feedback saved successfully
    echo "Rating and feedback saved successfully!";
} else {
    // Error handling if insertion failed
    echo "Error: " . $insert_statement->errorInfo()[2];
}

// Close the database connection
$conn = null;
?>
