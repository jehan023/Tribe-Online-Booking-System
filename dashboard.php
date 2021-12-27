<?php
//include auth_session.php file on all user panel pages
require('db.php');
include("auth_session.php");
include('process.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · Tribe Transport</title>

    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="css/dashboardstyle.css">
    <script type="text/javascript" src="js/dashboardscript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
    <div class="app-body">
        <aside class="app-sidebar">
            <div class="app-logo sticky-top">
                <img src="images/logo.png" width="50px" height="50px">
                <h5><strong>Tribe</strong> Dashboard</h5>
            </div>
            <div class="app-sidenav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="genReports-nav-btn">General Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" id="tripSchedules-nav-btn">Trip Schedules</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" id="rentInquiries-nav-btn">Rent Inquiries</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" id="busStatus-nav-btn">Bus Status</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" id="bookings-nav-btn">Bookings</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#releasesSubmenu" data-toggle="collapse"
                            aria-expanded="false">Product Releases</a>
                        <ul class="collapse list-unstyled" id="releasesSubmenu">
                            <li>
                                <a class="nav-link" href="#">Release A</a>
                            </li>
                            <li>
                                <a class="nav-link" href="#">Release B</a>
                            </li>
                            <li>
                                <a class="nav-link" href="#">Release C</a>
                            </li>
                            <li>
                                <a class="nav-link" href="#">Release D</a>
                            </li>
                            <li>
                                <a class="nav-link" href="#">Release E</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>

        <header class="app-header">
            <ul class="nav app-header-left-menu">
                <li class="nav-item">
                    <a class="nav-link">Welcome, <strong><?php echo $_SESSION['username']; ?></strong></a>
                </li>
            </ul>
            <ul class="nav app-header-right-menu">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" id="add-new-account-nav-btn" onclick="showDiv('dash-addUserAcct')">Add new account</a>
                        <div class="dropdown-divider">Access</div>
                        <a class="dropdown-item" href="#" id="edit-account-nav-btn">Edit account</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirm('Are You sure you want to logout?');">Log out</a>
                </li>
            </ul>
        </header>

        <main class="app-main">
            <div id="dash-addUserAcct" class="hidden">
                    <form method="POST" action="" id="register_form">
                        <h1>Add User Account</h1>
                        <div <?php if (isset($name_error)): ?> class="form_error" <?php endif ?> >
                        <input type="text" class="register-input" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                        <?php if (isset($name_error)): ?>           
                            <span><?php echo $name_error; ?></span>
                        <?php endif ?>
                        </div>
                        <div>
                            <input type="password" class="register-input" name="confirm-password" id="password" placeholder="Password" onkeyup='check();' required/>
                        </div>
                        <div>
                            <input type="password" class="register-input" name="password" id="confirm_password" placeholder="Confirm Password" onkeyup='check();' required/>
                            <span id='message'></span>
                        </div>
                        <div>
                            <button type="submit" name="register" id="reg_btn">Register</button>
            
                            <?php if (isset($pass_error)): ?>
                            <span id='message'><?php echo $pass_error; ?></span>
                            <?php endif ?>
                        </div>
                    </form>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
</body>
</html>