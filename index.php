<?php
require('db.php');
include('indexsearch_trip.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home · Tribe Transport</title>
    
    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        //function for passenger count +/-
        var i = 1;
        function buttonPlus() {
            document.getElementById('labelPassengerCount').value = ++i;
        }
        function buttonMinus() {
            if (document.getElementById('labelPassengerCount').value > 1) {
                document.getElementById('labelPassengerCount').value = --i;
            }
        }
        //check for radio button selected then hide/show return date input
        function checkRadio(trip) {
            var ret = document.getElementById("return-selection");
            var line = document.getElementById("date-dash");
            var dep = document.getElementById("depart-selection");
            var icon = document.getElementById("datepicker-icon");
            var inpRet = document.getElementById("ReturningOn");
            if(trip == "one-way") {
                ret.style.display = "none";
                line.style.display = "none";
                dep.style.width = '88%';
                icon.style.width = '6%';
                inpRet.required = false;
            } else {
                ret.style.display = "inline-block";
                line.style.display = "inline-block";
                dep.style.width = '44%';
                icon.style.width = 'auto';
                inpRet.required = true;
            }
        }
        //Populate destination drop down list
        function configureDropDownLists(orig,dest) {
            var points = ['BAGUIO', 'BONTOC, MT. PROVINCE', 'FAIRVIEW, QC'];
            dest.options.length = 1;
            if(orig.value == "") {
                dest.options.length = 1;
            } else {
                for (loc = 0; loc < points.length; loc++) {
                    if(orig.value != points[loc]) {
                        createOption(dest, points[loc], points[loc]);
                    }
                }
            }
        }
        function createOption(dest, text, value) {
            var opt = document.createElement('option');
            opt.value = value;
            opt.text = text;
            dest.options.add(opt);
        }
    </script>
    <script type="text/javascript" src="js/script.js"></script>
    
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
            <li><a href="index.php" class="active">Book Trip</a></li>
            <li><a href="rent.html">Rent</a></li>
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
        <!--Image Slider-->
        <div class="wrap">
                <div id="dir-control-left" class="dir-control"><i class="fa fa-angle-left fa-5x" aria-hidden="true"></i></div>
            <div id="slider">
                <div class="slide slide1">
                    <div class="slide-content">
                        <span>Image One</span>
                    </div>
                </div>
                <div class="slide slide2">
                    <div class="slide-content">
                        <span>Image Two</span>
                    </div>
                </div>
                <div class="slide slide3">
                    <div class="slide-content">
                        <span>Image Three</span>
                    </div>
                </div>
            </div>
            <div id="dir-control-right" class="dir-control"><i class="fa fa-angle-right fa-5x" aria-hidden="true"></i></div>
        </div>

        

        <!--Booking Panel-->
        <div class="book-trip-panel">
            <form method="POST" action="indexsearch_trip.php" id="book-trip-search-form">
                <div class="trip">
                    <div class="radio-trip">
                        <input type="radio" name="radiobtn-trip-choice" id="radio-round-trip" value="Round Trip" onclick="checkRadio('round-trip')"><label for="radio-round-trip">Round-Trip</label>
                    </div>
                    <div class="radio-trip">
                        <input type="radio" name="radiobtn-trip-choice" id="radio-one-way" value="One-Way" onclick="checkRadio('one-way')" required><label for="radio-one-way">One-Way</label>
                    </div>
                </div>
                <div class="booking-panel">
                    <div class="orig-dropdown">
                        <select class="dropdown-list" name="origin" id="selOrigin" onchange="configureDropDownLists(this,document.getElementById('selDestination'))" required>
                            <option value="">--- Select Origin ---</option>
                            <option value="FAIRVIEW, QC">FAIRVIEW, QC</option>
                            <option value="BONTOC, MT. PROVINCE">BONTOC, MT. PROVINCE</option>
                        </select>
                    </div>
                    <div class="dest-dropdown">
                        <select class="dropdown-list" name="destination" id="selDestination" required>
                            <option value="">--- Select Destination ---</option>
                        </select>
                    </div>
                    <div class="booking-date-holder">
                        <div class="depart" id="depart-selection">
                            <input type="date" class="datepicker" name="DepartingOn" id="DepartingOn" placeholder="Depart" required/>
                        </div>
                        <div class="date-line" id="date-dash">-</div>
                        <div class="return" id="return-selection">
                            <input type="date" class="datepicker" name="ReturningOn" id="ReturningOn" placeholder="Return"/>
                        </div>
                        <i class="far fa-calendar-alt" id="datepicker-icon"></i>
                        <div class="booking-date-line"></div>
                    </div>
                    <div class="passenger">
                        <strong>Passengers:</strong>
                        
                        <!-- <button class="btn-count subtract-passenger er-alert" data-passenger_type="adult" id="btnAdultMinus" onclick="buttonMinus()">-</button> -->
                        <input type="number" class="txt-count" name="passenger-count" id="labelPassengerCount" placeholder='1' maxlength="3" size="3" required/>
                        <!-- <button class="btn-count add-passenger er-alert" data-passenger_type="adult" id="btnAdultPlus" onclick="buttonPlus()">+</button>  -->
                    </div>
                    <div class="button-panel">
                        <input type='submit' class="btn-book er-alert" value='Search' name='search_trip_btn' id='btnSearch'/>
                    </div>
            </form>

            </div>
            <!--Reminder Panel-->
            <div class="reminders-panel">
                <div class="reminders">
                    <p><strong>Reminders:</strong></p>
                    <ul class="reminder-notes">
                        <li>Limited trips are available online as of the moment.</li>
                        <li>We do not accept Smart Padala, nor any other offline methods of payment for tickets bought online.</li>
                        <li>Passengers availing student discounts, senior citizen discounts and PWD discounts must purchase their tickets from our terminal ticket booths.</li>
                    </ul>
                </div>
                <div class="manage-my-booking-button-holder">
                    <input type='button' class="manage-my-booking-button" data-toggle="modal" data-target="#modal-manage-bookings" onclick="Focus()" value="Manage My Bookings" id="btnManageBooking">
                </div>
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
