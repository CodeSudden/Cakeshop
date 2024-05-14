<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id']))  {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    if (isset($_POST['submit'])) {

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
        $select_user->execute([$user_id]);
        $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    
    
        $prev_pass = $fetch_user['password'];
        $prev_image = $fetch_user['image'];
    
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
    
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $phone = $_POST['number']; // Retrieve phone number from the form
        $phone = filter_var($phone, FILTER_SANITIZE_STRING); // Sanitize the phone number
    
        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
            $update_name->execute([$name, $user_id]);
            $success_mgs[] = 'username updated successfully';
        }
    
        if(!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM `users` WHERE id = ? AND email = ?");
            $select_email->execute([$user_id, $email]);
    
            if ($select_email->rowCount() > 0) {
                $warning_msg[]= 'email already exist';
            }else{
                $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
                $update_email->execute([$email, $user_id]);
                $success_mgs[] = 'email updated successfully';
            }
        }

        if (!empty($phone)) {
            $update_phone = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
            $update_phone->execute([$phone, $user_id]);
            $success_mgs[] = 'Phone number updated successfully';
        }
    
    
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id().'.'.$ext;
        $image_size = $_FILES['image']['size'];

        if(!empty($image)) {
            if ($image_size > 200000) {
                $warning_msg[] = 'Image size is too large';
            } else {
            $image_data = file_get_contents($_FILES['image']['tmp_name']); // Read image data directly
            $update_image = $conn->prepare("UPDATE `users` SET `image` = ? WHERE `id` = ?");
            $update_image->execute([$image_data, $user_id]);

        if ($prev_image != '' AND $prev_image != $rename) {
            // No need to unlink the previous image if storing as BLOB
            // unlink('uploaded_files/'.$prev_image);
        }
        $success_msg[] = 'Image updated successfully';
    }
}

        
    
        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    
        $old_pass = sha1($_POST['old_pass']);
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    
        $new_pass = sha1($_POST['new_pass']);
        $new_pass =filter_var($new_pass, FILTER_SANITIZE_STRING);
    
        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    
        if ($old_pass != $empty_pass) {
            if ($old_pass != $prev_pass) {
                $warning_msg[] = 'old password not matched';
            }elseif($new_pass != $cpass) {
                $warning_msg[] = 'password not matched';
            }else{
                if ($new_pass != $empty_pass) {
                    $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                    $update_pass->execute([$cpass, $user_id]);
                    $success_msg[] = 'password updated successfully';
                }else{
                    $warning_msg[] = 'please enter a new password';
                }
            }
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
    <title>Cake Bliss - Update Profile Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>update profile</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>login</span>
        </div>
    </div>

    <section class="form-container">
        <div class="heading">
            <h1>update profile details</h1>
            <img src="image/separator1.png">
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <div class="img-box">
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
            </div>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>your name <span>*</span> </p>
                        <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box">
                    </div>
                    <div class="input-field">
                        <p>your email</p>
                        <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box">
                    </div>
                    <div class="input-field">
                        <p>select a picture <span>*</span> </p>
                        <input type="file" name="image" accept="image/*" class="box">
                    </div>
                    <div class="input-field">
                        <p>your number <span>*</span> </p>
                        <input type="text" name="number" placeholder="<?= $fetch_profile['number']; ?>" class="box">
                    </div>
                </div>
                <div class="col">
                <div class="input-field">
                        <p>old password <span>*</span> </p>
                        <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="20">
                    </div>
                    <div class="input-field">
                        <p>new password <span>*</span> </p>
                        <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="20">
                    </div>
                    <div class="input-field">
                        <p>confirm password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="confirm your password" class="box" maxlength="20">
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" value="update profile" class="btn">
        </form>
    </section>



<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>