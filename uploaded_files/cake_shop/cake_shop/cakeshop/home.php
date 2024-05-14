<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id']))  {
        $user_id = $_COOKIE['user id'];
    }else{
        $user_id = '';
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Home Page</title>



</head>
<body>


<?php include 'components/user_header.php';?>

</div>
</div>

<div class="slider-container">
    <div class="slider">
        <div class="slideBox active">
            <div class="textBox">
                <h1>we pride ourselves on <br> exceptional flavors</h1>
                <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="imgBox">
                <img src="image/slider.jpg">
            </div>
        </div>
        <div class="slideBox active">
            <div class="textBox">
                <h1>life is uncertain. <br> eat dessert first</h1>
                <a href="menu.php" class="btn">shop now</a>
            </div>
            <div class="imgBox">
                <img src="image/slider7.jpeg">
            </div>
        </div>
    </div>
    <ul class="controls">
        <li onclick="nextSlide();" class="next"><i class="fas fa-arrow-right"></i></li>
        <li onclick="prevSlide();" class="prev"><i class="fas fa-arrow-left"></i></li>
    </ul>
</div>


<div class="service">
    <div class="box-container">
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services.png" class="img1">
                    <img src="image/services (1).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>delivery</h4>
                <span>100% secure</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services (2).png" class="img1">
                    <img src="image/services (3).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>payment</h4>
                <span>100% secure</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services (5).png" class="img1">
                    <img src="image/services (6).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>support</h4>
                <span>24/7 hours</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services (7).png" class="img1">
                    <img src="image/services (8).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>gift service</h4>
                <span>support gift service</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/service.png" class="img1">
                    <img src="image/service (1).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>returns</h4>
                <span>27/7 free return</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services.png" class="img1">
                    <img src="image/services (1).png" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>deliver</h4>
                <span>100% secure</span>
            </div>
        </div>
    </div>
</div>

<div class="categories">
    <div class="heading">
        <h1>categories features</h1>
        <img src="image/separator1.png">
    </div>
    <div class="box-container">
        <div class="box">
            <img src="image/categories1.jpg">
            <a href="menu.php" class="btn">chocolate</a>
        </div>
        <div class="box">
            <img src="image/categories2.jpg">
            <a href="menu.php" class="btn">red velvet</a>
        </div>
        <div class="box">
            <img src="image/categories3.jpg">
            <a href="menu.php" class="btn">vanilla</a>
        </div>
        <div class="box">
            <img src="image/categories4.jpg">
            <a href="menu.php" class="btn">strawberry</a>
        </div>
        <div class="box">
            <img src="image/categories5.jpg">
            <a href="menu.php" class="btn">carrot</a>
        </div>
        <div class="box">
            <img src="image/categories6.jpg">
            <a href="menu.php" class="btn">mocha</a>
        </div>
    </div>
</div>
<img src="image/menu-banner.webp" class="menu-banner">
<div class="cake-container">
    <div class="overlay"></div>
    <div class="detail">
        <h1>good things come to those <br> who bake </h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br> sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
        <a href="menu.php" class="btn">shop now</a>
    </div>
</div>
<div class="taste2">
    <div class="t-banner">
        <div class="overlay"></div>
            <div class="detail">
                <h1>find your taste of desserts</h1>
                <p>Treat them to a delicious treat and send them some Luck 'o the Irish too!</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
    <div class="box-container">
        <div class="box">
            <div class="box-overlay"></div>
            <img src="image/type7.jpg">
            <div class="box-details fadeIn-bottom">
                <h1>strawberry</h1>
                <p>find your taste of desserts</p>
                <a href="menu.php" class="btn">explore more</a>
            </div>
        </div>
        <div class="box">
            <div class="box-overlay"></div>
            <img src="image/type8.webp">
            <div class="box-details fadeIn-bottom">
                <h1>mango</h1>
                <p>find your taste of desserts</p>
                <a href="menu.php" class="btn">explore more</a>
            </div>
        </div>
        <div class="box">
            <div class="box-overlay"></div>
            <img src="image/type9.jpg">
            <div class="box-details fadeIn-bottom">
                <h1>tiramisu</h1>
                <p>find your taste of desserts</p>
                <a href="menu.php" class="btn">explore more</a>
            </div>
        </div>
        <div class="box">
            <div class="box-overlay"></div>
            <img src="image/type10.webp">
            <div class="box-details fadeIn-bottom">
                <h1>caramel</h1>
                <p>find your taste of desserts</p>
                <a href="menu.php" class="btn">explore more</a>
            </div>
        </div>
        <div class="box">
            <div class="box-overlay"></div>
            <img src="image/type11.jpg">
            <div class="box-details fadeIn-bottom">
                <h1>coffee</h1>
                <p>find your taste of desserts</p>
                <a href="menu.php" class="btn">explore more</a>
            </div>
        </div>
        <div class="box">
            <div class="box-overlay"></div>
            <img src="image/type13.jpeg">
            <div class="box-details fadeIn-bottom">
                <h1>cherry</h1>
                <p>find your taste of desserts</p>
                <a href="menu.php" class="btn">explore more</a>
            </div>
        </div>
    </div>
</div>


<div class="flavor">
    <div class="box-container">
        <img src="image/left-banner.png">
        <div class="detail">
            <h1>Hot Deal ! Sale up to <span> 20% off</span></h1>
            <p>expired</p>
            <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>
</div>

<div class="usage">
    <div class="heading">
        <h1>how it works</h1>
        <img src="image/separator1.png">
    </div>
    <div class="row">
        <div class="box-container">
            <div class="box">
                <img src="image/icon3.png">
                <div class="detail">
                    <h3>slice of cake</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div class="box">
                <img src="image/icon4.png">
                <div class="detail">
                    <h3>slice of cake</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div class="box">
                <img src="image/icon6.png">
                <div class="detail">
                    <h3>slice of cake</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div class="box">
                <img src="image/icon2.png">
                <div class="detail">
                    <h3>slice of cake</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div class="box">
                <img src="image/icon5.png">
                <div class="detail">
                    <h3>slice of cake</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
            </div>
            <div class="box">
                <img src="image/icon1.png">
                <div class="detail">
                    <h3>slice of cake</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="pride">
    <div class="detail">
        <h1>We Pride Ourselves On <br> Exceptional Tastes.</h1>
        <p>orem ipsum dolor sit amet, consectetur adipiscing elit, <br> sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        <a href="menu.php" class="btn">shop now</a>
    </div>
</div>


<?php include 'components/footer.php'; ?>












<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>










</body>
</html>