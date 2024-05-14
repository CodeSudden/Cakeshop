<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" type="text/css" href="../css/seller_style1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">
    <!-- Add any additional stylesheets or scripts here -->
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" width="50">
    </div>
    <div class="right">
        <div class="fas fa-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="fas fa-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
            $select_profile->execute([$seller_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="profile">
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img" width="100">
                <p><?= $fetch_profile['name']; ?></p>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="cakeshop-20240112T172637Z-001/cakeshop/components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="btn">Logout</a>
                </div>
            </div>
        <?php
            }
        ?>
    </div>
</header>

<div class="sidebar-container">
    <div class="sidebar">
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
            $select_profile->execute([$seller_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="profile">
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img" width="100">
                <p><?= $fetch_profile['name']; ?></p>
            </div>
        <?php
            }
        ?>
        <h5>menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
                <li><a href="add_products.php"><i class="fas fa-shopping-bag"></i>Add Products</a></li>
                <li><a href="view_product.php"><i class="fas fa-book"></i>View Product</a></li>
                <li><a href="user_accounts.php"><i class="fas fa-users"></i>Accounts</a></li>
                <li><a href="cakeshop-20240112T172637Z-001/cakeshop/components/admin_logout.php" onclick="return confirm('Logout from this website');"><i class="fas fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <h5>find us</h5>
        <div class="social-links">
            <i class="fab fa-facebook"></i>
            <i class="fab fa-instagram"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-pinterest"></i>
            
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/sweeralert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>

    <?php include 'cakeshop-20240112T172637Z-001/cakeshop/components/alert.php'; ?>

</body>
</html>
