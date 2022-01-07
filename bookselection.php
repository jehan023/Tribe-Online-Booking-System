<?php
    require('db.php');
    include('indexsearch_trip.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 1 · Tribe Transport</title>
    
    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <script>
        function saveTripID(id) {
            alert(id);
            if (confirm('Are you sure to reserve on this schedule?') == true) {
                localStorage.setItem("reserve_trip_id", id);
                window.location.href = "paymentpassengerinfo.php";
            }
        }
    </script>
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
            <li><a href="index.php">Book Trip</a></li>
            <li><a href="rent.html" class="active">Rent</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>

    <!--Body Contents-->
    <div class="contents">
        <div class="step-panel">
            <label class="step-guide"><strong>Step 1:</strong> Choose a departure schedule</label>
        </div>
        <!--Available Schedule Date Picker-->
        <div class="available-sched">
            <label class="available-sched-label">Available Schedule Date: <select class="dropdown-list-date-sched" id="availableDateSched"></select></label>
        </div>
        <div class="booking-details">
            <!--Route Panel-->
            <div class="route-panel">
                <h1 id="BookSelectionContent_lblOrigin"><?php echo $_SESSION['origin']; ?></h1>
                <i class="fas fa-caret-right"></i>
                
                <h1 id="BookSelectionContent_lblDestination"><?php echo $_SESSION['destination']; ?></h1>

            </div>
            <div class="secondary-info-detail">
                <label id="BookSelectionContent_txtDeparture" data-preamble="|"><?php echo $_SESSION['date_depart']; ?></label>
                <label id="BookSelectionContent_lblTravelType" data-preamble="|"><?php echo $_SESSION['trip_type']; ?></label>
                <label id="BookSelectionContent_lblPassengers">Passenger: <?php echo $_SESSION['passenger_count']; ?></label>
            </div>
        </div>
        <!--Table of Schedule on Selected Date-->
        <div class="schedule-block">
            <div id='divScheduleLoader'>
                <img src="images/ajax-spinner.gif" />
            </div>
            <div id="BookSelectionContent_divScheduleAnnotation"></div>
            <div id="divSchedule">
                <table class="table table-responsive tbl-booking-schedule">
                    <tbody>
                        <tr>
                            <th>Departure Time</th>
                            <th>Available Seats</th>
                            <th>Fare</th>
                            <th></th>
                        </tr>

                        <?php 
                            //$reserve_trip_id = '';

                            $trip_search = "SELECT * FROM trips WHERE trip_orig='".$_SESSION['origin']."' AND trip_dest='".$_SESSION['destination']."' AND trip_date='".$_SESSION['date_depart']."'
                            ORDER BY trip_time ";

                            $result_trip_search = mysqli_query($con, $trip_search);

                            if (mysqli_num_rows($result_trip_search) > 0) {
                                while($row = mysqli_fetch_array($result_trip_search))
                                {
                                    echo "<tr>";
                                    echo "<td>" . date('h:i A', strtotime($row['trip_time'])) . "</td>";
                                    echo "<td>" . $row['seats'] . "</td>";
                                    echo "<td>" . $row['fare'] . "</td>";
                                    if ($row['seats'] > 0){
                                        //echo "<td><button class='btn-reserveseat' onclick=\"location.href='paymentpassengerinfo.html'\">Reserve a Seat</button></td>";
                                        echo "<td><button class='btn-reserveseat' onclick=\"saveTripID(".$row['trip_id'].")\">Reserve a Seat</button></td>";
                                    } else {
                                        echo "<td>Full</td>";
                                    }
                                    echo "</tr>";   
                                }
                            } else {
                                echo "<tr><td>No data available.</td></tr>";
                            }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
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