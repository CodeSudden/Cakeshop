<?php
    // Start or resume session
    session_start();

    // Clear all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Clear the user_id cookie
    setcookie('user_id', '', time() - 1, '/');

    // Redirect to the login page or another appropriate page
    header('location: login.php');
    exit; // Ensure that no further code is executed after the redirection
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - about-us Page</title>
</head>
<body>

<?php include 'components/user_header.php';?>
    <div class ="banner">
        <div class="detail">
            <h1>about us</h1> 
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <span> <a href="home.php">home</a> <i class="fas fa-angle-double-right"></i>about us</span>
        </div>
    </div>
    <div class="baker">
        <div class="box-container">
        <div class="box">
           <div class="heading">
                <span>Ed Sheeran</span>
                <h1>Master Baker</h1>
                <img src="image/separator1.png">
           </div>
           <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur.  </p>
            <div class="flex-btn">
                <a href="" class="btn">explore our menu</a>
                <a href="menu.php" class="btn">visit our shop</a>
            </div>
        </div>
        <div class="box">
        <img src="image/separator-img.png" class="img">
        </div>
    </div>
    </div>


    <div class="story">
        <div class="heading">
            <h1>our story</h1>
            <img src="image/separator1.png">
        </div>
        <p>Ea dicta autem eum sint earum et perspiciatis dicta et nulla ullam et aliquid veniam?<br>
            Sit veniam obcaecati et illum vero ea nihil consequuntur et voluptatibus<br> galisum aut internos voluptatibus est repellat harum quo Quis quos?
            Lorem ipsum dolor sit amet, <br>consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <br>tempor incididunt ut labore et dolore magna aliqua,
            Lorem ipsum dolor sit amet, <br>consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua,</p>
            <a href="menu.php" class="btn">our services</a>
    </div>


        <div class="container">
            <div class="box-container">
            <div class="img-box">
                <img src="image/about.jpg">
            </div>
            <div class="box">
                <div class="heading">
                    <h1>taking baking to new heights</h1>
                    <img src="image/separator1.png">
                </div>
                <p>Ea dicta autem eum sint earum et perspiciatis dicta et nulla ullam et aliquid veniam? 
                Sit veniam obcaecati et illum vero ea nihil consequuntur et voluptatibus galisum aut internos voluptatibus est repellat harum quo Quis quos?</p>
                <a href="" class="btn">learn more</a>
            </div>
        </div>
        </div>

    <div class="team">
        <div class="heading">
                    <h1>quality and passion with our service</h1>
                    <img src="image/separator1.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/team-1.jpg" class="img">
                <div class="content">
                    <img src="" alt="">
                    <h2>Duff Goldman</h2>
                    <p>Pastry Chef</p>
                </div>
            </div>
        <div class="box">
                <img src="image/team-2.png" class="img">
                <div class="content">
                    <img src="" alt="">
                    <h2>Paul Hollywood</h2>
                    <p>Celebrity Chef</p>
                </div>
        </div>
        <div class="box">
                <img src="image/team-4.png" class="img">
                <div class="content">
                    <img src="" alt="">
                    <h2>Claire Ptak</h2>
                    <p>Baker and Food Stylist</p>
                </div>
            </div>
        </div>
    </div>

    <div class="standers">
        <div class="detail">
            <div class="heading">
                <h1>our standards</h1>
                <img src="image/separator1.png">
            </div>
            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur <br>qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur. </p>
            <i class="fa fa-heart"></i>
            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur <br>qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur. </p>
            <i class="fa fa-heart"></i>
            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur <br>qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur. </p>
            <i class="fa fa-heart"></i>
            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur <br>qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur. </p>
            <i class="fa fa-heart"></i>
            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur <br>qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur. </p>
            <i class="fa fa-heart"></i>
        </div>
    </div>

    <div class="testimonial">
        <div class="heading">
                <h1>testimonial</h1>
                <img src="image/separator1.png">
            </div>
            <div class="testimonial-container">
                <div class="slide-row" id="slide">
                    <div class="slide-col">
                        <div class="user-text">
                            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                            <h2>Xin</h2>
                            <p>Author</p>
                        </div>
                        <div class="user-img">
                            <img src="image/Xin.webp">
                        </div>
                    </div>
                    <div class="slide-col">
                        <div class="user-text">
                            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                            <h2>Xin</h2>
                            <p>Author</p>
                        </div>
                        <div class="user-img">
                            <img src="image/author-1.jpg">
                        </div>
                    </div>
                    <div class="slide-col">
                        <div class="user-text">
                            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                            <h2>Xin</h2>
                            <p>Author</p>
                        </div>
                        <div class="user-img">
                            <img src="image/author-2.webp">
                        </div>
                    </div>
                    <div class="slide-col">
                        <div class="user-text">
                            <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                            <h2>Xin</h2>
                            <p>Author</p>
                        </div>
                        <div class="user-img">
                            <img src="image/author-4.jpg">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="indicator">
        <span class="btn1 active"></span>
        <span class="btn1"></span>
        <span class="btn1"></span>
        <span class="btn1"></span>
    </div>

    <div class="mission">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <h1>our mission</h1>
                    <img src="image/separator1.png">
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="image/choc-mission2.jpg">
                    </div>
                    <div>
                        <h2>chocolate cake</h2>
                        <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut 
                            Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                    </div>
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="image/red-mission.webp">
                    </div>
                    <div>
                        <h2>red velvet cake</h2>
                        <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut 
                            Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                    </div>
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="image/vanilla-mission3.jpg">
                    </div>
                    <div>
                        <h2>vanilla cake</h2>
                        <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut 
                            Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                    </div>
                </div>
                <div class="detail">
                    <div class="img-box">
                        <img src="image/cheesecake-mission.jpg">
                    </div>
                    <div>
                        <h2>cheesecake cake</h2>
                        <p>Lorem ipsum dolor sit amet. Aut similique modi vel amet consequuntur qui voluptas repellendus ut 
                            Quis nobis non commodi doloribus aut repellendus consequatur.</p>
                    </div>
                </div>
            </div>
            <div class="box">
                <img src="image/form.jpg" alt="" class="img">
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