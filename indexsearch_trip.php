<?php
session_start();
require('db.php');

if (isset($_POST['search_trip_btn'])) {
	$trip_orig = $_POST['origin'];
	$trip_dest = $_POST['destination'];
	$trip_date = $_POST['DepartingOn'];
	$trip_type = $_POST['radiobtn-trip-choice'];
	$trip_passenger = $_POST['passenger-count'];

	$_SESSION['origin'] = $_POST['origin'];
	$_SESSION['destination'] = $_POST['destination'];
	$_SESSION['date_depart'] = $trip_date;
	$_SESSION['trip_type'] = $_POST['radiobtn-trip-choice'];
	$_SESSION['passenger_count'] = $_POST['passenger-count'];

	$sql_search = "SELECT * FROM trips WHERE trip_orig='$trip_orig' AND trip_dest='$trip_dest' AND trip_date='$trip_date'";

	$result_search = mysqli_query($con, $sql_search);

	if (mysqli_num_rows($result_search) > 0) {
		echo "<script>
			alert('$trip_orig, $trip_dest, $trip_date, $trip_type, $trip_passenger');
			window.location.href='bookselection.php';
			</script>";
	} else {
		echo "<script>
			alert('No Trip Schedule found.');
			window.location.href='index.php';
			</script>";
	}
}

if (isset($_POST['btnNext2'])) {
	$fname = $_POST['reserve_pFname'];
    $mname = $_POST['reserve_pMname'];
    $lname = $_POST['reserve_pLname'];
    $city = $_POST['reserve_pCity'];
    $email = $_POST['reserve_pReEmail'];
    $contact = $_POST['reserve_pMobile'];
    $address = $_POST['reserve_pFullAddress'];

    $tID = $_POST['selected_ID'];
	$_SESSION['selected_tID'] = $tID;

    $triptime_search = "SELECT * FROM trips WHERE trip_id='".$_SESSION['selected_tID']."'";
    $triptime_result = mysqli_query($con, $triptime_search);
    while($row = mysqli_fetch_array($triptime_result)) {
        $searched_time = $row['trip_time'];
        $searched_seat = $row['seats'];
    }

    $_SESSION['trip_time'] = $searched_time;
    $_SESSION['trip_seats'] = $searched_seat;

	if ($_POST['reserve_pReEmail'] == $_POST['reserve_pEmail']) {
		echo "<script>
			alert(".$_SESSION['selected_tID'].");
			window.location.href='paymentticketinfo.php';
			</script>";
	} else {
        echo "<script>
			window.location.href='javascript:history.back()';
			</script>";
    }
}
?>