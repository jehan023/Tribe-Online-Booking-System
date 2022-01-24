<?php
date_default_timezone_set("Asia/Manila");
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

    $trip_query = "INSERT INTO trips (trip_orig, trip_dest, trip_date, trip_time, fare, bus_code, bus_plateno, seats, book_seats, departed, arrived, status) 
        VALUES ('$origin', '$destination', '$date', '$time', '$fare', '$bus_code', '$bus_plate', '$seats', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0')";

    $result = mysqli_query($con, "SHOW TABLES LIKE 'trips'");
    if ($result->num_rows == 1) {
        if (mysqli_query($con, $trip_query)) {
            echo "<script>
                alert('Trip Schedule Insertion Complete.');
                window.location.href ='dashboard.php?view_panel=tripSchedules';
                </script>";
        } else {
            echo "<script>
                alert('ERROR: Could not able to execute $trip_query');
                </script>";
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
        echo "<script>alert('Error deleting record');</script>"; // display error message if not delete
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

if(isset($_POST['announcementPost'])){
    $title = $_POST['Announcement_Title'];
    $context = $_POST['Announcement_Context'];
    $post_datetime = date("Y-m-d H:i:s");

    $announcement_insert = "INSERT INTO announcements (title, context, post_time) VALUES ('$title','$context','$post_datetime')";
    $result = mysqli_query($con, "SHOW TABLES LIKE 'announcements'");
    if ($result->num_rows == 1) {
        if (mysqli_query($con, $announcement_insert)) {
            echo "<script>
                alert('Announcement Posted.');
                window.location.href ='dashboard.php?view_panel=announcements';
                </script>";
        } else {
            echo "<script>
                alert('ERROR: Could not able to execute $announcement_insert');
                </script>";
        }
    }
}

if(isset($_POST['delete-announcement-data'])){
    $announcement_id = $_POST['delete-announcement-data'];
    $del = mysqli_query($con,"DELETE FROM announcements WHERE id = '$announcement_id'"); // delete query
    if($del)
    {
        header("location:dashboard.php?view_panel=announcements"); // redirects to all records page
        exit;	
    } else {
        echo "<script>alert('Error deleting record');</script>"; // display error message if not delete
    }
}
?>