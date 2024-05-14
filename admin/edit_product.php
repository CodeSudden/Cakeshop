<?php
include '../components/connect.php';

if(isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
}else{
    $seller_id = '';
    header('location:login.php');
}

if (isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);

        $type = $_POST['type'];
        $type = filter_var($type, FILTER_SANITIZE_STRING);

        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);

        $update_product = $conn->prepare("UPDATE 'products' SET name = ?, price = ?, product_detail
        =?, stock = ?, status = ?, type = ?, WHERE id = ?, WHERE id = ?");
        $update_product->execute([$name, $price, $description, $stock, $status, $type, $product_id]);

        $success_msg[] = 'product updated';

        $old_image = $_POST['old_image'];
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/'.$image;

        $seller_image = $conn->prepare("SELECT * FROM 'products' WHERE image = ? AND seller_id = ?");

        $select_image->execute([$image, $seller_id]);

        if (!empty($image)) {
            if ($image_size > 200000) {
                $warning_msg[] = 'image size is too large';
            }elseif($select_image->rowCount() > 0){
                $warning_msg[] = 'please rename your image';
            }else{
                $update_image = $conn->prepare("UPDATE 'products' SET image = ? AND id = ?");
                $update_image->execute([$image, $product_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if ($old_image != $image AND $old_image != '') {
                    unlink('../uploaded_files/'.$old_image);
                }
                $success_msg[] = 'image updated!';
            }
        }

    }

    if(isset($_POST['delete_image'])) {
        $empty_image= '';

        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

        $delete_image = $conn->prepare("SELECT * FROM 'products' WHERE id = ?");
        $delete_image->execute([$product_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if ($fetch_delete_image['image'] != '') {
            unlink('../uploaded_files/'.$fetch_delete_image['image']);
        }
        $unset_image = $conn->prepare("UPDATE 'products' SET image = ? WHERE id = ?");
        $unset_imge->execute([$empty_image, $product_id]);
        $success_msg[] = 'image deleted successfully';
    }

    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

        $delete_image = $conn->prepare("SELECT * FROM 'products' WHERE id = ?");
        $delete_image->execute([$product_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if ($fetch_delete_image['image'] != '' ) {
            unlink('../uploaded_files/'.$fetch_delete_image['image']);

        }
        $delete_product = $conn->prepare("DELETE FROM 'products' WHERE id = ?");
        $delete_product->execute([$product_id]);
        $success_msg[] = 'product deleted succesfully!';
        header('location:view_product.php');

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
    <section class="post-editor">
    <div class="heading">
        <h1>edit product</h1>
        <img src="../image/separator2.png">
    </div>

    <div class="box-container">
        <?php
        $product_id = $_GET['id']; // Corrected typo in $_GET
        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
        $select_product->execute([$product_id, $seller_id]);
        if ($select_product->rowCount() > 0) { // Corrected syntax error in rowCount()
            while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) { // Corrected typo and syntax error
                // Your code here
            }
        
        

           
    ?>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
            
     <div class="input-field">
            <p>product status<span>*</span></p>
<select name="status" class="box">
    <?php
    $selectedStatus = isset($fetch_product['status']) ? $fetch_product['status'] : '';
    ?>
    <option value="<?= $selectedStatus; ?>" selected><?= $selectedStatus; ?></option>
    <option value="active">active</option>
    <option value="deactive">deactive</option>
</select>
        </div>
        <div class="input-field">
            <p>product name<span>*</span></p>
            <input type="text" name="name" value="<?= is_array($fetch_product) && isset($fetch_product['name']) ? $fetch_product['name'] : ''; ?>"
             class="box">
        </div>
        <div class="input-field">
            <p>product price<span>*</span></p>
            <input type="number" name="price" value="<?= $fetch_product['price']; ?>"
            class="box">
        </div>
        <div class="input-field">
        <p>product description<span>*</span></p>
        <textarea name="description" class="box"><?= isset($fetch_product['product_detail']) ? $fetch_product['product_detail'] : ''; ?></textarea>
        </div>
        <div class="input-field">
            <p>product stock<span>*</span></p>
            <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>"
            class="box" min="0" max="99999999" maxlength="10">
        </div>
        <div class="input-field">
        <p>product type<span>*</span></p>
        <input type="text" name="type" class="box"><?= isset($fetch_product['type']) ? $fetch_product['type'] : ''; ?></input>
        </div>

        <div class="input-field">
    <p>product image<span>*</span></p>
    <input type="file" name="image" accept="image/*" class="box">
    
    <?php if(isset($fetch_product['image']) && $fetch_product['image'] != ''): ?>
        <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="
        image">
        <div class="flex-btn">
            <input type="submit" name="delete_image" class="btn" value="
            delete image">
            <a href="view_product.php" class="btn" style="width:49%; text-align: center; height: 3rem; margin-top: .7rem;">go back</a>
             </div>
    <?php endif; ?>
</div>

    <div class ="flext-btn">
       <input type="submit" name="update" value="update product" class="btn">
       <input type="submit" name="delete_product" value ="delete product" class="btn">


</div>

    </select>
    </form>
    </div>
    <?php
    
    
        
    
            }else{
                echo'
                        <div class="empty">
            <p>no products added yet!  </p>
     </div>
     ';           
            

        
        ?>
      <br><br>
      <div class="flex-btn">
        <a href="view_post.php" class="btn">view product</a>
        <a href="add_post.php" class="btn"> add product</a>

        </div>
        <?php } ?>








</section>

</div>










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>


<?php include '../components/alert.php'; ?>

</body>
</html>
        
        