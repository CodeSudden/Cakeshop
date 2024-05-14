<?php
include '../components/connect.php';
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image= filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/'.$rename;

    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ?");
    $select_seller->execute([$email]);

    if ($select_seller->rowCount() > 0) {
        $warning_msg[] = 'Email already exists!';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Confirm password not matched';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $insert_seller = $conn->prepare("INSERT INTO `sellers` (id, name, email, password, image, verification_code, email_verified_at) VALUES (?, ?, ?, ?, ?, ?, NULL)");
            $insert_seller->execute([$id, $name, $email, $cpass, $rename, $verification_code]);

            if ($insert_seller) {
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
        $mail->Body = "Your verification code is <strong>{$verification_code}</strong>";

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cake Bliss - Seller Registration Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <h3>Register now</h3>
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
                <div class="input-field">
                    <p>Your password <span>*</span></p>
                    <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>Confirm password <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Confirm your password" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>Your profile <span>*</span></p>
                    <input type="file" name="image" accept="image/*" required class="box">
                </div>
                <p class="link">Already have an account? <a href="login.php">Login now</a></p>
                <input type="submit" name="submit" value="Register now" class="btn">
            </div>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>

<?php include '../components/alert.php'; ?>

</body>
</html>
