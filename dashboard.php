<?php
require('db.php');
include("auth_session.php");
include('register_process.php');
include('addtrip_process.php');
$panel = $_REQUEST['view_panel'];

if(isset($_REQUEST['confirmation'])){
    updatePassengerStatus();
}
        
function updatePassengerStatus(){
    require('db.php');
    $passengerId = $_REQUEST['passengerId'];
    $passenger_update = "UPDATE passengers set paid = '1'  WHERE  id = '".$passengerId."'";

    if (mysqli_query($con, $passenger_update)) {
        echo "<script>
            console.log('Passenger ID: ".$passengerId."');
            alert('Passenger ID: ".$passengerId." confirmed.');
            window.location.href='dashboard.php?view_panel=reservation';
            </script>";
    }
    else {
        echo "<script>
            alert('ERROR: Could not able to execute $passenger_update');
            </script>";
    }
}
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

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/dashboardstyle.css">
    <script type="text/javascript" src="js/dashboardscript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
    <div class="app-body">
        <aside class="app-sidebar">
            <div class="app-logo sticky-top">
                <img src="images/logo.png" width="50px" height="50px">
                <h5><strong>Tribe</strong> Dashboard</h5>
            </div>
<!------- SIDE NAVIGATION ITEMS -------------->
            <div class="app-sidenav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?view_panel=generalReports" id="genReports-nav-btn" onclick="showDiv('generalReports')">General Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?view_panel=tripSchedules" id="tripSchedules-nav-btn" onclick="showDiv('tripSchedules')">Trip Schedules</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?view_panel=messageInquiries" id="rentInquiries-nav-btn" onclick="showDiv('messageInquiries')">Inquiries</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?view_panel=busStatus" id="busStatus-nav-btn" onclick="showDiv('busStatus')">Bus Status</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php?view_panel=reservation" id="bookings-nav-btn" onclick="showDiv('reservation')">Reservations</a>
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
                        <a class="dropdown-item" href="dashboard.php?view_panel=addUserAcct" id="add-new-account-nav-btn" onclick="showDiv('addUserAcct')">Add new account</a>
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
<!------- DASH - ADD USER ACCOUNT PANEL -------------->
            <div id="addUserAcct" class="hidden">
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

<!------- DASH - GENERAL REPORTS PANEL -------------->
            <div id="generalReports" class="hidden"><h3>General Report</h3></div>

