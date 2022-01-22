<?php
date_default_timezone_set("Asia/Manila");
session_start();
require('db.php');

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
	if(!empty($mname)){
		if ($mname != 'NA'){ $_SESSION['pMname'] = $mname; }
		else {
			$_SESSION['pMname'] = '';
			echo "<script>
			console.log('No Middle Name');
			</script>";
		}
	} else { $_SESSION['pMname'] = ''; }
	$_SESSION['pLname'] = $lname;
	$_SESSION['pGender'] = $gender;
	$_SESSION['pMobile'] = $contact;
	$_SESSION['pEmail'] = $email;
	$_SESSION['pCity'] = $city;
	$_SESSION['pProvince'] = $province;

    $triptime_search = "SELECT * FROM trips WHERE trip_id='".$_SESSION['selected_tID']."'";
    $triptime_result = mysqli_query($con, $triptime_search);
    while($row = mysqli_fetch_array($triptime_result)) {
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
	$_SESSION['payable'] = $searched_fare+50.00;

	echo "<script>
		window.location.href='paymentticketinfo.php';
		</script>";

}
//SELECTING SEAT TO RESERVE
if (isset($_POST['save_seat'])) {
	$selected_seat = $_POST['seat_selected'];
	//SELECTED SEAT TO RESERVE
	if(!empty($selected_seat)){
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
if(isset($_POST['ticket-confirmed'])){
	//FETCH TRIP DATA USING TRIP_ID
	$booking = mysqli_query($con,"SELECT * FROM trips WHERE trip_id='".$_SESSION['selected_tID']."'");
    while($row = mysqli_fetch_array($booking))
    {
        $available = $row['seats'];
        $booked = array($row['book_seats']);
    }

    $update_avail = $available - 1;
    $booked[] = $_SESSION['seat_reserve'];
    $imploded = implode(', ', $booked);
	//UPDATING AVAILABLE SEAT AND INSERT RESERVED SEAT USING TRIP_ID
    $trip_update = "UPDATE trips set seats = '$update_avail', book_seats = '$imploded'  WHERE  trip_id = '".$_SESSION['selected_tID']."'";

	//RESERVATION TIME CREATED TIMESTAMP
	$reservation_time = date("Y-m-d h:i:s");
	$_SESSION['reservation_time'] = $reservation_time;

	$passenger_insert = "INSERT INTO passengers (trip_id, seat_no, trip_date, trip_time, firstname, middlename, lastname, gender, email, contact, city, province, reservation, payable, paid)
		VALUES ('".$_SESSION['selected_tID']."', '".$_SESSION['seat_reserve']."', '".$_SESSION['date_depart']."', '".$_SESSION['trip_time']."', '".$_SESSION['pFname']."'
		, '".$_SESSION['pMname']."', '".$_SESSION['pLname']."', '".$_SESSION['pGender']."', '".$_SESSION['pEmail']."', '".$_SESSION['pMobile']."', '".$_SESSION['pCity']."'
		, '".$_SESSION['pProvince']."', '$reservation_time', '".$_SESSION['payable']."', '0')";

	$check_table = mysqli_query($con, "SHOW TABLES LIKE 'passengers'");
	if ($check_table->num_rows == 1) {
        if (mysqli_query($con, $passenger_insert)) {
			if (mysqli_query($con, $trip_update)) {
				echo "<script>
                    alert('TRIP RESERVATION CONFIRMED.');
                    </script>";
			}
			else {
				echo "<script>
					alert('ERROR: Could not able to execute $trip_update');
					</script>";
			}
        }
        else {
            echo "<script>
                alert('ERROR: Could not able to execute $passenger_insert');
                </script>";
        }
    }
}
?>