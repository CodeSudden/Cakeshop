<header>
    <div class="logo">
        <img src="../image/logo-removebg-preview.png" width="150">
</div>
<div class ="right">
    <div class="fa fa-user" id="user-btn"></div>
    <div class ="toggle-btn"><i class="fa-solid fa-bars"></i></div>
</div>
<div class="profile-detail">
    <?php
    $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id = ?");

    $select_profile->execute([$seller_id]);

    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    
    ?>
    <div class="profile">
        <img src="../uploaded_files/<?= $fetch_profile['image'];?>"class="logo-img" width="100">
        <p><?= $fetch_profile['name']; ?></p>
        <div class="flex-btn">
        <a href="profile.php" class="btn">profile</a>
<a href="login.php" onclick="return confirm('Logout from this website?');" class="btn">logout</a>

</div>
    <?php } ?>
    </div>
    </header>
<div class="sidebar-container">
        <div class="sidebar">
        <?php
    $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id = ?");

    $select_profile->execute([$seller_id]);

    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    
    ?>
    <div class="profile">
        <img src="../uploaded_files/<?= $fetch_profile['image'];?>"class="logo-img" width="100">
        <p><?= $fetch_profile['name']; ?></p>
    </div>
    <?php } ?>
    <h5>menu</h5>
    <div class="navbar">
    <ul>
        <li> <a href="dashboard.php"><i class="fa fa-home" aria-hidden="true"></i>dashboard</a></li>
        <li> <a href="add_products.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i>add products</a></li>
        <li> <a href="view_product.php"><i class="fa fa-book" aria-hidden="true"></i>view product</a></li>
        <li> <a href="user_accounts.php"><i class="fa fa-user-circle" aria-hidden="true"></i>accounts</a></li>
        <li><a href="login.php" onclick="return confirm('Logout from this website?');">
        <i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>

</ul>
</div>
<h5>find us</h5>
<div class="social-links">
    <i class="fab fa-facebook"></i>
    <i class="fab fa-instagram"></i>
    <i class="fab fa-linkedin"></i>
    <i class="fab fa-twitter"></i>
    <i class="fab fa-pinterest"></i>
    </div>
