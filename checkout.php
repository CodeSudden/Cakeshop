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

// Handle form submission
if (isset($_POST['place_order'])) {
    // Retrieve form data and sanitize
     $date_pickup = $_POST['date_pickup'];
     $date_pickup = filter_var($date_pickup, FILTER_SANITIZE_STRING);

     $time_pickup = $_POST['time_pickup'];
     $time_pickup = filter_var($time_pickup, FILTER_SANITIZE_STRING);

     $num_candles = $_POST['num_candles'];
     $num_candles = filter_var($num_candles, FILTER_SANITIZE_STRING);

     $special_message = $_POST['special_message'];
     $special_message = filter_var($special_message, FILTER_SANITIZE_STRING);

     $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $verify_cart->execute([$user_id]);

     $user_query = $conn->prepare("SELECT name, number, email FROM `users` WHERE id = ?
     ");
    $user_query->execute([$user_id]);
    $user_data = $user_query->fetch(PDO::FETCH_ASSOC);
    $name = $user_data['name'];
    $number = $user_data['number'];
    $email = $user_data['email'];

    if (isset($_GET['get_id'])){

        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);

            if ($get_product->rowCount() > 0) {
                while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                    $seller_id = $fetch_p['seller_id'];

                    $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, seller_id, name, number, email, date_pickup, time_pickup, num_candles, product_id, price, special_message, qty)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                     $insert_order->execute([$user_id, $seller_id, $name, $number, $email, $date_pickup, $time_pickup, $num_candles, $fetch_p['id'], $fetch_p['price'], $special_message, 1]);

                    header('location:order.php');
                }
            }else{
                $warning_msg[] = 'something went wrong';
            }
    }elseif($verify_cart->rowCount() > 0){
        while($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)){
            $s_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $s_products->execute([$f_cart['product_id']]);
            $f_product = $s_products->fetch(PDO::FETCH_ASSOC);

            $seller_id = $f_product['seller_id'];
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, seller_id, name, number, email, date_pickup, time_pickup, num_candles, product_id, price, special_message, qty)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([$user_id, $seller_id, $name, $number, $email, $date_pickup, $time_pickup, $num_candles, $f_cart['product_id'], $f_cart['price'], $special_message, $f_cart['qty']]);


        }
        if ($insert_order) {

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            header('location:order.php');
        }
    }else{
        $warning_msg[] = 'something went wrong';
    }

}
?>
        





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Checkout Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>checkout</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>checkout</span>
        </div>
    </div>

    <div class="checkout">
        <div class="heading">
            <h1>checkout summary</h1>
            <img src="image/separator1.png">
        </div>
        <div class="row">
            <form action="" method="post" class="register">
            <input type="hidden" name="p_id" value="<?= $get_id; ?>">
            <h3>Pickup Details</h3>
            <div class="input-field">
                <p>Date Pickup <span>*</span> </p>
                <input type="date" name="date_pickup" required class="input"> 
            </div>
            <div class="input-field">
            <p>Time Pickup <span>*</span></p>
            <select name="time_pickup" required class="input">
                <option value="">Select Time</option>
                <option value="8-10am">8 -10am</option>
                <option value="11-12am">11 - 12am</option>
                <option value="1-5pm">1 - 5pm</option>
            </select>
        </div>

            <div class="input-field">
                <p>Number of Candles <span>*</span> </p>
                <input type="number" name="num_candles" required min="1" class="input"> 
            </div>
            
            <div class="input-field">
                <p>Special Message <span>*</span> </p>
                <textarea name="special_message" required class="input"></textarea>
            </div>
            <button type="submit" name="place_order" class="btn">place order</button>
            </form>

            <div class="summary">
                <h3>my bag</h3>
                <div class="box-container">
                    <?php
                    $grand_total = 0;
                    if (isset($_GET['get_id'])) {
                        $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_get->execute([$_GET['get_id']]);

                        while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                            $sub_total = $fetch_get['price'];
                            $grand_total+=$sub_total;
                        
                    ?>
                    <div class="flex">
                            <img src="uploaded_files/<?= $fetch_get['image'];?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_get['name'];?></h3>
                                <p class="price">Php<?= $fetch_get['price'];?>/-</p>
                            </div>
                    </div>
                    <?php
                    }
                }else{
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);

                    if ($select_cart->rowCount() > 0) {
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_products->execute([$fetch_cart['product_id']]);
                            $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                            $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                            $grand_total += $sub_total;
                        
                    ?>
                    <div class="flex">
                            <img src="uploaded_files/<?= $fetch_product['image'];?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_product['name'];?></h3>
                                <p class="price">Php<?= $fetch_product['price']; ?> X <?= $fetch_cart['qty'];?></p>
                            </div>
                    </div>
                    <?php
                    }
                }else{
                    echo '<p class="empty">your cart is empty</p>';
                }
            }
                    ?>
                </div>
                <div class="grand_total">
                    <span>total amount payable:</span>
                    <p>Php<?= $grand_total; ?>/-</p>

                </div>
            </div>
        </div>
    </div>



<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>