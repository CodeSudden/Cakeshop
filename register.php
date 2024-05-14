<?php
include 'components/connect.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_files/' . $rename;

    $select_users = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $select_users->execute([$email]);
    $warning_msg = array();
    if ($select_users->rowCount() > 0) {
        $warning_msg[] = 'Email already exists!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Confirm password not matched';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $insert_users = $conn->prepare("INSERT INTO users (id, name, email, password, number, image, verification_code, email_verified_at) VALUES(?, ?, ?, ?, ?, ?, ?, NULL)");
            $insert_users->execute([$id, $name, $email, $cpass, $phone, $rename, $verification_code]);

            if ($insert_users) {
                sendVerificationEmail($email, $verification_code);
                // Redirect user to email verification page
                header("Location: email-verification.php?email=" . urlencode($email));
                exit();
            } else {
                $warning_msg[] = 'Registration failed. Please try again.';
            }
            
        }
    }
}

function sendVerificationEmail($email, $verification_code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cakebliss3d@gmail.com';  // Update with your SMTP username
        $mail->Password = 'gfid wnwc cdlg rliu';  // Update with your SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('your_email@example.com', 'Cake Bliss');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email';
        $mail->Body = "Hello, and welcome to Cake Bliss. <br> Here is your verification code is <strong>{$verification_code}</strong>.";

        $mail->send();
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
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
    <title>Cake Bliss - User Registration Page</title>
</head>
<body>

<?php include 'components/users_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>register</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>register</span>
        </div>
    </div>

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
                        <input type="text" name="name" placeholder="Enter your name i.e. Juan Dela Cruz" maxlength="50" required class="box" alt>
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
                    <div class="input-field">
                        <p>Your number<span>*</span></p>
                        <input type="text" name="phone" placeholder="Enter your phone number" maxlength="11" required class="box" pattern="[0-9]{11}" title="Please enter a valid 11-digit phone number" alt="e.g. 09112233445">
                    </div>      

                </div>
            </div>
            <div class="input-field">
                <p>Your profile <span>*</span></p>
                <input type="file" name="image" accept="image/*"  class="box">
            </div>
            <p class="link">Already have an account? <a href="login.php">Login now</a></p>
            <input type="submit" name="submit" value="Register now" class="btn">
        </form>
    </div>



<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>