<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id']))  {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    include '../cakeshop/add_wishlist.php';
    include '../cakeshop/add_cart.php';


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Shop Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>Our shop</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>our shop</span>
        </div>
    </div>

    <section class="user-container">
    <div class="heading">
        <h1>registered users</h1>
        <img src="../image/separator2.png">
    </div>
    <div class="box-container">
    <?php
// Assuming $conn is your database connection

// Fetch unique seller IDs
$select_sellers = $conn->prepare("SELECT DISTINCT seller_id FROM `products`");
$select_sellers->execute();

if ($select_sellers->rowCount() > 0) {
    while ($fetch_sellers = $select_sellers->fetch(PDO::FETCH_ASSOC)) {
        $seller_id = $fetch_sellers['seller_id'];

        // Fetch seller information
        $select_seller_info = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
        $select_seller_info->execute([$seller_id]);
        $seller_info = $select_seller_info->fetch(PDO::FETCH_ASSOC);

        // Fetch total products for this seller
        $select_products = $conn->prepare("SELECT COUNT(*) AS total_products FROM `products` WHERE seller_id = ?");
        $select_products->execute([$seller_id]);
        $total_products_result = $select_products->fetch(PDO::FETCH_ASSOC);
        $total_products = $total_products_result['total_products'];

        // Display seller information and total products
        ?>
        <div class="seller-info">
            <p>Seller: <?= $seller_info['name'] ?></p>
            <p>Email: <?= $seller_info['email'] ?></p>
            <p>Total Products: <?= $total_products ?></p>
            <a href="store.php?seller_id=<?= $seller_id ?>" class="btn">Visit Store</a>
        </div>
        <?php
    }
} else {
    echo '<div class="empty">
            <p>No sellers found!</p>
          </div>';
}
?>

        
    </div>
</section>

</div>













<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>