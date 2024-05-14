<?php
    include '../components/connect.php';
    
    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];

    }else {
        $seller_id = '';
        header('location: loging.php');
    }





?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/seller_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">

</head>

<body>

    <div class ="main-container">
        <?php include '../components/admin_header.php'; ?>
    </div>








   

    <script src="https://cdnjs.cloudflare.com/ajax/sweeralert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>

</html>
