<?php
    session_start();
    include 'components/connect.php';


    if (isset($_SESSION['user_id'])) {
        // User is logged in
        $user_id = $_SESSION['user_id'];

        // Include any other necessary PHP code here for logged-in users
    } else {
        // Check if the user is logged in using cookies
        if (isset($_COOKIE['user_id'])) {
            // User is logged in
            $user_id = $_COOKIE['user_id'];

            // Set session variables for user authentication
            $_SESSION['user_id'] = $user_id;

            // Include any other necessary PHP code here for logged-in users
        } else {
            // User is not logged in
            // Redirect the user to the login page or display a message
            header('Location: login.php');
            exit(); // Make sure to exit after redirection
        }
    }


    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
    $select_orders->execute([$user_id]);
    $total_orders = $select_orders->rowCount();

    $select_address = $conn->prepare("SELECT * FROM `addresses` WHERE user_id = ?");
    $select_address->execute([$user_id]);
    $total_address = $select_address->rowCount();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - User Profile Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
<div class ="banner">
        <div class="detail">
            <h1>profile</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>profile</span>
        </div>
    </div>
    <section class="profile">
        <div class="heading">
            <h1>profile detail</h1>
            <img src="image/separator1.png">
        </div>
        <div class="details">
            <div class="user">
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
                <h3><?= $fetch_profile['name']; ?></h3>
                <p><?= $fetch_profile['email']?></p>
                
                <a href="update.php" class="btn">add new address</a>
            </div>
            <div class="box-container">
                <div class="box">
                    <div class="flex">
                        <i class="fas fa-folder-minus"></i>
                        <h3><?= $total_orders; ?></h3>
                    </div>
                    <a href="order.php" class="btn">view orders</a>
                </div>
                <div class="box">
                    <div class="flex">
                        <i class="far fa-address-book"></i>
                        <h3><?= $total_address; ?></h3>
                    </div>
                    <a href="address.php" class="btn">view addresses</a>
                </div>
            </div>
            </div>
                    <div class="box">
                    <div class="flex">
                        <i class="fab fa-logout"></i>
                    </div>
                    <a href="login.php" class="btn">log out</a>
                </div>
            </div>
        </div>
        </div>

    </section>

    



<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>