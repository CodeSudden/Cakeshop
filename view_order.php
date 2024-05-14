<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id']))  {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    if (isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('location:order.php'); 
    }

    if (isset($_POST['cancel'])){

        $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_order->execute(['cancelled', $get_id]);

        header('location:order.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Order Detail Page</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    




</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>order detail</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>order detail</span>
        </div>
    </div>

    <div class="order-detail">
    <div class="heading">
        <h1>My Order Detail</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <img src="image/separator1.png">
    </div>
    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
        $select_order->execute([$get_id]);
        
        if ($select_order->rowCount() > 0){
            while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_product->execute([$fetch_order['product_id']]);

                if ($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                        $sub_total = ($fetch_order['price']* $fetch_order['qty']);
                        $grand_total += $sub_total;
        ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    #container {
        width: 400px;
        height: 250px;
        margin: 50px auto;
    }
    ul {
        padding: 0px;
        margin: 0px;
    }
    li {
        display: inline-block;
        font-size: 35px;
        padding: 10px;
        color: #ccc;
    }
    #message {
        font-size: 25px;
    }
    .hovered-stars {
        color: #FFCC36;
    }
    .clicked-stars {
        color: sandybrown;
    }
</style>
<script>
    $(document).ready(function(){
        $("li").mouseover(function(){
            var current = $(this);
            $("li").each(function(index){
                $(this).addClass("hovered-stars");
                if(index == current.index()) {
                    return false;
                }
            });
        });

        $("li").mouseleave(function(){
            $("li").removeClass("hovered-stars");
        });

        $("li").click(function(){
            $("li").removeClass("clicked-stars");
            var clickedStars = $(this).prevAll().length + 1;
            $(this).prevAll().addClass("clicked-stars");
            $(this).addClass("clicked-stars");
            $("#message").html("Thanks! You have rated this " + clickedStars + " star(s).");

            // Get the feedback value
            var feedback = $("input[name='feedback']").val();

            // Send the rating value and feedback to save-rating.php via AJAX
            $.ajax({
                url: "save-rating.php",
                method: "POST",
                data: {
                    "cake_id": <?php echo $fetch_order['product_id']; ?>,
                    "rating": clickedStars,
                    "feedback": feedback
                },
                success: function (response) {
                    // Display the response message
                    alert(response);
                }
            });
        });
    });
</script>

        <div class="box">
            <div class="col">
                <p class="title"><i class="far fa-calendar-alt"></i><?= $fetch_order['date'];?></p>
                <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                <h3 class="price"><?= $fetch_product['price']; ?></h3>
                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                <p class="grand-total">Total Amount Payable: <span><?= $grand_total; ?></span></p>
                
            </div>
            <div class="col">
                <p class="title">Billing Address</p>
                <p class="user"><i class="far fa-address-card"><?= $fetch_order['name']; ?></i></p>
                <p class="user"><i class="fas fa-phone-alt"><?= $fetch_order['number']; ?></i></p>
                <p class="user"><i class="fas fa-envelope-open-text"><?= $fetch_order['email']; ?></i></p>
                <p class="user"><i class="fas fa-calendar"><?= $fetch_order['date_pickup']; ?></i></p>
                <p class="status" style="color:<?php if($fetch_order['status'] == 'received'){echo "green";}elseif($fetch_order['status'] == 'cancelled'){echo "red";}else{echo "orange";}?>"><?= $fetch_order['status'];?></p>
                
                <?php 
                if ($fetch_order['status'] == 'cancelled' || $fetch_order['status'] == 'received') { ?>
                    <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn" style="line-height: 3">Order Again</a>
                    <div id="container">
    <ul>
        <li><i class="fa fa-star fa fw"></i></li>
        <li><i class="fa fa-star fa fw"></i></li>
        <li><i class="fa fa-star fa fw"></i></li>
        <li><i class="fa fa-star fa fw"></i></li>
        <li><i class="fa fa-star fa fw"></i></li>
    </ul>
    <div id="message">Please rate your overall experience!</div>
</div>

<div class="input-field">
    <p>Feedback<span>*</span></p>
    <input type="text" name="feedback" placeholder="Enter your feedback" maxlength="100" required class="box">
</div>

                <?php } else { ?>
                    <form action="" method="post">
                        <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel the order?')">Cancel</button>
                    </form>
                <?php }
                } ?>
            </div>
        </div>
        <?php
                    }
                }
            
        } else {
            echo '<p class="empty">No orders yet.</p>';
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
