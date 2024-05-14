<?php
include 'components/connect.php';

// Start or resume the session
session_start();

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input
    $pass = $_POST['pass']; // No need to sanitize here

    // Hash the password (consider using a stronger hashing algorithm)
    $hashed_pass = sha1($pass);

    $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $select_user->execute([$email, $hashed_pass]);

    // Fetch user data
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        // Check if email is verified
        if ($row['email_verified_at'] != null) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email']; // You can store additional user data in session if needed

            // Set cookie for user_id (if needed)
            setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');

            // Redirect to home page or any other authenticated page
            header('location: home.php');
            exit(); // Make sure to exit after redirecting
        } else {
            $warning_msg[] = 'Please verify your email before logging in. <a href="email-verification.php?email=' . $email . '">Resend verification email</a>';
        }
    } else {
        $warning_msg[] = 'Incorrect email or password';
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
    <title>Cake Bliss - Login Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>login</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>login</span>
        </div>
    </div>

    <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3> Login now </h3>
            <?php
            if (isset($warning_msg) && !empty($warning_msg)) {
                foreach ($warning_msg as $msg) {
                    echo "<div class='warning-msg'>$msg</div>";
                }
            }
            ?>
            <div class="input-field">
                <p>Your email <span>*</span></p>
                <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
            </div>
            <div class="input-field">
                <p>Your password<span>*</span></p>
                <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
            </div>

            <p class="link">Not a member yet?<a href="register.php">Register now</a></p>
            <input type="submit" name="submit" value="Login now" class="btn">
        </form>
    </div>



<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>