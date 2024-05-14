<?php
    session_start();
    include 'components/connect.php';


    if (isset($_SESSION['user_id'])) {
        // User is logged in
        $user_id = $_SESSION['user_id'];

        // Include any other necessary PHP code here for logged-in users
    } else {
        // Check if the user is logged in using cookies
        if (isset($_COOKIE['user_id'])) {
            // User is logged in
            $user_id = $_COOKIE['user_id'];

            // Set session variables for user authentication
            $_SESSION['user_id'] = $user_id;

            // Include any other necessary PHP code here for logged-in users
        } else {
            // User is not logged in
            // Redirect the user to the login page or display a message
            header('Location: login.php');
            exit(); // Make sure to exit after redirection
        }
    }

    if (isset($_POST['send_message'])) {
        if ($user_id != '') {

            $id = unique_id();
            $name = $_POST['name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);

            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_STRING);

            $subject = $_POST['subject'];
            $subject = filter_var($subject, FILTER_SANITIZE_STRING);

            $message = $_POST['message'];
            $message = filter_var($message, FILTER_SANITIZE_STRING);

            $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
            $verify_message->execute([$user_id, $name, $email, $subject, $message]);

            if($verify_message->rowCount() > 0) {
                $warning_msg[] = 'message already exist';
            }else{
                $insert_message = $conn->prepare("INSERT INTO `message`(id, user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
                $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);

                $success_msg[] = 'comment inserted successfully';
            }
        }else{
            $warning_msg[] = 'please login first';
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
    <title>Cake Bliss - Contact Us Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>Contact us</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>contact us</span>
        </div>
    </div>
    <div class="services">
        <div class="heading">
            <h1>our services</h1>
            <p>Just a few clicks to make the Reservation Online for Saving your time and money</p>
            <img src="image/separator1.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/freeshipping.png" >
                <div>
                    <h1>free shipping fast</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="box">
                <img src="image/guarantee.jpg">
                <div>
                    <h1>money back & guarantee</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="box">
                <img src="image/247.jpg">
                <div>
                    <h1>online support 24/7</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="heading">
            <h1>drop us a line</h1>
            <p>Just a few clicks to make the Reservation Online for Saving your time and money</p>
            <img src="image/separator1.png">
        </div>
        <form action="" method="post" class="register">
            <div class="input-field">
                <label>name <sup>*</sup></label>
                <input type="text" name="name" required placeholder="enter your name" class="box">
            </div>
            <div class="input-field">
                <label>email <sup>*</sup></label>
                <input type="email" name="email" required placeholder="enter your email" class="box">
            </div>
            <div class="input-field">
                <label>subject <sup>*</sup></label>
                <input type="text" name="subject" required placeholder="state your reason." class="box">
            </div>
            <div class="input-field">
                <label>comment <sup>*</sup></label>
                <textarea name="message" cols="30" rows="10" required placeholder="" class="box"></textarea>
            </div>
            <button type="submit" name="send_message" class="btn">send message</button>
        </form>
    </div>

    <div class="address">
        <div class="heading">
            <h1>our contact details</h1>
            <p>Just a few clicks to make the Reservation Online for Saving your time and money</p>
            <img src="image/separator1.png">
        </div>
        <div class="box-container">
            <div class="box">
                <i class="fas fa-map-marked-alt"></i>
                    <div>
                        <h4>address</h4>
                        <p>Bayan, Orani,<br> Bataan, Philippines, 2112</p>
                    </div>
            </div>
            <div class="box">
                <i class="fas fa-phone-square-alt"></i>
                    <div>
                        <h4>phone number</h4>
                        <p>+63 9102 234 4567</p>
                        <p>+63 9102 234 4567</p>
                    </div>
            </div>
            <div class="box">
                <i class="fa fa-envelope"></i>
                    <div>
                        <h4>email</h4>
                        <p>cakebliss@gmail.com</p>
                        <p>cakebliss@gmail.com</p>
                    </div>
            </div>
            

        </div>
    </div>




<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>