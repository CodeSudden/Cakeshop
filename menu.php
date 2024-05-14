<?php
    include 'components/connect.php';

    // Start or resume the session
    session_start();

    // Check if user_id cookie is set
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        // If user_id cookie is not set, check if there's a session user_id
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            // If neither cookie nor session user_id is set, initialize user_id as empty
            $user_id = '';
        }
    }

    include 'add_wishlist.php';
    include 'add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Bliss - Shop Page</title>
    <link rel="stylesheet" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Our shop</h1>
        <p><form action="" method="post">
    <label for="type_filter">Filter by flavor:</label>
    <select id="type_filter" name="type_filter">
        <option value="">All</option>
        <?php
        // Retrieve distinct cake types from the database
        $select_types = $conn->prepare("SELECT DISTINCT type FROM `products`");
        $select_types->execute();
        while ($row = $select_types->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['type'] . '">' . $row['type'] . '</option>';
        }
        ?>
    </select>
    <button type="submit" name="filter_submit">Apply Filter</button>
</form></p>
        <span><a href="home.php">Home</a> <i class="fas fa-angle-double-right"></i> Our shop</span>
    </div>
</div>



<div class="products">
    <div class="heading">
        <h1>Our latest flavors</h1>
        <img src="image/separator1.png" alt="">
    </div>
    <div class="box-container">
        <?php
        // Prepare SQL query with potential type filter
        $sql = "SELECT * FROM `products` WHERE status = ?";
        $params = ['active'];

        // Check if a type filter is applied
        if (isset($_POST['type_filter']) && !empty($_POST['type_filter'])) {
            $sql .= " AND type = ?";
            $params[] = $_POST['type_filter'];
        }

        // Execute the query
        $select_products = $conn->prepare($sql);
        $select_products->execute($params);

        // Display products
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo "disabled";} ?>">
                    <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">

                    <?php if($fetch_products['stock'] > 9) {?>
                        <span class="stock" style="color: green;">In stock</span>
                    <?php }elseif($fetch_products['stock'] == 0){ ?>
                        <span class="stock" style="color: red;">Out of stock</span>
                    <?php }else{ ?>
                        <span class="stock" style="color: red;">Hurry, Only <?= $fetch_products['stock']?></span>
                    <?php } ?>

                    <div class="content">
                        <img src="" alt="" class="">
                        <div class="button">
                            <div> <h3 class="name"><?= $fetch_products['name']?></h3></div>
                            <div>
                                <button type="submit" name="add_to_cart"><i class="fas fa-cart-plus"></i></button>
                                <button type="submit" name="add_to_wishlist"><i class="fas fa-heart"></i></button>
                                <a href="view_page.php?pid=<?= $fetch_products['id'] ?>" class="far fa-eye"></a>
                                <a href="view_seller.php?sid=<?= $fetch_products['seller_id'] ?>" class="fas fa-store"></a>
                            </div>
                        </div>
                        <p class="price">Price Php<?= $fetch_products['price']; ?></p>
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']?>">
                        <div class="flex-btn">
                            <a href="checkout.php?get_id=<?= $fetch_products['id'] ?>" class="btn">Buy</a>
                            <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty box">
                        </div>
                    </div>
                </form>
                <?php
            }
        } else {
            echo '
            <div class="empty">
                <p>No products added yet.</p>
            </div>';
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
