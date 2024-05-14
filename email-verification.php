<?php
include 'components/connect.php'; // Assuming this file contains your PDO connection

if (isset($_POST["verify_email"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $verification_code = $_POST["verification_code"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE users SET email_verified_at = NOW() WHERE email = ? AND verification_code = ?");
    $stmt->execute([$email, $verification_code]);

    // Check if any rows were affected
    $affected_rows = $stmt->rowCount();

    if ($affected_rows == 0) {
        $error_msg = "Verification code failed.";
    } else {
        $success_msg = "Your email has been verified. You can now login.";
        header("Location: login.php" );
                exit();
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Email Verification Page</title>
</head>
<body>

<?php include 'components/users_header.php';?>
<div class="banner">
    <div class="detail">
        <h1>Email Verification</h1> 
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
        <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>email verification</span>
    </div>
</div>
<section class="form-container">
        <h3>Email Verification</h3>
    <div class="flex">
        <div class="col">
            <form method="POST" class="register">
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required class="box">
                <input type="text" name="verification_code" placeholder="Enter verification code" required class="box" />
                <input type="submit" name="verify_email" value="Verify Email" class="btn">
            </form>
            <?php
            if (isset($error_msg)) {
                echo "<div class='warning-msg'>$error_msg</div>";
            } elseif (isset($success_msg)) {
                echo "<div class='success-msg'>$success_msg</div>";
                header("Location: email-verification.php?email=" . urlencode($email));
                exit();
            }
            ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>
