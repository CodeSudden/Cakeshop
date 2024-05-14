<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id']))  {
    $user_id = $_COOKIE['user_id'];

    // Your existing code for fetching orders goes here
    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
    $select_orders->execute([$user_id]);
    $total_orders = $select_orders->rowCount();

    // Your existing code for fetching messages goes here
} else {
    // If user is not logged in, redirect to login page
    header('location:login.php');
    exit; // Make sure to exit after redirecting to prevent further execution of code
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - User Order Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>my orders</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>my orders</span>
        </div>
    </div>

    <div class="orders">
        <div class="heading">
            <h1>my orders</h1>
            <img src="image/separator1.png">
        </div>
        <div class="box-container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                $select_orders->execute([$user_id]);

                if ($select_orders->rowCount() > 0) {
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        $product_id = $fetch_orders['product_id'];

                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$product_id]);

                        if ($select_products->rowCount() > 0) {
                            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                                

            ?>
            <div class="box" <?php if($fetch_orders['status'] == 'cancelled'){echo 'style = "border:2px solid red"';} ?>>
                                <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
                                <img src="uploaded_files/<?= $fetch_products['image'] ?>" class="image">
                                <p class="date"> <i class="far fa-calendar-alt"></i><?= $fetch_orders['date']; ?></p>
                                <div class="content">
                                    <div class="row">
                                        <h3 class="name"><?= $fetch_products['name'] ?></h3>
                                        <p class="price">Price: <?= $fetch_products['price'] ?></p>
                                        <p class="status" style="color:<?php if($fetch_orders['status'] == 'order delivered'){echo "green";}elseif($fetch_orders['status'] == 'status: cancelled'){echo "red";}else{echo "orange";}?>"><?= $fetch_orders['status'];?></p>
                                    </div>
                                </div>
                            </a>
            </div>
            <?php
                            }
                        }
                    }
                }else{
                    echo '<p class="empty">no item ordered yet.</p>';
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