<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id']))  {
        $user_id = $_COOKIE['user_id'];
    } else {
        $user_id = '';
    }

    $pid = $_GET['pid']; // Assuming $pid is obtained from the URL parameter

    include 'add_wishlist.php';
    include 'add_cart.php';

    // Retrieve feedback count
    $select_rating_info = $conn->prepare("SELECT COUNT(*) AS rating_count, AVG(rating) AS avg_rating FROM cake_ratings WHERE cake_id = ?");
    $select_rating_info->execute([$pid]);
    $rating_info = $select_rating_info->fetch(PDO::FETCH_ASSOC);
    $rating_count = $rating_info['rating_count'];
    $avg_rating = $rating_info['avg_rating'];
    $avg_rating = number_format((float)$avg_rating, 2, '.', ''); // Format average rating to two decimal places

    // Retrieve individual feedback entries
    $select_feedback = $conn->prepare("SELECT * FROM cake_ratings WHERE cake_id = ?");
    $select_feedback->execute([$pid]);
    $feedback_entries = $select_feedback->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Product Detail Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>

<div class="banner">
    <div class="detail">
        <h1>Product Detail</h1> 
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <span><a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>product detail</span>
    </div>
</div>

<section class="view_page">
    <div class="heading">
        <h1>Product Detail</h1>
        <img src="image/separator1.png" alt="">
    </div>
    <?php
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$pid]);

            if ($select_products->rowCount() > 0) {
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <form action="" method="post" class="box">
        <div class="img-box">
            <!-- Display the product image retrieved from the database -->
            <img src="uploaded_files/<?= $fetch_products['image'];?>" alt="Product Image">
        </div>
        <div class="detail">
            <?php if($fetch_products['stock'] > 9) {?>
                <span class="stock" style="color: green;">In stock</span>
            <?php } elseif($fetch_products['stock'] == 0) { ?>
                <span class="stock" style="color: red;">Out of stock</span>
            <?php } else { ?>
                <span class="stock" style="color: red;">Hurry only <?=$fetch_products['stock'];?> left</span>
            <?php } ?>
            <p class="price">Php<?= $fetch_products['price'];?>/-</p>
            <div class="name"><?= $fetch_products['name'];?></div>
            <p class="product-detail"><?= $fetch_products['product_detail'];?></p>
            <!-- Display the feedback count and average rating -->
            <p class="rating">Feedback Count: <?= $rating_count; ?></p>
            <p class="rating">Average Rating: <?= $avg_rating; ?></p>
            
            <!-- Button to toggle feedback drawer -->
            <button class="toggle-feedback">Toggle Feedback</button>
            
            <!-- Feedback entries in a collapsible drawer -->
            <div class="feedback-entries" style="display: none;">
                <h3>Feedback Entries</h3>
                <ul>
                    <?php foreach ($feedback_entries as $feedback): ?>
                        <li><?= $feedback['feedback']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="button">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($pid); ?>">
                <button type="submit" name="add_to_wishlist" class="btn">add to wishlist <i class="fas fa-heart"></i></button>
                <input type="hidden" name="qty" value="1" min="0" class="quantity">
                <button type="submit" name="add_to_cart" class="btn">add to cart <i class="fas fa-cart-plus"></i></button>
                <br>
                <br>
                <a href="view_seller.php?sid=<?= $fetch_products['seller_id'] ?>" class="btn">view seller <i class="fas fa-store"></i></a>
            </div>
        </div>
    </form>

    <?php
                }
            }
        }
    ?>
</section>

<div class="products">
    <div class="heading">
        <h1>Similar Products</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
        <img src="image/separator1.png" alt="">
    </div>
    <?php include 'shop.php'; ?>
</div>

<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php'; ?>
<script>
    // JavaScript to toggle feedback drawer visibility
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-feedback').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default behavior (page reload)
                var feedbackDrawer = this.nextElementSibling;
                if (feedbackDrawer.style.display === 'none') {
                    feedbackDrawer.style.display = 'block';
                } else {
                    feedbackDrawer.style.display = 'none';
                }
            });
        });
    });
</script>
</body>
</html>
