<?php
//include auth_session.php file on all user panel pages
require('db.php');
include("auth_session.php");
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
                        <a class="dropdown-item" href="#" id="add-new-account-nav-btn">Add new account</a>
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
            <div class="addUserAcct">
            <?php
            // When form submitted, insert values into the database.
            if (isset($_REQUEST['username'])) {
                // removes backslashes
                $username = stripslashes($_REQUEST['username']);
                //escapes special characters in a string
                $username = mysqli_real_escape_string($con, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);
                $create_datetime = date("Y-m-d H:i:s");
                $query = "INSERT into `users` (username, pass, created_at) VALUES ('$username', '" . md5($password) . "', '$create_datetime')";
                $result = mysqli_query($con, $query);
                if ($result) {
                    echo "<script>
                    alert('Registration Complete.');
                    window.location.href='dashboard.php';
                    </script>";
                }
                else {
                    echo "<script>
                    alert('Missing fields, please fill-up all.');
                    window.location.href='dashboard.php';
                    </script>";
                }
            }
            else {
            ?>
                <form class="form" action="" method="post">
                    <h1 class="login-title">Registration</h1>
                    <input type="text" class="login-input" name="username" placeholder="Username" required />
                    <input type="password" class="login-input" name="password" placeholder="Password" required>
                    <input type="submit" name="submit" value="Register" class="login-button">
                </form>
            <?php
            }
            ?>
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