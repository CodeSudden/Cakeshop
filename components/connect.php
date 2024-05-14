<?php /*   For deployment
$db_host = 'localhost'; // Change this to your database host
$db_name = 'cakeshop_db'; // Change this to your database name
$user_name = 'root'; // Change this to your database username
$user_password = ' '; // Change this to your database password

$db_name = "mysql:host=$db_host;dbname=$db_name";

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if the connection is successful
    if ($conn) {
        // Log to console
        echo "<script>console.log('Connected successfully');</script>";
    }
} catch(PDOException $e) {
    // Log to console
    echo "<script>console.error('Connection failed: " . $e->getMessage() . "');</script>";
}

// Check if the function is not already defined
if (!function_exists('unique_id')) {
    function unique_id()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }
        return $randomString;
    }
}*/
?>

<?php
$db_name = 'mysql:host=localhost;dbname=cakeshop_db';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

if (!$conn) {
    echo "not connect";
}

// Check if the function is not already defined
if (!function_exists('unique_id')) {
    function unique_id()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }
        return $randomString;
    }
}
?>
