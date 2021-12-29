<?php
//include auth_session.php file on all user panel pages
require('db.php');
include("auth_session.php");
include('register_process.php');
include('addtrip_process.php');
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
                        <a class="nav-link" href="#general_reports" id="genReports-nav-btn" onclick="showDiv('dash-generalReports')">General Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#trip_schedules" id="tripSchedules-nav-btn" onclick="showDiv('dash-tripSchedules')">Trip Schedules</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#rent_inquiries" id="rentInquiries-nav-btn" onclick="showDiv('dash-rentInquiries')">Rent Inquiries</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#bus_status" id="busStatus-nav-btn" onclick="showDiv('dash-busStatus')">Bus Status</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#bookings" id="bookings-nav-btn" onclick="showDiv('dash-bookings')">Bookings</a>
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
                        <a class="dropdown-item" href="#add_new_user_acct" id="add-new-account-nav-btn" onclick="showDiv('dash-addUserAcct')">Add new account</a>
                        <div class="dropdown-divider">Access</div>
                        <a class="dropdown-item" href="#edit_acct" id="edit-account-nav-btn">Edit account</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirm('Are You sure you want to logout?');">Log out</a>
                </li>
            </ul>
        </header>

        <main class="app-main">
            <div id="dash-addUserAcct" class="unhidden">
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

            <div id="dash-generalReports" class="hidden"><h3>General Report</h3></div>

            <div id="dash-tripSchedules" class="hidden">
                <div class="trip-schedules-dataview">
                    <h3>Trip Schedules</h3>
                    <div class="trip-nav">
                        <form action="" id="search-trip-schedules">
                            <input type="text" placeholder="Search.." name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                        <div class="add_btn_div">
                            <button type="button" name="add-trip-btn" id="add_trip_btn" onclick="showTripForm()">+ New Trip</button>
                        </div>
                    </div>
                </div>

                <div id="insert-new-trip-schedule" class="new-trip-panel">
                    <form method="POST" action="" id="insert-trip-form">
                        <h1>Add New Trip</h1>
                        <div class="first-row">
                            <div class="orig-dest">
                                <label>Origin</label><br>
                                <input type="text" class="newTrip-input" id="insert-trip-origin" name="origin" onkeyup="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="orig-dest">
                                <label>Destination</label><br>
                                <input type="text" class="newTrip-input" id="insert-trip-destination" name="destination" onkeyup="this.value = this.value.toUpperCase();" required>
                            </div>
                        </div>
                        <div class="sec-row">
                            <div class="date-time">
                                <label>Date</label><br>
                                <input type="date" class="newTrip-input" id="insert-trip-date" name="date" required>
                            </div>
                            <div class="date-time">
                                <label>Time</label><br>
                                <input type="time" class="newTrip-input" id="insert-trip-time" name="time" required>
                            </div>
                        </div>
                        <div class="third-row">
                            <div class="bus-info">
                                <label>Bus Code</label><br>
                                <input type="text" class="newTrip-input" id="insert-trip-buscode" name="buscode" onkeyup="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="bus-info">
                                <label>Bus Plate Number</label><br>
                                <input type="text" class="newTrip-input" id="insert-trip-busplatenumber" name="plateno" pattern="[P][U][V][-][0-9]{4}" onkeyup="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="bus-info">
                                <label>Seats</label><br>
                                <input type="number" class="newTrip-input" id="insert-trip-seats" name="seats" value="" required>
                            </div>
                        </div>
                        <div class="trip-btn">
                            <button type="submit" name="insertTrip" id="insertTrip_btn">Add Trip</button>
                            <button type="reset" name="reset-btn" id="reset_btn">Reset</button>
                            <button type="button" name="cancel-btn" id="cancel_btn" onclick="hideTripForm()">Cancel</button>
                        </div>
                    </form>
                </div>

                <div class="trip-schedules">
                    <?php
                        $trip_table = mysqli_query($con,"SELECT * FROM trips");

                        echo "<table class='trip-schedules-table'>
                        <tr>
                            <th>Trip ID</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Bus Code</th>
                            <th>Bus Plate No.</th>
                            <th>Seats</th>
                        </tr>";

                        while($row = mysqli_fetch_array($trip_table))
                        {
                            echo "<tr>";
                            echo "<td>" . $row['trip_id'] . "</td>";
                            echo "<td>" . $row['trip_orig'] . "</td>";
                            echo "<td>" . $row['trip_dest'] . "</td>";
                            echo "<td>" . $row['trip_date'] . "</td>";
                            echo "<td>" . $row['trip_time'] . "</td>";
                            echo "<td>" . $row['bus_code'] . "</td>";
                            echo "<td>" . $row['bus_plateno'] . "</td>";
                            echo "<td>" . $row['seats'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    ?>

                </div>
            </div>

            <div id="dash-busStatus" class="hidden"><h3>Bus Status</h3></div>

            <div id="dash-rentInquiries" class="hidden"><h3>Rent Inquiries</h3></div>

            <div id="dash-bookings" class="hidden"><h3>Bookings</h3></div>

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