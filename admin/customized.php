<?php
include '../components/connect.php';

if(isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cake Bliss - Registered users page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../components/admin_header.php'; ?>

</div>
</div>
    <section class="user-container">
    <div class="heading">
        <h1>Customized Cakes by Users</h1>
        <img src="../image/separator1.png">
    </div>
    <div class="box-container">
<?php
$select_users = $conn->prepare("SELECT * FROM `user_request`");
$select_users->execute();

if ($select_users->rowCount() > 0) {
    while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
    <!-- Display the image -->
    <img src="../uploaded_files/<?= $fetch_users['image']; ?>">
    <p>name: <span><?= $fetch_users['name']; ?></span></p>
    <p>email: <span><?= $fetch_users['email']; ?></span></p>
    <p>date needed: <span><?= $fetch_users['date']; ?></span></p>
    <div class="accept-button-container">
        <button class="accept-button" style="background-color: green;">Accept</button>
    </div>
</div>
<?php
    }
}else{
    echo '<div class="empty">
            <p>no user registered yet!</p>
          </div>';
}
?>
</div>

</section>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>

<?php include '../components/alert.php'; ?>

</body>
</html>