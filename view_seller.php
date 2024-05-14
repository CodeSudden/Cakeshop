<?php
    session_start();
include 'components/connect.php';

// Check if user_id cookie is set
if (isset($_COOKIE['user_id'])) {
    // Set user_id from the cookie
    $user_id = $_COOKIE['user_id'];
} elseif (isset($_SESSION['user_id'])) {
    // If user_id cookie is not set, check if there's a session user_id
    $user_id = $_SESSION['user_id'];
} else {
    // If neither cookie nor session user_id is set, redirect to the login page
    header('Location: login.php');
    exit(); // Make sure to exit after redirection to prevent further execution of code
}

    include 'add_wishlist.php';
    include 'add_cart.php';


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
            <h1>Seller Page</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>Seller Page</span>
        </div>
    </div>



    <div class="items">
    <div class="heading">
        <h1>Baker Page</h1>
        <img src="image/separator2.png">
    </div>
    <div class="box-container">
    <?php
// Assuming $conn is your database connection


    if (isset($_GET['sid'])) {
        $sid = $_GET['sid'];

        // Fetch seller information
        $select_seller_info = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
        $select_seller_info->execute([$sid]);
        if ($seller_info = $select_seller_info->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="seller-info">
                <img src="uploaded_files/<?= $seller_info['image']; ?>" class="img1">
                <h2><?= htmlspecialchars($seller_info['name']); ?></h2>
                <p>Email: <?= htmlspecialchars($seller_info['email']); ?></p>
                <!-- Display other seller details -->
            </div>

            <!-- Fetch and display products from this seller -->
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
            $select_products->execute([$sid]);

            if ($select_products->rowCount() > 0) {
                while ($product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" method="post" class="box <?php if($product['stock'] == 0) { echo "disabled"; } ?>">
                        <img src="uploaded_files/<?= $product['image']; ?>" class="image"width="100">

                        <?php if($product['stock'] > 9) {?>
                            <span class="stock" style="color: green;">In stock</span>
                        <?php } elseif($product['stock'] == 0) { ?>
                            <span class="stock" style="color: red;">Out of stock</span>
                        <?php } else { ?>
                            <span class="stock" style="color: red;">Hurry, only <?= $product['stock']; ?> left</span>
                        <?php } ?>
                        <div class="content">
                            <img src="" alt="" class="">
                            <div class="button">
                                <div> <h3 class="name"><?= $product['name']?></h3></div>
                                <div>
                                    <button type="submit" name="add_to_cart"><i class="fas fa-cart-plus"></i></button>
                                    <button type="submit" name="add_to_wishlist"><i class="fas fa-heart"></i></button>
                                    <a href="view_page.php?pid=<?= $product['id'] ?>" class="far fa-eye"></a>
                                </div>
                            </div>
                            <p class="price">Price: Php<?= $product['price']; ?></p>
                            <input type="hidden" name="product_id" value="<?= $product['id']?>">
                            <div class="flex-btn">
                                <a href="checkout.php?get_id=<?= $product['id'] ?>" class="btn">Buy</a>
                                <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty box">
                            </div>
                        </div>
                    </form>
                    <?php
                }
            } else {
                echo "<p>No products found for this seller.</p>";
            }
            ?>
            <?php
        } else {
            echo '<p>Seller not found.</p>';
        }
    }
    ?>




        
    </div>
</div>














<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>