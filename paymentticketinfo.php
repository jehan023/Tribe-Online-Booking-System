<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 3 · Tribe Transport</title>

    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script>
        function hideModal(seatplan) {
            document.getElementById(seatplan).style.display = "none";
        }
        function showModal(seatplan) {
            document.getElementById(seatplan).style.display = "block";
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
            <label class="step-guide"><strong>Step 3:</strong> Choose your preferred seat</label>
        </div>
        <div id="PaymentTicketInfoContent_pnlTicketInfo">
            <input name="ctl00$PaymentTicketInfoContent$tbClientID" type="hidden"
                id="PaymentTicketInfoContent_tbClientID" style="display: none;" />
            <input name="ctl00$PaymentTicketInfoContent$tbScheduleBusTypeID" type="hidden"
                id="PaymentTicketInfoContent_tbScheduleBusTypeID" style="display: none;" value="346116" />
            <input name="ctl00$PaymentTicketInfoContent$tbWebId" type="hidden" id="PaymentTicketInfoContent_tbWebId"
                style="display: none;" value="1927" />
            <div id="PaymentTicketInfoContent_divSummaryInfo" class="ticket-block">
                <div class='ticket-panel' id='divTicketInfo'>
                    <div class='ticket-details'>
                        <div class='route-panel'>
                            <h1>ORIGIN</h1>
                            <i class='fas fa-caret-right'></i>
                            <h1>DESTINATION</h1>
                        </div>

                        <div class='ticket-data'>
                            <label class='schedule-data' data-preamble=' Schedule'>DEPARTURE</label>
                            <label class='time-data' data-preamble='Time: '>08:30 AM</label>
                            <label class='date-data' data-preamble='Date: '>01/05/2022</label>
                            <label class='pass-data' data-preamble='No. of Passengers: '>1</label>
                            <button type='button' class='btn-pick-seat' onclick="showModal('seats-modal-block')">Pick Seats</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pick-seat-block" id="seats-modal-block">
            <div id="modalPickSeats" class="pick-seat-hide">
                <div class="modal-holder">
                    <a href="#!" id="closeSeatPlan" class="close" data-dismiss="modal"><img src="images/btn-close.png"
                            onclick="hideModal('seats-modal-block')"></a>
                    <div class="route-panel">
                        <h1 id="PickSeatOrigin">ORIGIN</h1>
                        <i class="fas fa-caret-right"></i>
                        <h1 id="PickSeatDestination">DESTINATION</h1>
                    </div>
                    <div class="secondary-info-detail">
                        <label id="bus-class" class="bus-class" data-preamble="|">Regular Aircon</label>
                        <label id="bus-capacity" class="bus-capacity" data-preamble="|">20 Seaters</label>
                        <label id="spanTotalSeat" class="bus-seat-total">1 seat/s</label>
                    </div>
                    <div id="divPlan">
                        <div class="front-seat">
                            <div id="divDriver">Driver</div>
                            <div class="divfiller"></div>
                            <div id="divConductor">Conductor</div>
                        </div>
                        <div id="divSeatPlan">
                            <a href="#!" class="btn-seat" data-seat-no="1"><span>1</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="2"><span>2</span></a>&nbsp;
                            <div class="spacing"></div>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="3"><span>3</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="4"><span>4</span></a>&nbsp;
                            <br>
                            <a href="#!" class="btn-seat" data-seat-no="5"><span>5</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="6"><span>6</span></a>&nbsp;
                            <div class="spacing"></div>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="7"><span>7</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="8"><span>8</span></a>&nbsp;
                            <br>
                            <a href="#!" class="btn-seat" data-seat-no="9"><span>9</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="10"><span>10</span></a>&nbsp;
                            <div class="spacing"></div>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="11"><span>11</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="12"><span>12</span></a>&nbsp;
                            <br>
                            <a href="#!" class="btn-seat" data-seat-no="13"><span>13</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="14"><span>14</span></a>&nbsp;
                            <div class="spacing"></div>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="15"><span>15</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="16"><span>16</span></a>&nbsp;
                            <br>
                            <a href="#!" class="btn-seat" data-seat-no="17"><span>17</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="18"><span>18</span></a>&nbsp;
                            <div class="spacing"></div>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="19"><span>19</span></a>&nbsp;
                            <a href="#!" class="btn-seat" data-seat-no="20"><span>20</span></a>&nbsp;

                            <div id="divSaveSeatAnnotation"></div>
                            <button type="button" class="btn-save-pick-seat" id="btnSaveSeats"
                                data-trip-count="test">Save</button>
                        </div>
                        <div class="legend-panel">
                            <div class="legend-item">
                                <span class="legend-square"></span>
                                <label>Booked seats</label>
                            </div>
                            <div class="legend-item">
                                <span class="legend-square"></span>
                                <label>Selected seats</label>
                            </div>
                            <div class="legend-item">
                                <span class="legend-square"></span>
                                <label>Available seats</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pick-seat-footer-block">
                <div class="form-footer-panel">
                    <a href="paymentpassengerinfo.html" class="booking-back-button" id="btnBack"><i
                            class="fas fa-long-arrow-alt-left"></i>Back to Step 2</a>

                    <div class="pass-info-button">
                        <input type="submit" name="ctl00$PaymentTicketInfoContent$btnShowSummary" value="Next"
                            id="PaymentTicketInfoContent_btnShowSummary" class="btn-pick" />
                    </div>
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
                <li><a href="https://web.facebook.com/TribeBusRental" target="_blank" class="social-fb"><i
                            class="fab fa-facebook-f"></i></a></li>
                <li><a href="mailto:bookings.tribes@gmail.com" target="_blank" class="social-gmail"><i
                            class="fab fa-google"></i></a></li>
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