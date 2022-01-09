<?php
require('db.php');

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