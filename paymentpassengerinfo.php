<?php
    session_start();
    require('db.php');
    $id = $_REQUEST['tripId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2 · Tribe Transport</title>
    
    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <script>
        //var reserve_id = localStorage.getItem("reserve_trip_id");
        //console.log('Reserve Trip ID: '+reserve_id);

        function checkemail(email,reemail) {
            if (document.getElementById(email).value == document.getElementById(reemail).value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = ' *email matched.';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = ' *email not match!';
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
            <label class="step-guide"><strong>Step 2:</strong> Passenger Information</label>
        </div>

        <div class="passenger-info-block">
            <form method="POST" class="pass-info-form-group" action="indexsearch_trip.php" autocomplete="on">
                <div class="pass-info-form-fields">
                    <div class="pass-info-form1">
                        <div class="data-form">
                            <label>First Name:</label>
                            <input name="reserve_pFname" type="text" id="PaymentPassengerInfoContent_txtFName" placeholder="First Name" autocomplete="given-name" required/>
                        </div>

                        <div class="data-form">
                            <label>Middle Name:</label>
                            <input name="reserve_pMname" type="text" id="PaymentPassengerInfoContent_txtMName" placeholder="Middle Name" autocomplete="additional-name"/>
                            
                        </div>

                        <div class="data-form">
                            <label>Last Name:</label>
                            <input name="reserve_pLname" type="text" id="PaymentPassengerInfoContent_txtLName" placeholder="Last Name" autocomplete="family-name" required/>
                        </div>

                        <div class="data-form">
                            <label>City</label>
                            <input name="reserve_pCity" type="text" id="PaymentPassengerInfoContent_txtCity" placeholder="City" autocomplete="address-level2" required/>
                        </div>
                    </div>

                    <div class="pass-info-form2">
                        <div class="data-form">
                            <label>Email:</label>
                            <input name="reserve_pEmail" type="email" id="PaymentPassengerInfoContent_txtEmail" placeholder="juandelacruz@gmail.com"
                            onkeyup="checkemail('PaymentPassengerInfoContent_txtEmail','PaymentPassengerInfoContent_txtReEmail');" autocomplete="email" required/>
                        </div>

                        <div class="data-form">
                            <label>Confirm Email:<span id="message" class="required-field"></span></label>
                            <input name="reserve_pReEmail" type="email" id="PaymentPassengerInfoContent_txtReEmail" placeholder="juandelacruz@gmail.com" 
                            onkeyup="checkemail('PaymentPassengerInfoContent_txtEmail','PaymentPassengerInfoContent_txtReEmail');" autocomplete="email" required/>
                        </div>

                        <div class="data-form">
                            <label>Mobile No.:</label>
                            <input name="reserve_pMobile" type="tel" id="PaymentPassengerInfoContent_txtMobileNo" class="numeric" placeholder="09xxxxxxxx" pattern="[0][9][0-9]{9}" 
                            autocomplete="tel" required/>
                        </div>

                        <div class="data-form">
                            <label>Full Address</label>
                            <input name="reserve_pFullAddress" type="text" id="PaymentPassengerInfoContent_txtFullAddress" placeholder="Full Address" autocomplete="street-address" required/>
                        </div>
                    </div>
                </div>
                
                <div class="form-footer-panel">
                    <a href="bookselection.php" class="booking-back-button"><i class="fas fa-long-arrow-alt-left"></i> Back to Step 1</a>
                    <input name="selected_ID" value="<?php echo $id ?>" style="display:none;">
                    <div class="pass-info-button">
                        <input type="submit" name="btnNext2" value="Next" id="btnNext2" class="btn-next" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Footer-->
    <footer>
        <div class="footer-panel">
            <div class="footer-list-about">
                <ul class="footer-list" data-preamble="About">
                    <li><strong>About</strong></li>
                    <li><a href="aboutus.html">Our Story</a></li>
                    <li><a href="https://www.google.com/maps/place/14+Bristol+St,+Novaliches,+Quezon+City,+1121+Metro+Manila/@14.7199402,121.0622425,18.25z/data=!4m5!3m4!1s0x3397b0897431ba59:0x54ab05f740403529!8m2!3d14.7200523!4d121.0633057" class="btn-terminal" target="_blank">Terminal Directory</a></li>
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