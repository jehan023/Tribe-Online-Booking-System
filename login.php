<?php
    require('db.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · Tribe Transport</title>
    
    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/loginstyle.css">
        
</head>
<body>
    <!--Header-->
    <nav>
        <input id="nav-toggle" type="checkbox">
        <div class="logo">
            <img src="images/logo.png">
            <strong>Tribe</strong> Transport
        </div>
        <ul class="links">
            <li><a href="index.html">Book Trip</a></li>
            <li><a href="rent.html">Rent</a></li>
            <li><a href="login.php" class="active">Login</a></li>
        </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>

    <!--Body Contents-->
    <div class="contents">
        <!--LOGIN PHP codes-->
        <?php
            // When form submitted, check and create user session.
            if (isset($_POST['username_input']) && isset($_POST['password_input'])) {
                $username = stripslashes($_REQUEST['username_input']);    // removes backslashes
                $username = mysqli_real_escape_string($con, $username);
                $password = stripslashes($_REQUEST['password_input']);
                $password = mysqli_real_escape_string($con, $password);
                
                // Check user is exist in the database
                $query    = "SELECT * FROM users WHERE username='$username' AND pass='$password'";
                $result = mysqli_query($con, $query) or die(mysqli_connect_error());
                $rows = mysqli_num_rows($result);
                if ($rows == 1) {
                    $_SESSION['username'] = $username;
                    // Redirect to user dashboard page
                    //header("Location: dashboard.php");
                    echo("<script>location.href = 'dashboard.php';</script>");
                } else {
                    echo "<script>
                    alert('Incorrect Username/password.');
                    window.location.href='login.php';
                    </script>";
                }
            } else {
        ?>
        <!--Login Form-->
        <div class="container">
            <div class="screen">
                <div class="screen__content">
                    <form class="login" method="POST">
                        <div class="login-panel-logo">
                            <img src="images/logo.png" alt="logo">
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" name="username_input" class="login__input" placeholder="Username" required>
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" name="password_input" class="login__input" placeholder="Password" required>
                        </div>

                        <button class="button login__submit">
                            <span class="button__text">Member Log In</span>
                            <i class="button__icon fas fa-chevron-right"></i>
                        </button>				
                    </form>
                </div>
                <div class="screen__background">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>		
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                </div>		
            </div>
        </div>
        <?php } ?>
    </div>

    <!--Footer-->
    <footer>
        <div class="footer-panel">
            <div class="footer-list-about">
                <ul class="footer-list" data-preamble="About">
                    <li><strong>About</strong></li>
                    <li><a href="aboutus.html">Our Story</a></li>
                    <li><a href="#!" class="btn-terminal" data-toggle="modal" data-target="#terminal-directory-modal">Terminal Directory</a></li>
                </ul>
            </div>
            <div class="footer-list-guidelines">
                <ul class="footer-list" data-preamble="Guidelines">
                    <li><strong>Guidelines</strong></li>
                    <li><a href="/Discounts-Policies.html">Discounts/Policies</a></li>
                    <li><a href="#!" class="btn-terminal" data-toggle="modal" data-target="#terms">Terms and Conditions</a></li>
                </ul>
            </div>
            <div class="footer-list-support">
                <ul class="footer-list" data-preamble="Support">
                    <li><strong>Support</strong></li>
                    <li><a href="contactus.html">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="social-media-panel">
            <ul class="social-media-list">
                <li><a href="https://web.facebook.com/TribeBusRental" target="_blank" class="social-fb"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="mailto:bookings.tribes@gmail.com" target="_blank" class="social-gmail"><i class="fab fa-google"></i></a></li>
            </ul>
        </div>
        <p class="company-address">14 Bristrol St., Brgy. North Fairview, Quezon City, Philippines</p>
        <ul class="copyright">
            <li>&copy; Tribe Transport Services</li>
            <li><a href="#!" data-toggle="modal" data-target="#privacy-policy-popup">Privacy policy</a></li>
        </ul>
    </footer>
    
</body>
</html>
