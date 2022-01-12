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
    <title>Ticket · Tribe Transport</title>
    
    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    
    <style>
body {
    font-family: "Montserrat", sans-serif;
    background-color: #f3f3f3;
}
.ticket-block {
    background: #fff;
    max-width: 500px;
    margin: 0 auto;
    height: fit-content;
    min-height: 100%;
    left: 0;
    right: 0;
    border: 1px solid black;
    padding: 5px;
    box-sizing: border-box;
}
.ticket-block > .ticket-panel {
  width: 100%;
}
.ticket-panel > .ticket-details > .ticket-header {
  display: flex;
  align-items: center;
}
.ticket-panel > .ticket-details > .ticket-header > img {
  margin-right: 10px;
  display: inline-block;
}
.ticket-panel > .ticket-details > .ticket-header > .company-info-header {
  display: inline-block;
}
.ticket-panel > .ticket-details > .ticket-header > .company-info-header > p {
  margin: 0px;
  font-size: 0.8rem;
}
.ticket-panel > .ticket-details > .ticket-line {
  background: black;
  height: 2px;
  margin-top: 5px;
}
.ticket-panel > .ticket-details > .trip-detail-content {
  margin: 0px 5px;
}
.ticket-panel > .ticket-details > .trip-detail-content > .route {
  width: 100% !important;
  align-items: center;
}
.ticket-panel > .ticket-details > .trip-detail-content > .route > h3 {
  font-size: 1.5rem;
  display: inline-block;
  margin: 5px auto;
}
.ticket-panel > .ticket-details > .trip-detail-content > .route > i {
  color: brown;
  margin: 0px 16px;
  font-size: 1.5rem;
}
.ticket-panel > .ticket-details > .trip-detail-content > .reservation-data-sched {
  font-size: 1.5rem;
}
.trip-detail-header {
    background-color: #D4D4D4;
}
.trip-detail-header > h3 {
    margin: 5px;
}
.passenger-detail-header {
    background-color: #D4D4D4;
}
.passenger-detail-header > h3 {
    margin: 5px;
}
.passenger-detail-content {
  margin: 0px 5px;
}
.fare-detail-header {
    background-color: #D4D4D4;
}
.fare-detail-header > h3 {
    margin: 5px;
}
.fare-detail-content {
  margin: 0px 5px;
}
.end-ticket-part {
    background-color: #D4D4D4;
    text-align: center;
    margin-top: 5px;
}
    </style>
</head>
<body>
    <!--Body Contents-->
    <div class="ticket-block">
        <div class='ticket-panel' id='divTicketInfo'>
            <div class='ticket-details'>
                <div class="ticket-header">
                    <img src="images/logo.png" width="80px" height="80px">
                    <div class="company-info-header">
                        <p><strong>TRIBE Transport Service</strong></p>
                        <p>14 Bristrol St., Brgy. North Fairview, Quezon City, Philippines</p>
                        <p>Tel: 8-932-5769/ 8-463-1410</p>
                        <p>CDA REG. NO. 9520-16016210</p>
                        <p>OTC ACCREDITATION NO. 2011-252</p>
                    </div>
                </div>
                <div class="ticket-line"></div>
                <div class="trip-detail-header"><h3>Trip Details (One-Way)</h3></div>
                <div class="trip-detail-content">
                    <div class="route">
                        <h3><?php echo $_SESSION['origin']; ?></h3>
                        <i class='fas fa-caret-right'></i>
                        <h3><?php echo $_SESSION['destination']; ?></h3>
                    </div>
                    <table border=0>
                        <tr>
                            <td class='reservation-data-sched'>Schedule: </td>
                            <td class='reservation-data-sched'><strong><?php echo date("m/d/y", strtotime($_SESSION['date_depart'])).' '.date('h:i A', strtotime($_SESSION['trip_time'])); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Trip ID: </td>
                            <td><strong><?php echo sprintf("%07d", $_SESSION['selected_tID']); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Seat No: </td>
                            <td><strong><?php echo $_SESSION['seat_reserve']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Bus Code: </td>
                            <td><strong><?php echo $_SESSION['bus_code']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Bus Plate No: </td>
                            <td><strong><?php echo $_SESSION['bus_plate']; ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class="ticket-line"></div>
                <div class="passenger-detail-header"><h3>Passenger Information</h3></div>
                <div class="passenger-detail-content">
                <table border=0>
                        <tr>
                            <td>Name:  </td>
                            <td><strong>
                            <?php 
                                if(isset($_SESSION['pMname'])){
                                    echo $_SESSION['pFname'].' '.$_SESSION['pMname'].' '.$_SESSION['pLname'];
                                } else {
                                    echo $_SESSION['pFname'].' '.$_SESSION['pLname'];
                                }
                            ?>
                            </strong></td>
                        </tr>
                        <tr>
                            <td>Gender: </td>
                            <td><strong><?php echo $_SESSION['pGender']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Contact No: </td>
                            <td><strong><?php echo $_SESSION['pMobile']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Email: </td>
                            <td><strong><?php echo $_SESSION['pEmail']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Address: </td>
                            <td><strong><?php echo $_SESSION['pCity'].', '.$_SESSION['pProvince']; ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class="ticket-line"></div>
                <div class="fare-detail-header"><h3>Reservation (<?php echo $_SESSION['reservation_time']; ?>)</h3></div>
                <div class="fare-detail-content">
                <table border=0>
                        <tr>
                            <td>Fare Amount: </td>
                            <td><strong>₱<?php echo $_SESSION['trip_fare']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Reservation Fee: </td>
                            <td><strong>₱50.00</strong></td>
                        </tr>
                        <tr>
                            <td>Total Amount to Pay: </td>
                            <td><strong>₱<?php echo sprintf('%.2f', $_SESSION['trip_fare']+50.00); ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class="ticket-line"></div>
                <div class="end-ticket-part">
                    <span class='end-ticket-data'>----This is your reservation ticket----</span><br>
                    <span class='end-ticket-data'>*Take a screenshot and bring on your schedule date for verification.</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>