<?php
require('db.php');

if (isset($_POST['insertTrip'])) {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $bus_code = $_POST['buscode'];
    $bus_plate = $_POST['plateno'];
    $seats = $_POST['seats'];

    $trip_query = "INSERT INTO trips (trip_orig, trip_dest, trip_date, trip_time, bus_code, bus_plateno, seats) 
        VALUES ('$origin', '$destination', '$date', ' $time', '$bus_code', '$bus_plate', '$seats')";

    $result = mysqli_query($con, "SHOW TABLES LIKE 'trips'");
    if ($result->num_rows == 1) {
        if (mysqli_query($con, $trip_query)) {
            echo "<script>
                alert('Trip Schedule Insertion Complete.');
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
            bus_code varchar(10) NOT NULL,
            bus_plateno varchar(8) NOT NULL,
            seats int(5) NOT NULL,
            PRIMARY KEY (trip_id)
           )";

        $new = mysqli_query($con, $query);
        $new_result = mysqli_query($con, "SHOW TABLES LIKE 'trips'");
        if ($new_result->num_rows == 1) {
            if (mysqli_query($con, $trip_query)) {
                echo "<script>
                    alert('Trip Schedule Insertion Complete.');
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
?>