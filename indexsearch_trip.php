<?php
require('db.php');
session_start();

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
			</script>";
	}
}
?>