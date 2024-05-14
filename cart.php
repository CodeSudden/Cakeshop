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



    if (isset($_POST['update_cart'])) {

        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
        $update_qty->execute([$qty, $cart_id]);

        $success_msg[] = 'cart quantity update successfully';

    }

    if (isset($_POST['delete_item'])) {
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

        $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
        $verify_delete_item->execute([$cart_id]);

        if ($verify_delete_item->rowCount() > 0) {
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
            $delete_cart_id->execute([$cart_id]);

            $success_msg[] = 'cart item delete successfully';
        }else{
            $warning_msg[] = 'cart item already deleted';  
        }
    }

    if (isset($_POST['empty_cart'])) {
        // Check if there are items in the cart for the current user
        $verify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $verify_empty_item->execute([$user_id]);
    
        if ($verify_empty_item->rowCount() > 0) {
            // If there are items, delete all of them from the cart
            $delete_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart_items->execute([$user_id]);
    
            $success_msg[] = 'Cart emptied successfully';
        } else {
            // If the cart is already empty, display a warning message
            $warning_msgp[] = 'Your cart is already empty'; 
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
    <title>Cake Bliss - Cart Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>cart</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>cart</span>
        </div>
    </div>
    <div class="products">
    <div class="products">
            <div class="heading">
                <h1>my cart</h1>
                <img src="image/separator1.png">
            </div>
            <div class="box-container">
                <?php
                    $grand_total = 0;
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);

                    if ($select_cart->rowCount() > 0) {
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_products->execute([$fetch_cart['product_id']]);

                            if ($select_products->rowCount() > 0) {
                                $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);

                
                            
                ?>
                <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo 'disabled';};?>">
                                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                                <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                                <?php if($fetch_products['stock'] > 9){ ?>
                                    <span class="stock" style="color: green;">In stock</span>
                                <?php }elseif($fetch_products['stock'] == 0) {?>
                                    <span class="stock" style="color: red;">out of stock</span>
                                <?php }else{ ?>
                                    <span class="stock" style="color: red;">Hurry only <?= $fetch_products['stock'];?> left</span>
                                <?php } ?>
                                <div class="content">
                                    <img src="" class="">
                                    <h3 class="name"><?= $fetch_products['name']; ?></h3>
                                    <div class="flex-btn">
                                        <p class="price">price Php<?= $fetch_products['price']; ?>/-</p>
                                        <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="box qty">
                                        <button type="submit" name="update_cart" class="far fa-edit box"></button>
                                    </div>
                                    <div class="flex-btn">
                                        <p class="sub-total">sub total : <span>Php<?= $sub_total = ($fetch_cart['qty']*$fetch_cart['price']); ?></span></p>
                                        <button type="submit" name="delete_item" class="btn" onclick="return confirm('remove from cart');">delete</button>
                                    </div>
                                </div>
                </form>
                <?php
                        $grand_total += $sub_total;
                        }else{
                                echo '
                                    <div class="empty">
                                    <p>no products was found.</p>
                                    </div> 
                                ';
                        }
                    }
                }else{
                        echo '
                            <div class="empty">
                            <p>no products added yet.</p>
                            </div> 
                    ';
                }
                ?>
            </div>
            <?php if($grand_total != 0) { ?>
                    <div class="cart-total">
                        <p>total amount payable : <span> Php <?= $grand_total; ?>/-</span></p>
                        <div class="button">
                            <form action="" method="post">
                                <button type="submit" name="empty_cart" class="btn" onclick="return confirm('are you sure to empty your cart?');">Empty Cart</button>
                            </form>
                            <a href="checkout.php" class="btn">proceed to checkout</a>
                        </div>
                    </div>
           <?php } ?>
    </div>



<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>