<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set("Asia/Manila");
session_start();
require('db.php');
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['search_trip_btn'])) {
	$trip_orig = $_POST['origin'];
	$trip_dest = $_POST['destination'];
	$trip_date = $_POST['DepartingOn'];
	$trip_type = $_POST['radiobtn-trip-choice'];
	$trip_passenger = $_POST['passenger-count'];

	//SELECTED ORIGIN - DESTINATION - DATE 
	$_SESSION['origin'] = $_POST['origin'];
	$_SESSION['destination'] = $_POST['destination'];
	$_SESSION['date_depart'] = $trip_date;
	$_SESSION['trip_type'] = $_POST['radiobtn-trip-choice'];
	$_SESSION['passenger_count'] = $_POST['passenger-count'];

	$sql_search = "SELECT * FROM trips WHERE trip_orig='$trip_orig' AND trip_dest='$trip_dest' AND trip_date='$trip_date'";

	$result_search = mysqli_query($con, $sql_search);

	if (mysqli_num_rows($result_search) > 0) {
		echo "<script>
			window.location.href='bookselection.php';
			</script>";
	} else {
		echo "<script>
			alert('No Trip Schedule found.');
			window.location.href='index.php';
			</script>";
	}
}
//PASSENGER INFORMATIONS
if (isset($_POST['btnNext2'])) {
	$fname = $_POST['reserve_pFname'];
	$mname = $_POST['reserve_pMname'];
	$lname = $_POST['reserve_pLname'];
	$gender = $_POST['reserve_pGender'];
	$city = $_POST['reserve_pCity'];
	$email = $_POST['reserve_pReEmail'];
	$contact = $_POST['reserve_pMobile'];
	$province = $_POST['reserve_pProvince'];

	$tID = $_POST['selected_ID'];
	//SELECTED TRIP_ID
	$_SESSION['selected_tID'] = $tID;
	//PASSENGER INFO
	$_SESSION['pFname'] = $fname;
	if (!empty($mname)) {
		if ($mname != 'NA') {
			$_SESSION['pMname'] = $mname;
		} else {
			$_SESSION['pMname'] = '';
			echo "<script>
			console.log('No Middle Name');
			</script>";
		}
	} else {
		$_SESSION['pMname'] = '';
	}
	$_SESSION['pLname'] = $lname;
	$_SESSION['pGender'] = $gender;
	$_SESSION['pMobile'] = $contact;
	$_SESSION['pEmail'] = $email;
	$_SESSION['pCity'] = $city;
	$_SESSION['pProvince'] = $province;

	$triptime_search = "SELECT * FROM trips WHERE trip_id='" . $_SESSION['selected_tID'] . "'";
	$triptime_result = mysqli_query($con, $triptime_search);
	while ($row = mysqli_fetch_array($triptime_result)) {
		$searched_time = $row['trip_time'];
		$searched_seat = $row['seats'];
		$searched_fare = $row['fare'];
		$searched_code = $row['bus_code'];
		$searched_plate = $row['bus_plateno'];
	}
	//TRIP TIME - SEATS AVAILABLE - FARE
	$_SESSION['trip_time'] = $searched_time;
	$_SESSION['trip_seats'] = $searched_seat;
	$_SESSION['trip_fare'] = $searched_fare;
	$_SESSION['bus_code'] = $searched_code;
	$_SESSION['bus_plate'] = $searched_plate;
	$_SESSION['payable'] = $searched_fare + 50.00;

	echo "<script>
		window.location.href='paymentticketinfo.php';
		</script>";
}
//SELECTING SEAT TO RESERVE
if (isset($_POST['save_seat'])) {
	$selected_seat = $_POST['seat_selected'];
	//SELECTED SEAT TO RESERVE
	if (!empty($selected_seat)) {
		$_SESSION['seat_reserve'] = $selected_seat;

		echo "<script>
		window.location.href='summaryreservation.php';
		</script>";
	} else {
		echo "<script>
		alert('Please select your seat.');
		window.location.href='paymentticketinfo.php';
		</script>";
	}
}
//CONFIRMATION OF RESERVATION - UPDATING TRIP_ID SEATS AVAILABLE AND INSERT BOOKED SEAT - INSERTING PASSENGER INFO ON PASSENGER TABLE
if (isset($_POST['ticket-confirmed'])) {
	//FETCH TRIP DATA USING TRIP_ID
	$booking = mysqli_query($con, "SELECT * FROM trips WHERE trip_id='" . $_SESSION['selected_tID'] . "'");
	while ($row = mysqli_fetch_array($booking)) {
		$available = $row['seats'];
		$booked = array($row['book_seats']);
	}

	$update_avail = $available - 1;
	$booked[] = $_SESSION['seat_reserve'];
	$imploded = implode(', ', $booked);
	//UPDATING AVAILABLE SEAT AND INSERT RESERVED SEAT USING TRIP_ID
	$trip_update = "UPDATE trips set seats = '$update_avail', book_seats = '$imploded'  WHERE  trip_id = '" . $_SESSION['selected_tID'] . "'";

	//RESERVATION TIME CREATED TIMESTAMP
	$reservation_time = date("Y-m-d h:i:s");
	$_SESSION['reservation_time'] = $reservation_time;
	$uuid = uniqid();
	$passenger_insert = "INSERT INTO passengers (id, trip_id, seat_no, trip_date, trip_time, firstname, middlename, lastname, gender, email, contact, city, province, reservation, payable, paid)
		VALUES ('$uuid', '" . $_SESSION['selected_tID'] . "', '" . $_SESSION['seat_reserve'] . "', '" . $_SESSION['date_depart'] . "', '" . $_SESSION['trip_time'] . "', '" . $_SESSION['pFname'] . "'
		, '" . $_SESSION['pMname'] . "', '" . $_SESSION['pLname'] . "', '" . $_SESSION['pGender'] . "', '" . $_SESSION['pEmail'] . "', '" . $_SESSION['pMobile'] . "', '" . $_SESSION['pCity'] . "'
		, '" . $_SESSION['pProvince'] . "', '$reservation_time', '" . $_SESSION['payable'] . "', '0')";

	$check_table = mysqli_query($con, "SHOW TABLES LIKE 'passengers'");
	if ($check_table->num_rows == 1) {
		if (mysqli_query($con, $passenger_insert)) {
			if (mysqli_query($con, $trip_update)) {
				/* creates object */
				$mail = new PHPMailer(true);
				$mailid = $_SESSION['pEmail'];
				$subject = "Tribe: Online Booking Reservation";

				$origin = $_SESSION["origin"];
				$destination = $_SESSION["destination"];
				$dateDepart = $_SESSION["date_depart"];
				$tripTime = $_SESSION["trip_time"];
				$selectedTID = $_SESSION["selected_tID"];
				$seatReserve = $_SESSION["seat_reserve"];
				$busCode = $_SESSION["bus_code"];
				$busPlate = $_SESSION["bus_plate"];
				$pFname = $_SESSION["pFname"];
				$pMname = isset($_SESSION["pMname"]) ? $_SESSION["pMname"] : "";
				$pLname = $_SESSION["pLname"];
				$pGender = $_SESSION["pGender"];
				$pMobile = $_SESSION["pMobile"];
				$pEmail = $_SESSION["pEmail"];
				$pCity = $_SESSION["pCity"];
				$pProvince = $_SESSION["pProvince"];
				$reservationTime = $_SESSION["reservation_time"];
				$tripFare = $_SESSION["trip_fare"];

				$message = '<!DOCTYPE html>
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
				
						.back-to-index-panel {
							margin: 0 auto;
							left: 0;
							right: 0;
							max-width: 500px;
							margin-top: 10px;
							padding: 5px;
							box-sizing: border-box;
							display: flex;
							align-items: center;
							justify-content: center;
						}
				
						.back-button-content {
							width: 100%;
						}
				
						.download-btn {
							text-decoration: none;
							color: white;
							font-weight: bold;
							font-family: "Montserrat", sans-serif;
							cursor: pointer;
						}
				
						.back-to-index-btn {
							display: block;
							width: 100%;
							height: 40px;
							background: brown;
							color: white;
							border-radius: 10px;
							font-weight: bold;
							font-family: "Montserrat", sans-serif;
						}
				
						.back-to-index-btn:hover {
							background-color: #0a3d52;
						}
				
						.ticket-block {
							background: #fff;
							max-width: 500px;
							margin: 0 auto;
							height: fit-content;
							left: 0;
							right: 0;
							border: 1px solid black;
							padding: 5px;
							box-sizing: border-box;
						}
				
						.ticket-block>.ticket-panel {
							width: 100%;
						}
				
						.ticket-panel>.ticket-details>.ticket-header {
							display: flex;
							align-items: center;
						}
				
						.ticket-panel>.ticket-details>.ticket-header>img {
							margin-right: 10px;
							display: inline-block;
						}
				
						.ticket-panel>.ticket-details>.ticket-header>.company-info-header {
							display: inline-block;
						}
				
						.ticket-panel>.ticket-details>.ticket-header>.company-info-header>p {
							margin: 0px;
							font-size: 0.8rem;
						}
				
						.ticket-panel>.ticket-details>.ticket-header>.company-info-header>.company-name {
							margin: 0px;
							font-size: 1rem;
						}
				
						.ticket-panel>.ticket-details>.ticket-line {
							background: black;
							height: 2px;
							margin-top: 5px;
						}
				
						.ticket-panel>.ticket-details>.trip-detail-content {
							margin: 0px 5px;
						}
				
						.ticket-panel>.ticket-details>.trip-detail-content>.route {
							width: 100% !important;
							align-items: center;
						}
				
						.ticket-panel>.ticket-details>.trip-detail-content>.route>h3 {
							font-size: 1.5rem;
							display: inline-block;
							margin: 5px auto;
						}
				
						.ticket-panel>.ticket-details>.trip-detail-content>.route>i {
							color: brown;
							margin: 0px 10px;
							font-size: 1.5rem;
						}
				
						.ticket-panel>.ticket-details>.trip-detail-content>.reservation-data-sched {
							font-size: 1.5rem;
						}
				
						.trip-detail-header {
							background-color: #D4D4D4;
						}
				
						.trip-detail-header>h3 {
							margin: 5px;
						}
				
						.passenger-detail-header {
							background-color: #D4D4D4;
						}
				
						.passenger-detail-header>h3 {
							margin: 5px;
						}
				
						.passenger-detail-content {
							margin: 0px 5px;
						}
				
						.fare-detail-header {
							background-color: #D4D4D4;
						}
				
						.fare-detail-header>h3 {
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
						<div class="ticket-panel" id="divTicketInfo">
						<div class="ticket-details">
							<img class="ticket-header" src="https://lh3.googleusercontent.com/pw/AJFCJaU8wQomCyBP8TixLO7XHr2o1rvP4puNr9OoX-fdkYsyYmNNvdZJQokIe7B5VhgNinTHMX7V1H_GWni3wmQsb2gCrK9tK6YH6-bFQTyGkBQULTYaLiS5SZQLwoY2fsI_JKmiGO46BLZiNNcuG7nIh_99=w1375-h268-s-no?authuser=0" height="80px" alt="ticket-header">
							<div class="ticket-line"></div>
							<div class="trip-detail-header">
							<h3>Trip Details (One-Way)</h3>
							</div>
							<div class="trip-detail-content">
							<div class="route">
								<h3>' . $origin . '</h3>
								<i> > </i>
								<h3>' . $destination . '</h3>
							</div>
							<table border=0>
								<tr>
								<td class="reservation-data-sched">Schedule: </td>
								<td class="reservation-data-sched"><strong>' . $dateDepart . ' ' . $tripTime . '</strong></td>
								</tr>
								<tr>
								<td>Trip ID: </td>
								<td><strong>' . $selectedTID . '</strong></td>
								</tr>
								<tr>
								<td>Seat No: </td>
								<td><strong>' . $seatReserve . '</strong></td>
								</tr>
								<tr>
								<td>Bus Code: </td>
								<td><strong>' . $busCode . '</strong></td>
								</tr>
								<tr>
								<td>Bus Plate No: </td>
								<td><strong>' . $busPlate . '</strong></td>
								</tr>
							</table>
							</div>
							<div class="ticket-line"></div>
							<div class="passenger-detail-header">
							<h3>Passenger Information</h3>
							</div>
							<div class="passenger-detail-content">
							<table border=0>
								<tr>
								<td>Name: </td>
								<td><strong>' . $pFname . ' ' . $pMname . ' ' . $pLname . '</strong></td>
								</tr>
								<tr>
								<td>Gender: </td>
								<td><strong>' . $pGender . '</strong></td>
								</tr>
								<tr>
								<td>Contact No: </td>
								<td><strong>' . $pMobile . '</strong></td>
								</tr>
								<tr>
								<td>Email: </td>
								<td><strong>' . $pEmail . '</strong></td>
								</tr>
								<tr>
								<td>Address: </td>
								<td><strong>' . $pCity . ', ' . $pProvince . '</strong></td>
								</tr>
							</table>
							</div>
							<div class="ticket-line"></div>
							<div class="fare-detail-header">
							<h3>Reservation (' . $reservationTime . ')</h3>
							</div>
							<div class="fare-detail-content">
							<table border=0>
								<tr>
								<td>Fare Amount: </td>
								<td><strong>₱ ' . $tripFare . '</strong></td>
								</tr>
								<tr>
								<td>Reservation Fee: </td>
								<td><strong>₱ 50.00</strong></td>
								</tr>
								<tr>
								<td>Total Amount to Pay: </td>
								<td><strong>₱ ' . number_format($tripFare + 50.00, 2) . '</strong></td>
								</tr>
							</table>
							</div>
							<div class="ticket-line"></div>
							<div class="end-ticket-part">
							<span class="end-ticket-data">----This is your reservation ticket----</span><br>
							<span class="end-ticket-data">Bring on your scheduled date for verification.</span>
							</div>
						</div>
						</div>
					</div>
				</body>
				</html>';

				try {
					$mail->IsSMTP();
					$mail->isHTML(true);
					$mail->SMTPDebug = 0;
					$mail->SMTPAuth = true;
					$mail->Username = "stejeetech2021@gmail.com";
					$mail->Password = "fovbvigzftnwxckp";
					$mail->SMTPSecure = "ssl";
					$mail->Host = "smtp.gmail.com";
					$mail->Port = '465';
					$mail->AddAddress($mailid);
					$mail->SetFrom('stejeetech2021@gmail.com', 'Tribe Transport');
					$mail->isHTML(true);
					$mail->Subject = $subject;
					$mail->Body = $message;

					if (!$mail->Send()) {
						//do nothing.
					}
				} catch (Exception $ex) {
					$msg = "
					" . $ex->errorMessage() . "
					";
				}
				echo "<script>
                    alert('TRIP RESERVATION CONFIRMED.');
                    </script>";
			} else {
				echo "<script>
					alert('ERROR: Could not able to execute $trip_update');
					</script>";
			}
		} else {
			echo "<script>
                alert('ERROR: Could not able to execute $passenger_insert');
                </script>";
		}
	}
}

if (isset($_POST['download-pdf'])) {
	echo "<script>window.location.href='generate-ticket.php';</script>";
}
