<?php
include '../components/connect.php';// Assuming this file contains your PDO connection

if (isset($_POST["verify_email"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $verification_code = $_POST["verification_code"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE sellers SET email_verified_at = NOW() WHERE email = ? AND verification_code = ?");
    $stmt->execute([$email, $verification_code]);


    // Check if any rows were affected
    $affected_rows = $stmt->rowCount();

    if ($affected_rows == 0) {
        $error_msg = "Verification code failed.";
    } else {
        $success_msg = "Your email has been verified. You can now login.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cake Bliss - seller registration page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/
    all.min.css">
</head>
<body>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Register now</h3>
            <div class ="flex">
                <div class="col">
                    <div class="input-field">
                    <form method="POST">
                        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
                        <input type="text" name="verification_code" placeholder="Enter verification code" required class="box"/>
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
</div>
</form>
</div>








<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>


<?php include '../components/alert.php'; ?>