<!------- DASH - TRIP SCHEDULES PANEL -------------->
            <div id="tripSchedules" class="hidden">
                <div class="trip-schedules-dataview">
                    <h3>Trip Schedules</h3>
                    <div class="trip-nav">
                        <form action="" class="search-trip-schedules">
                            <input type="text" placeholder="Search..." name="search">
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
                                <!-- <input type="text" class="newTrip-input" id="insert-trip-origin" name="origin" onkeyup="this.value = this.value.toUpperCase();" required> -->
                                <select class="newTrip-input" id="insert-trip-origin" name="origin" onchange="configureDropDownLists(this,document.getElementById('insert-trip-destination'))" required>
                                    <option value="">--- Select Origin ---</option>
                                    <option value="FAIRVIEW, QC">FAIRVIEW, QC</option>
                                    <option value="BONTOC, MT. PROVINCE">BONTOC, MT. PROVINCE</option>
                                </select>
                            </div>
                            <div class="orig-dest">
                                <label>Destination</label><br>
                                <!-- <input type="text" class="newTrip-input" id="insert-trip-destination" name="destination" onkeyup="this.value = this.value.toUpperCase();" required> -->
                                <select class="newTrip-input" id="insert-trip-destination" name="destination" required>
                                    <option value="">--- Select Destination ---</option>
                                </select>
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
                            <div class="date-time">
                                <label>Fare</label><br>
                                <input type="number" class="newTrip-input" id="insert-trip-fare" name="fare" placeholder="0.00" step="0.01" onchange="setTwoNumberDecimal(this)" required>
                            </div>
                        </div>
                        <div class="third-row">
                            <div class="bus-info">
                                <label>Bus Code</label><br>
                                <input type="text" class="newTrip-input" id="insert-trip-buscode" name="buscode" onkeyup="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="bus-info">
                                <label>Bus Plate Number</label><br>
                                <input type="text" class="newTrip-input" id="insert-trip-busplatenumber" name="plateno" placeholder="ABC-1234" pattern="[A-Z][A-Z][A-Z][-][0-9]{4}" onkeyup="this.value = this.value.toUpperCase();" required>
                            </div>
                            <div class="bus-info">
                                <label>Seats Capacity</label><br>
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
                            <th>Fare</th>
                            <th>Bus Code</th>
                            <th>Bus Plate No.</th>
                            <th>Avail Seats</th>
                        </tr>";
                        if (!empty($trip_table)) {
                            while($row = mysqli_fetch_array($trip_table))
                            {
                                echo "<tr>";
                                echo "<td>" . $row['trip_id'] . "</td>";
                                echo "<td>" . $row['trip_orig'] . "</td>";
                                echo "<td>" . $row['trip_dest'] . "</td>";
                                echo "<td>" . $row['trip_date'] . "</td>";
                                echo "<td>" . $row['trip_time'] . "</td>";
                                echo "<td>" . $row['fare'] . "</td>";
                                echo "<td>" . $row['bus_code'] . "</td>";
                                echo "<td>" . $row['bus_plateno'] . "</td>";
                                echo "<td>" . $row['seats'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'><center>No Trip Schedules</center></td></tr>";
                        }
                        echo "</table>";
                    ?>

                </div>
            </div>

            <div id="busStatus" class="hidden"><h3>Bus Status</h3></div>

<!------- DASH - RENT/MESSAGE/INQUIRIES PANEL -------------->
            <div id="messageInquiries" class="hidden">
                <h3>Message - Inquiries</h3>
                <div class="inquiries-data-options">
                    <form method="post" action="">
                        <button type="submit" name="inquiries-all-btn" id="all_btn" onclick="">View All</button>
                        <button type="submit" name="inquiries-unread-btn" id="unread_btn" onclick="">Show Unreads</button>
                    </form>
                </div>
                <?php
                    $inquiries_table = mysqli_query($con,"SELECT * FROM inquiries");
                    if(isset($_POST['inquiries-all-btn'])){
                        $inquiries_table = mysqli_query($con,"SELECT * FROM inquiries");
                    } 
                    if(isset($_POST['inquiries-unread-btn'])){
                        $inquiries_table = mysqli_query($con,"SELECT * FROM inquiries WHERE responded='0'");
                    }

                    if (mysqli_num_rows($inquiries_table) > 0) {
                        while($row = mysqli_fetch_array($inquiries_table))
                        {
                            echo "<div class='inquiry-data-holder'>
                                <div class='inquiry-data-panel'>";
                                if($row['responded'] == 1){
                                    echo "<div class='inbox-icon-container' style='background: green;'><i class='fas fa-user-check fa-3x' id='inbox-icon' aria-hidden='true'></i></div>";
                                } else {
                                    echo "<div class='inbox-icon-container' style='background: red;'><i class='fas fa-user fa-3x' id='inbox-icon' aria-hidden='true'></i></div>";
                                }
                                    echo "<table class='inquiry-data-content'>
                                        <tr>
                                            <td class='inquiry-sender'>".$row['sender']."</td>
                                            <td class='inquiry-email'>".$row['email']."</td>
                                            <td class='inquiry-timestamp'>".date('Y/m/d h:i A', strtotime($row['sent_time']))."</td>
                                        </tr>
                                        <tr>
                                            <td class='inquiry-company' colspan='3'>".$row['company']."</td>
                                        </tr>
                                        <tr>
                                            <td class='inquiry-message' colspan='3'>".$row['txt_mssg']."</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='inbox-data-action'>
                                    <button class='inquiry-reply-btn' onclick=\"sendMail('".$row['email']."')\">Reply</button>
                                    <button class='inquiry-delete-btn'>Delete</button>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<div><center><strong>Inbox Empty.</strong></center></div>";
                    }
                ?>
                
            </div>

<!------- DASH - RESERVATIONS PANEL -------------->
            <div id="reservation" class="hidden">
                <h3>Reservation</h3>

                <div class="passenger-data-options">
                    <form method="post" action="">
                        <button type="submit" name="passenger-all-btn" id="all_btn" onclick="showPassengerTable()">View All</button>
                        <button type="button" name="passenger-search-btn" id="search_btn" onclick="showPassengerSearchForm()">Search Passenger</button>
                    </form>
                </div>
                <form method="post" class="passenger-search-form" id="passenger-search-form" style="display:none">
                    <h2>Search Passenger</h2>
                    <div class="pass-first-row">
                        <div class="pass-first-row-input">
                            <label>Trip ID</label><br>
                            <input type="text" class="passenger-input-search" name="trip_id-search" id="trip_id-search" placeholder="Trip ID" required/>
                        </div>
                        <div class="pass-first-row-input">
                            <label>Trip Date Departure</label><br>
                            <input type="date" class="passenger-input-search" name="trip_date-search" id="trip_date-search" placeholder="Trip Date" required/>
                        </div>
                    </div>
                    <div class="pass-second-row">
                        <div class="pass-second-row-input">
                            <label>Seat Number</label><br>
                            <input type="number" class="passenger-input-search" name="seat_no-search" id="seat_no-search" placeholder="Seat#" required/>
                        </div>
                        <div class="pass-second-row-input">
                            <label>Lastname</label><br>
                            <input type="text" class="passenger-input-search" name="lastname-search" id="lastname-search" placeholder="Lastname" onkeyup="this.value = this.value.toUpperCase();" required/>
                        </div>
                    </div>
                    <div class="passenger-search-form-btn">
                        <button type="submit" name="searchPassenger" id="searchPassenger_btn">Search</button>
                    </div>
                </form>
                
                <?php
                    $reservation_table = mysqli_query($con,"SELECT * FROM passengers");
                    echo "<table class='trip-schedules-table' id='passenger-table'>
                    <tr>
                        <th>Passenger ID</th>
                        <th>Trip ID</th>
                        <th>Seat No.</th>
                        <th>Trip Schedule</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>RESV Time</th>
                        <th>Payable</th>
                        <th>Status</th>
                    </tr>";

                    if (isset($_POST['searchPassenger'])){
                        echo "<script>document.getElementById('passenger-table').style.display = 'block';</script>";

                        $search_inputs_passenger = "SELECT * FROM passengers WHERE trip_id='".$_POST['trip_id-search']."' AND trip_date='".$_POST['trip_date-search']."'
                        AND seat_no='".$_POST['seat_no-search']."' AND lastname LIKE '".$_POST['lastname-search']."%'";
                        $reservation_table = mysqli_query($con,$search_inputs_passenger);
                        
                    } if (isset($_POST['passenger-all-btn'])){
                        $reservation_table = mysqli_query($con,"SELECT * FROM passengers");
                    }

                    if (mysqli_num_rows($reservation_table) > 0) {
                        while($row = mysqli_fetch_array($reservation_table))
                        {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['trip_id'] . "</td>";
                            echo "<td>" . $row['seat_no'] . "</td>";
                            echo "<td>" . date("m/d/y", strtotime($row['trip_date'])).' '.date('h:iA', strtotime($row['trip_time'])) . "</td>";
                            echo "<td>" . $row['lastname'].', '.$row['firstname'].' '.$row['middlename'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['contact'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['city'].', '.$row['province'] . "</td>";
                            echo "<td>" . date('m/d/y h:iA', strtotime($row['reservation'])) . "</td>";
                            echo "<td>" . $row['payable'] . "</td>";
                            if ($row['paid'] == 0){
                                echo "<td id='passenger-status-pending'>";
                                echo "<button id='passenger-status-btn' onclick=\"confirmationPassenger('".$row['id']."')\">PENDING</button>";
                                echo "</td>";
                            } else {
                                echo "<td class='passenger-status-confirmed'>CONFIRMED</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'><center>No Passenger/s Found.</center></td></tr>";
                    }
                    echo "</table>";
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

    <script>
        function sendMail(receiver) {
            var link = "mailto:" + receiver
                    + "?subject=" + encodeURIComponent("Tribe Transport Reply")
                    + "&body=" + encodeURIComponent('THIS IS TRIBE REPLY.')
            ;
            
            window.location.href = link;
        }
    </script>
    <?php 
        echo "<script>
        document.getElementById('$panel').className = 'unhidden';
        </script>";
    ?>
</body>
</html>