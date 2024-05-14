<?php
include '../components/connect.php';

if(isset($_POST['submit'])) {


    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    

    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ? AND password = ?");
    $select_seller->execute([$email, $pass]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);

    if ($select_seller->rowCount() > 0) {
        setcookie('seller_id', $row['id'], time() + 60*60*24*30, '/');
        header('location:dashboard.php');
    }else{
        $warning_msg[] = 'incorrect email or password';
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
    <link rel="stylesheet" href="https://cdnjs.cloudfare.com/ajax/libs/font-awesome/6.2.0/css/
    all.min.css">
</head>
<body>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Login now</h3>

            <div class="input-field">
                        <p>your email <span>*</span></p>
                        <input type="email" name="email" placeholder="enter your email" maxlength="50"
                        required class="box">
                    </div>

                    <div class="input-field">
                        <p>your password <span>*</span></p>
                        <input type="password" name="pass" placeholder="enter your password" 
                        maxlength="50" required class="box">
                    </div>

           
                    
                    <p class="link">do not have an account? <a href="register.php">register now</a></p>
                    <input type="submit" name="submit" value="login now" class="btn">
</div>
</div>
</form>
</div>








<script src="https://cdnjs.cloudfare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>


<?php include '../components/alert.php'; ?>

</body>
</html>