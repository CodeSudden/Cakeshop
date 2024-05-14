<?php

 // Update the path to the send.php file



include '../components/connect.php';
include '../admin/send.php';

if(isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:login.php');
}

ini_set('display_errors', 1);
error_reporting(E_ALL);


if(isset($_POST['update_order'])) {
    // Retrieve order details
    
    
    $order_id_value = $_POST['order_id']; // Use a different variable name to avoid overwriting
    $order_id_value = filter_var($order_id_value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $order_details_stmt = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
    $order_details_stmt->execute([$order_id_value]);
    $fetch_orders = $order_details_stmt->fetch(PDO::FETCH_ASSOC);

    // Sanitize input values
    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment,  FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $update_status = $_POST['status'];
    $update_status = filter_var($update_status,  FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Update payment status and order status
    $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ?, status = ? WHERE id = ?");
    $update_pay->execute([$update_payment, $update_status, $order_id_value]);
    $success_msg[] = 'Order payment status and status updated';

    $product_order = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $product_order->execute([$fetch_orders['product_id']]);
    $fetch_product = $product_order->fetch(PDO::FETCH_ASSOC);

    // Send email notification
require 'send.php'; // Include the send.php file
$subject = 'Order Update';
    $body = 'Dear ' . $fetch_orders['name'] . ',<br>';
    $body .= 'Your order ' . $fetch_product['name'] . ' has been updated.<br>';
    $body .= 'New payment status: ' . $update_payment . '.<br>';
    $body .= 'New order status: ' . $update_status . '.';

    // Send email notification
    sendUpdateEmail($fetch_orders['email'], $subject, $body);
}



if (isset($_POST['delete_order'])) {
    
    $delete_order = $_POST['order_id'];
    $delete_order = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {

        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);

        $success_msg[] = 'order deleted';

    }else{
        $warning_msg[] = 'order already deleted';
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cake Bliss - seller registration page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>

</div>
</div>
    <section class="order-container">
    <div class="heading">
        <h1>total order placed</h1>
        <img src="../image/separator2.png">
    </div>
    <div class="box-container">
    <?php
    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
    $select_order->execute([$seller_id]);
    
    if ($select_order->rowCount() > 0) {
        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
            // Fetch product details based on product_id
            $product_order = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $product_order->execute([$fetch_order['product_id']]);
            $fetch_product = $product_order->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="box">
        <div class="status" style="color: <?php if($fetch_order['status']=='in progress')
         {echo "limegreen";}else{echo "red";} ?>"><?= $fetch_order['status']; ?></div>
         <div class="details">
         <p>Product Name: <span><?= $fetch_product['name']; ?></span></p>
         <p>user name : <span><?= $fetch_order['name']?></span></p>
         <p>user id : <span><?= $fetch_order['user_id']?></span></p>
         <p>placed on : <span><?= $fetch_order['date']?></span></p>
         <p>user number : <span><?= $fetch_order['number']?></span></p> 
         <p>date pickup : <span><?= $fetch_order['date_pickup']?></span></p>
         <p>time pickup : <span><?= $fetch_order['time_pickup']?></span></p>
         <p>total price : <span><?= $fetch_order['price']?></span></p>
         <p>number of candles : <span><?= $fetch_order['num_candles']?></span></p>
         <p>special message : <span><?= $fetch_order['special_message']?></span></p>

        </div>
        <form action="" method="post">
            <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
            <p>payment status: </p>
            <select name="update_payment" class="box" style="width: 90%;">
                <option disabled selected><?= $fetch_order['payment_status']; ?></option>

                <option value="cancelled">cancel</option>
                <option value="pending">pending</option>
                <option value="accepted">accepted</option>
                <option value="complete">order completed</option>

        <form action="" method="post">
            <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
            <p>order status: </p>
            <select name="status" class="box" style="width: 90%;">
                <option disabled selected><?= $fetch_order['status']; ?></option>

                <option value="cancelled">cancel</option>
                <option value="pending">pending</option>
                <option value="in progress">in progress</option>
                <option value="done">done</option>
                <option value="received">picked up</option>

        </select>
        <div class="flex-btn">
            <input type="submit" name="update_order" value="update payment" class="btn">
            <input type="submit" name="delete_order" value="delete order" class="btn" onclick="return confirm('delete this order');">
        
        </div>  
        </form>
        </div>
    <?php 
        }

    }else
    echo ' 
    <div class="empty">
    <p>no order placed yet!</p>
    </div>
    ';
    
    ?>
        
    </div>
</section>

</div>










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>


<?php include '../components/alert.php'; ?>

</body>
</html>
