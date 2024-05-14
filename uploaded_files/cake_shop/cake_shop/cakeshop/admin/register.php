<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);
    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
    $select_seller->execute([$email]);
    $warning_msg = array();
    if ($select_seller->rowCount() > 0) {
        $warning_msg[] = 'Email already exists!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Confirm password not matched';
        } else {
            $insert_seller = $conn->prepare("INSERT INTO sellers (id, name, email, password, image) VALUES(?, ?, ?, ?, ?)");
            $insert_seller->execute([$id, $name, $email, $cpass, $rename]);

            if ($insert_seller) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'New seller registered! Please login now';
            } else {
                $warning_msg[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Registration</title>
    <link rel="stylesheet" type="text/css" href="../css/seller_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">

</head>

<body>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3> Register now </h3>
            <?php
            if (isset($warning_msg) && !empty($warning_msg)) {
                foreach ($warning_msg as $msg) {
                    echo "<div class='warning-msg'>$msg</div>";
                }
            }

            if (isset($success_msg) && !empty($success_msg)) {
                foreach ($success_msg as $msg) {
                    echo "<div class='success-msg'>$msg</div>";
                }
            }
            ?>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Your name <span>*</span></p>
                        <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Your email <span>*</span></p>
                        <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                        <p>Your password<span>*</span></p>
                        <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Confirm password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="Confirm your password" maxlength="50" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p>Your profile <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>
            <p class="link">Already have an account? <a href="login.php">Login now</a></p>
            <input type="submit" name="submit" value="Register now" class="btn">
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/sweeralert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>

</html>
