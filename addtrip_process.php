<?php
require('db.php');

if (isset($_POST['insertTrip'])) {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $fare = $_POST['fare'];
    $bus_code = $_POST['buscode'];
    $bus_plate = $_POST['plateno'];
    $seats = 44;

    $trip_query = "INSERT INTO trips (trip_orig, trip_dest, trip_date, trip_time, fare, bus_code, bus_plateno, seats, departed, arrived, status) 
        VALUES ('$origin', '$destination', '$date', '$time', '$fare', '$bus_code', '$bus_plate', '$seats', '', '', '0')";

    $result = mysqli_query($con, "SHOW TABLES LIKE 'trips'");
    if ($result->num_rows == 1) {
        if (mysqli_query($con, $trip_query)) {
            echo "<script>
                alert('Trip Schedule Insertion Complete.');
                window.location.href ='dashboard.php?view_panel=tripSchedules';
                </script>";

            echo "<script>
            console.log('adding');
            </script>";
            $last_id = mysqli_insert_id($con);
            echo "<script>
            console.log($last_id);
            </script>";
        }
        else {
            echo "<script>
                alert('ERROR: Could not able to execute $trip_query');
                </script>";
        }
    } else {
        $query = "CREATE TABLE IF NOT EXISTS trips (
            trip_id int(7) zerofill NOT NULL AUTO_INCREMENT,
            trip_orig varchar(50) NOT NULL,
            trip_dest varchar(50) NOT NULL,
            trip_date date NOT NULL,
            trip_time varchar(10) NOT NULL,
            fare DECIMAL(6,2) NOT NULL,
            bus_code varchar(10) NOT NULL,
            bus_plateno varchar(8) NOT NULL,
            seats int(5) NOT NULL,
            book_seats varchar(255) NOT NULL,
            departed datetime NOT NULL,
            arrived datetime NOT NULL,
            status int(1) NOT NULL,
            PRIMARY KEY (trip_id)
           )";

        $new = mysqli_query($con, $query);
        $new_result = mysqli_query($con, "SHOW TABLES LIKE 'trips'");
        if ($new_result->num_rows == 1) {
            if (mysqli_query($con, $trip_query)) {
                echo "<script>
                    alert('Trip Schedule Insertion Complete.');
                    window.location.href ='dashboard.php?view_panel=tripSchedules';
                    </script>";
            }
            else {
                echo "<script>
                    alert('ERROR: Could not able to execute $trip_query');
                    </script>";
            }
        }
    }
}

if(isset($_POST['delete-inquiry-data'])){
    $mssg_id = $_POST['delete-inquiry-data'];
    $del = mysqli_query($con,"DELETE FROM inquiries WHERE mssg_id = '$mssg_id'"); // delete query
    if($del)
    {
        header("location:dashboard.php?view_panel=messageInquiries"); // redirects to all records page
        exit;	
    } else {
        echo "Error deleting record"; // display error message if not delete
    }
}

if(isset($_POST['inquiry-reply-data'])){
    $mssg_id = $_POST['inquiry-reply-data'];
    $inquiry_update = "UPDATE inquiries set responded = '1' WHERE mssg_id = '".$mssg_id."'";
    if (mysqli_query($con, $inquiry_update)) {
		header("location:dashboard.php?view_panel=messageInquiries"); // redirects to all records page
        exit;
	}
	else {
		echo "<script>
			alert('ERROR: Could not able to execute $inquiry_update');
			</script>";
	}
}
?>