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
    <title>Step 3 · Tribe Transport</title>

    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script>
        var reserve_id = localStorage.getItem("reserve_trip_id");

        function selected(seat, id) {
            var els = document.getElementsByClassName("btn-seat seat-selected");

            Array.from(els).forEach((el) => {
                var red = el.id;
                document.getElementById(red).className = "btn-seat";
            });
            document.getElementById(seat).className = "btn-seat seat-selected";
            console.log('Clicked: '+seat);
            document.getElementById('selected_no').value = id;
        }
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
            <li><a href="index.php" class="active">Book Trip</a></li>
            <li><a href="rent.html">Rent</a></li>
            <li class="portal-opt"><a href="login.php">Tribe Portal</a></li>
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
            <div id="PaymentTicketInfoContent_divSummaryInfo" class="ticket-block">
                <div class='ticket-panel' id='divTicketInfo'>
                    <div class='ticket-details'>
                        <div class='route-panel'>
                            <h1><?php echo $_SESSION['origin']; ?></h1>
                            <i class='fas fa-caret-right'></i>
                            <h1><?php echo $_SESSION['destination']; ?></h1>
                        </div>

                        <div class='ticket-data'>
                            <label class='schedule-data' data-preamble=' Schedule'>ONE-WAY DEPARTURE</label>
                            <label class='time-data' data-preamble='Time: '><?php echo date('h:i A', strtotime($_SESSION['trip_time'])); ?></label>
                            <label class='date-data' data-preamble='Date: '><?php echo date("m/d/y", strtotime($_SESSION['date_depart'])); ?></label>
                            <label class='pass-data' data-preamble='No. of Passenger: '><?php echo $_SESSION['passenger_count']; ?></label>
                            <button type='button' class='btn-pick-seat' onclick="showModal('seats-modal-block')">Pick Seat</button>
                        </div>
                    </div>
                </div>
                <div class="form-footer-panel">
                    <a href="javascript:history.back()" class="booking-back-button"><i class="fas fa-long-arrow-alt-left"></i> Back to Step 2</a>
                </div>
            </div>
        </div>

        <div class="pick-seat-block" id="seats-modal-block">
            <div id="modalPickSeats" class="pick-seat-hide">
                <form method="post" class="modal-holder" action="indexsearch_trip.php">
                    <a href="#!" id="closeSeatPlan" class="close" data-dismiss="modal"><img src="images/btn-close.png"
                            onclick="hideModal('seats-modal-block')"></a>
                    <div class="route-panel">
                        <h1 id="PickSeatOrigin"><?php echo $_SESSION['origin']; ?></h1>
                        <i class="fas fa-caret-right"></i>
                        <h1 id="PickSeatDestination"><?php echo $_SESSION['destination']; ?></h1>
                    </div>
                    <div class="secondary-info-detail">
                        <label id="bus-class" class="bus-class" data-preamble="|">Regular Aircon</label>
                        <label id="bus-capacity" class="bus-capacity" data-preamble="|">44 Seaters</label>
                        <label id="spanTotalSeat" class="bus-seat-total"><?php echo $_SESSION['trip_seats']; ?> Seat Available</label>
                    </div>
                
                    <div id="divPlan">
                        <div class="front-seat">
                            <div id="divDriver">Driver</div>
                            <div class="divfiller"></div>
                            <div id="divConductor">Conductor</div>
                        </div>
                        <div id="divSeatPlan">
                            <?php
                                $trip_seats = mysqli_query($con,"SELECT * FROM trips WHERE trip_id='".$_SESSION['selected_tID']."'");
                                while($trip = mysqli_fetch_array($trip_seats))
                                {   
                                    $seatarray = array();

                                    foreach (explode(',',$trip['book_seats']) as $seatdata){
                                        $seatarray[] = $seatdata;
                                    };

                                    $sn = 44;
                                    for ($n = 1; $n <= $sn; $n++){
                                        if((in_array($n, $seatarray))){
                                            echo "<a href='#!' class='btn-seat seat-booked' id='seat-no-$n' onclick='selected(this.id, $n)' value=$n><span>$n</span></a>&nbsp;";
                                            if ($n == 44){
                                                //do nothing.
                                            } else if ($n % 4 == 0){
                                                echo "<br>";
                                            } else if ($n % 2 == 0){
                                                echo "<div class='spacing'></div>&nbsp;";
                                            }
                                        } else {
                                            echo "<a href='#!' class='btn-seat' id='seat-no-$n' onclick='selected(this.id, $n)' value=$n><span>$n</span></a>&nbsp;";
                                            if ($n == 44){
                                                //do nothing.
                                            } else if ($n % 4 == 0){
                                                echo "<br>";
                                            } else if ($n % 2 == 0){
                                                echo "<div class='spacing'></div>&nbsp;";
                                            }
                                        }
                                    }
                                }

                            ?>
                            <div><input type='tel' name='seat_selected' id='selected_no' style="display:none;"></div>

                            <div id="divSaveSeatAnnotation"></div>
                            <input type="submit" class="btn-save-pick-seat" id="btnSaveSeats" name="save_seat"/>
                        </div>
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
                </form>
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
                    <li><a href="#!" onclick="alert('Temporary Unavailable.');">Discounts/Policies</a></li>
                    <li><a href="#!" id="tncbtn">Terms and Conditions</a></li>
                </ul>
            </div>
            <div class="footer-list-support">
                <ul class="footer-list" data-preamble="Support">
                    <li><strong>Support</strong></li>
                    <li><a href="contactus.php">Contact Us</a></li>
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
            <li><a href="#!" id="ppbtn">Privacy policy</a></li>
        </ul>
        <div id="mySizeChartModal" class="ebcf_modal">
            <div class="ebcf_modal-content">
                <span class="ebcf_close">&times;</span>
                <div id="tnc-content">
                    <h1 class="tnc">Terms and Conditions</h1>
                    <p class="tnc">Last updated: January 08, 2022</p>
                    <p class="tnc">Please read these terms and conditions carefully before using Our Service.</p>
                    <h1 class="tnc">Interpretation and Definitions</h1>
                    <h2 class="tnc">Interpretation</h2>
                    <p class="tnc">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>
                    <h2 class="tnc">Definitions</h2>
                    <p class="tnc">For the purposes of these Terms and Conditions:</p>
                    <ul class="tnc">
                    <li class="tnc">
                    <p class="tnc"><strong class="tnc">Affiliate</strong> means an entity that controls, is controlled by or is under common control with a party, where "control" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Country</strong> refers to:  Philippines</p>
                    </li>
                    <li class="tnc">
                    <p class="tnc"><strong>Company</strong> (referred to as either "the Company", "We", "Us" or "Our" in this Agreement) refers to TRIBE Bookings.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Device</strong> means any device that can access the Service such as a computer, a cellphone or a digital tablet.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Service</strong> refers to the Website.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Terms and Conditions</strong> (also referred as "Terms") mean these Terms and Conditions that form the entire agreement between You and the Company regarding the use of the Service. This Terms and Conditions agreement has been created with the help of the <a href="https://www.privacypolicies.com/blog/sample-terms-conditions-template/" target="_blank">Terms and Conditions Template</a>.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Third-party Social Media Service</strong> means any services or content (including data, information, products or services) provided by a third-party that may be displayed, included or made available by the Service.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Website</strong> refers to TRIBE Bookings, accessible from [https://<CHANGE VALUE>.com](https://<CHANGE VALUE>.com)</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</p>
                    </li>
                    </ul>
                    <h1 class="tnc">Acknowledgment</h1>
                    <p class="tnc">These are the Terms and Conditions governing the use of this Service and the agreement that operates between You and the Company. These Terms and Conditions set out the rights and obligations of all users regarding the use of the Service.</p>
                    <p class="tnc">Your access to and use of the Service is conditioned on Your acceptance of and compliance with these Terms and Conditions. These Terms and Conditions apply to all visitors, users and others who access or use the Service.</p>
                    <p class="tnc">By accessing or using the Service You agree to be bound by these Terms and Conditions. If You disagree with any part of these Terms and Conditions then You may not access the Service.</p>
                    <p class="tnc">You represent that you are over the age of 18. The Company does not permit those under 18 to use the Service.</p>
                    <p class="tnc">Your access to and use of the Service is also conditioned on Your acceptance of and compliance with the Privacy Policy of the Company. Our Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your personal information when You use the Application or the Website and tells You about Your privacy rights and how the law protects You. Please read Our Privacy Policy carefully before using Our Service.</p>
                    <h1 class="tnc">Links to Other Websites</h1>
                    <p class="tnc">Our Service may contain links to third-party web sites or services that are not owned or controlled by the Company.</p>
                    <p class="tnc">The Company has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that the Company shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>
                    <p class="tnc">We strongly advise You to read the terms and conditions and privacy policies of any third-party web sites or services that You visit.</p>
                    <h1 class="tnc">Termination</h1>
                    <p class="tnc">We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if You breach these Terms and Conditions.</p>
                    <p class="tnc"> Upon termination, Your right to use the Service will cease immediately.</p>
                    <h1 class="tnc">Limitation of Liability</h1>
                    <p class="tnc">Notwithstanding any damages that You might incur, the entire liability of the Company and any of its suppliers under any provision of this Terms and Your exclusive remedy for all of the foregoing shall be limited to the amount actually paid by You through the Service or 100 USD if You haven't purchased anything through the Service.</p>
                    <p class="tnc">To the maximum extent permitted by applicable law, in no event shall the Company or its suppliers be liable for any special, incidental, indirect, or consequential damages whatsoever (including, but not limited to, damages for loss of profits, loss of data or other information, for business interruption, for personal injury, loss of privacy arising out of or in any way related to the use of or inability to use the Service, third-party software and/or third-party hardware used with the Service, or otherwise in connection with any provision of this Terms), even if the Company or any supplier has been advised of the possibility of such damages and even if the remedy fails of its essential purpose.</p>
                    <p class="tnc">Some states do not allow the exclusion of implied warranties or limitation of liability for incidental or consequential damages, which means that some of the above limitations may not apply. In these states, each party's liability will be limited to the greatest extent permitted by law.</p>
                    <h1 class="tnc">"AS IS" and "AS AVAILABLE" Disclaimer</h1>
                    <p class="tnc">The Service is provided to You "AS IS" and "AS AVAILABLE" and with all faults and defects without warranty of any kind. To the maximum extent permitted under applicable law, the Company, on its own behalf and on behalf of its Affiliates and its and their respective licensors and service providers, expressly disclaims all warranties, whether express, implied, statutory or otherwise, with respect to the Service, including all implied warranties of merchantability, fitness for a particular purpose, title and non-infringement, and warranties that may arise out of course of dealing, course of performance, usage or trade practice. Without limitation to the foregoing, the Company provides no warranty or undertaking, and makes no representation of any kind that the Service will meet Your requirements, achieve any intended results, be compatible or work with any other software, applications, systems or services, operate without interruption, meet any performance or reliability standards or be error free or that any errors or defects can or will be corrected.</p>
                    <p class="tnc">Without limiting the foregoing, neither the Company nor any of the company's provider makes any representation or warranty of any kind, express or implied: (i) as to the operation or availability of the Service, or the information, content, and materials or products included thereon; (ii) that the Service will be uninterrupted or error-free; (iii) as to the accuracy, reliability, or currency of any information or content provided through the Service; or (iv) that the Service, its servers, the content, or e-mails sent from or on behalf of the Company are free of viruses, scripts, trojan horses, worms, malware, timebombs or other harmful components.</p>
                    <p class="tnc">Some jurisdictions do not allow the exclusion of certain types of warranties or limitations on applicable statutory rights of a consumer, so some or all of the above exclusions and limitations may not apply to You. But in such a case the exclusions and limitations set forth in this section shall be applied to the greatest extent enforceable under applicable law.</p>
                    <h1 class="tnc">Governing Law</h1>
                    <p class="tnc">The laws of the Country, excluding its conflicts of law rules, shall govern this Terms and Your use of the Service. Your use of the Application may also be subject to other local, state, national, or international laws.</p>
                    <h1 class="tnc">Disputes Resolution</h1>
                    <p class="tnc">If You have any concern or dispute about the Service, You agree to first try to resolve the dispute informally by contacting the Company.</p>
                    <h1 class="tnc">Severability and Waiver</h1>
                    <h2 class="tnc">Severability</h2>
                    <p class="tnc">If any provision of these Terms is held to be unenforceable or invalid, such provision will be changed and interpreted to accomplish the objectives of such provision to the greatest extent possible under applicable law and the remaining provisions will continue in full force and effect.</p>
                    <h2 class="tnc">Waiver</h2>
                    <p class="tnc">Except as provided herein, the failure to exercise a right or to require performance of an obligation under these Terms shall not effect a party's ability to exercise such right or require such performance at any time thereafter nor shall the waiver of a breach constitute a waiver of any subsequent breach.</p>
                    <h1 class="tnc">Translation Interpretation</h1>
                    <p class="tnc">These Terms and Conditions may have been translated if We have made them available to You on our Service.
                    You agree that the original English text shall prevail in the case of a dispute.</p>
                    <h1 class="tnc">Changes to These Terms and Conditions</h1>
                    <p class="tnc">We reserve the right, at Our sole discretion, to modify or replace these Terms at any time. If a revision is material We will make reasonable efforts to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at Our sole discretion.</p>
                    <p class="tnc">By continuing to access or use Our Service after those revisions become effective, You agree to be bound by the revised terms. If You do not agree to the new terms, in whole or in part, please stop using the website and the Service.</p>
                    <h1 class="tnc">Contact Us</h1>
                    <p class="tnc">If you have any questions about these Terms and Conditions, You can contact us:</p>
                    <ul>
                        <li class="tnc">By email: bookings.tribe@gmail.com</li>
                    </ul>
                </div>
                <div id="pp-content">
                    <h1 class="tnc">Privacy Policy</h1>
                    <p class="tnc">Last updated: January 08, 2022</p>
                    <p class="tnc">This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p>
                    <p class="tnc">We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy. This Privacy Policy has been created with the help of the <a href="https://www.freeprivacypolicy.com/blog/sample-privacy-policy-template/" target="_blank">Privacy Policy Template</a>.</p>
                    <h1 class="tnc">Interpretation and Definitions</h1>
                    <h2 class="tnc">Interpretation</h2>
                    <p class="tnc">The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>
                    <h2 class="tnc">Definitions</h2>
                    <p class="tnc">For the purposes of this Privacy Policy:</p>
                    <ul class="tnc">
                    <li class="tnc">
                    <p class="tnc"><strong>Account</strong> means a unique account created for You to access our Service or parts of our Service.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Company</strong> (referred to as either &quot;the Company&quot;, &quot;We&quot;, &quot;Us&quot; or &quot;Our&quot; in this Agreement) refers to TRIBE Transport Coop., 14 Bristol St., North Fairview, Quezon City.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Cookies</strong> are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Country</strong> refers to:  Philippines</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Device</strong> means any device that can access the Service such as a computer, a cellphone or a digital tablet.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Personal Data</strong> is any information that relates to an identified or identifiable individual.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Service</strong> refers to the Website.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Service Provider</strong> means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Usage Data</strong> refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Website</strong> refers to TRIBE Bookings, accessible from <a href="samplesite" rel="external nofollow noopener" target="_blank">samplesite</a></p>
                    </li>
                    <li>
                    <p class="tnc"><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</p>
                    </li>
                    </ul>
                    <h1 class="tnc">Collecting and Using Your Personal Data</h1>
                    <h2 class="tnc">Types of Data Collected</h2>
                    <h3 class="tnc">Personal Data</h3>
                    <p class="tnc">While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</p>
                    <ul>
                    <li>
                    <p class="tnc">Email address</p>
                    </li>
                    <li>
                    <p class="tnc">First name and last name</p>
                    </li>
                    <li>
                    <p class="tnc">Phone number</p>
                    </li>
                    <li>
                    <p class="tnc">Usage Data</p>
                    </li>
                    </ul>
                    <h3 class="tnc">Usage Data</h3>
                    <p class="tnc">Usage Data is collected automatically when using the Service.</p>
                    <p class="tnc">Usage Data may include information such as Your Device's Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>
                    <p class="tnc">When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</p>
                    <p class="tnc">We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</p>
                    <h3 class="tnc">Tracking Technologies and Cookies</h3>
                    <p class="tnc">We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service. The technologies We use may include:</p>
                    <ul>
                    <li class="tnc"><strong>Cookies or Browser Cookies.</strong> A cookie is a small file placed on Your Device. You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service. Unless you have adjusted Your browser setting so that it will refuse Cookies, our Service may use Cookies.</li>
                    <li class="tnc"><strong>Flash Cookies.</strong> Certain features of our Service may use local stored objects (or Flash Cookies) to collect and store information about Your preferences or Your activity on our Service. Flash Cookies are not managed by the same browser settings as those used for Browser Cookies. For more information on how You can delete Flash Cookies, please read &quot;Where can I change the settings for disabling, or deleting local shared objects?&quot; available at <a href="https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_" rel="external nofollow noopener" target="_blank">https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_</a></li>
                    <li class="tnc"><strong>Web Beacons.</strong> Certain sections of our Service and our emails may contain small electronic files known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the Company, for example, to count users who have visited those pages or opened an email and for other related website statistics (for example, recording the popularity of a certain section and verifying system and server integrity).</li>
                    </ul>
                    <p class="tnc">Cookies can be &quot;Persistent&quot; or &quot;Session&quot; Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser. Learn more about cookies: <a href="https://www.freeprivacypolicy.com/blog/sample-privacy-policy-template/#Use_Of_Cookies_And_Tracking" target="_blank">Use of Cookies by Free Privacy Policy</a>.</p>
                    <p class="tnc">We use both Session and Persistent Cookies for the purposes set out below:</p>
                    <ul>
                    <li>
                    <p class="tnc"><strong>Necessary / Essential Cookies</strong></p>
                    <p class="tnc">Type: Session Cookies</p>
                    <p class="tnc">Administered by: Us</p>
                    <p class="tnc">Purpose: These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Cookies Policy / Notice Acceptance Cookies</strong></p>
                    <p class="tnc">Type: Persistent Cookies</p>
                    <p class="tnc">Administered by: Us</p>
                    <p class="tnc">Purpose: These Cookies identify if users have accepted the use of cookies on the Website.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>Functionality Cookies</strong></p>
                    <p class="tnc">Type: Persistent Cookies</p>
                    <p class="tnc">Administered by: Us</p>
                    <p class="tnc">Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.</p>
                    </li>
                    </ul>
                    <p class="tnc">For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy or the Cookies section of our Privacy Policy.</p>
                    <h2 class="tnc">Use of Your Personal Data</h2>
                    <p class="tnc">The Company may use Personal Data for the following purposes:</p>
                    <ul>
                    <li>
                    <p class="tnc"><strong>To provide and maintain our Service</strong>, including to monitor the usage of our Service.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>To manage Your Account:</strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>For the performance of a contract:</strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>To contact You:</strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application's push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>To provide You</strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>To manage Your requests:</strong> To attend and manage Your requests to Us.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>For business transfers:</strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</p>
                    </li>
                    <li>
                    <p class="tnc"><strong>For other purposes</strong>: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</p>
                    </li>
                    </ul>
                    <p class="tnc">We may share Your personal information in the following situations:</p>
                    <ul>
                    <li class="tnc"><strong>With Service Providers:</strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service,  to contact You.</li>
                    <li class="tnc"><strong>For business transfers:</strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</li>
                    <li class="tnc"><strong>With Affiliates:</strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</li>
                    <li class="tnc"><strong>With business partners:</strong> We may share Your information with Our business partners to offer You certain products, services or promotions.</li>
                    <li class="tnc"><strong>With other users:</strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</li>
                    <li class="tnc"><strong>With Your consent</strong>: We may disclose Your personal information for any other purpose with Your consent.</li>
                    </ul>
                    <h2 class="tnc">Retention of Your Personal Data</h2>
                    <p class="tnc">The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</p>
                    <p class="tnc">The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</p>
                    <h2 class="tnc">Transfer of Your Personal Data</h2>
                    <p class="tnc">Your information, including Personal Data, is processed at the Company's operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</p>
                    <p class="tnc">Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</p>
                    <p class="tnc">The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</p>
                    <h2 class="tnc">Disclosure of Your Personal Data</h2>
                    <h3 class="tnc">Business Transactions</h3>
                    <p class="tnc">If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</p>
                    <h3 class="tnc">Law enforcement</h3>
                    <p class="tnc">Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</p>
                    <h3 class="tnc">Other legal requirements</h3>
                    <p class="tnc">The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p>
                    <ul class="tnc">
                    <li class="tnc">Comply with a legal obligation</li>
                    <li class="tnc">Protect and defend the rights or property of the Company</li>
                    <li class="tnc">Prevent or investigate possible wrongdoing in connection with the Service</li>
                    <li class="tnc">Protect the personal safety of Users of the Service or the public</li>
                    <li class="tnc">Protect against legal liability</li>
                    </ul>
                    <h2 class="tnc">Security of Your Personal Data</h2>
                    <p class="tnc">The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</p>
                    <h1 class="tnc">Children's Privacy</h1>
                    <p class="tnc">Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</p>
                    <p class="tnc">If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent's consent before We collect and use that information.</p>
                    <h1 class="tnc">Links to Other Websites</h1>
                    <p class="tnc">Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party's site. We strongly advise You to review the Privacy Policy of every site You visit.</p>
                    <p class="tnc">We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>
                    <h1 class="tnc">Changes to this Privacy Policy</h1>
                    <p class="tnc">We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</p>
                    <p class="tnc">We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the &quot;Last updated&quot; date at the top of this Privacy Policy.</p>
                    <p class="tnc">You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>
                    <h1 class="tnc">Contact Us</h1>
                    <p class="tnc">If you have any questions about this Privacy Policy, You can contact us:</p>
                    <ul>
                        <li class="tnc">By email: bookings.tribe@gmail.com</li>
                    </ul>
                </div>
            </div>  
        </div>
    </footer>

    <script>
    // Get the modal
    var ebModal = document.getElementById('mySizeChartModal');
    var modalContent1 = document.getElementById('tnc-content');
    var modalContent2 = document.getElementById('pp-content');
    // Get the button that opens the modal
    var ebBtn1 = document.getElementById("tncbtn");
    var ebBtn2 = document.getElementById("ppbtn");
    // Get the <span> element that closes the modal
    var ebSpan = document.getElementsByClassName("ebcf_close")[0];
    // When the user clicks the button, open the modal 
    ebBtn1.onclick = function() {
        ebModal.style.display = "block";
        modalContent1.style.display = "block"
    }
    ebBtn2.onclick = function() {
        ebModal.style.display = "block";
        modalContent2.style.display = "block"
    }
    // When the user clicks on <span> (x), close the modal
    ebSpan.onclick = function() {
        ebModal.style.display = "none";
        modalContent1.style.display = "none"
        modalContent2.style.display = "none"
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == ebModal) {
            ebModal.style.display = "none";
            modalContent1.style.display = "none"
            modalContent2.style.display = "none"
        }
    }
    </script>
</body>

</html>