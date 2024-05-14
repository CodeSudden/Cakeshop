<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
    header('location:login.php');
}


if(isset($_POST['publish'])) {

    $date = $_POST['date'];
    $date = filter_var($date, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/'.$image;

    $user_query = $conn->prepare("SELECT name, number, email FROM `users` WHERE id = ?
     ");
    $user_query->execute([$user_id]);
    $user_data = $user_query->fetch(PDO::FETCH_ASSOC);
    $name = $user_data['name'];
    $number = $user_data['number'];
    $email = $user_data['email'];
    

   if (isset($image)){
        $insert_product = $conn->prepare("INSERT INTO `user_request` (user_id, name, date, image) VALUES (?, ?, ?, ?)");
        $insert_product->execute([$user_id, $name, $date, $image]);
        $success_msg[] = 'Product inserted successfully';
        
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Home Page</title>



</head>
<body>

<?php include 'components/user_header.php';?>

<?php



?>


<section class="post-editor">
    <div class="heading">
        <h1>Upload your Customized Cake</h1>
        <img src="../image/separator2.png">
</div>
<div class="form-container">
    

<div class="input-field">
    <form action="" method="post" enctype="multipart/form-data" class="register">
<div class="input-field">
            <p>product image <span>*</span> </p>
            <input type="file" name="image" accept="image/'" required class="box">
            
</div>
<div class="input-field">
                <p>Date<span>*</span> </p>
                <input type="date" name="date" required class="input"> 
            </div>
<div class="flex-btn">
    <input type="submit" name="publish" value="add product" class="btn">
</div>
</form>
</section>

</div>










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>


<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>

</body>
</html>

