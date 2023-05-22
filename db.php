<?php
// Enter your host name, database username, password, and database name.
// If you have not set database password on localhost then set empty.
/*$con = mysqli_connect("localhost", "root", "", "tribetransport_db");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/

$con = new mysqli("localhost", "root", "");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$sql_db = "CREATE DATABASE IF NOT EXISTS tribetransport_db";
$con->query($sql_db);
// If database is not exist create one
if (!mysqli_select_db($con,"tribetransport_db")){
    
    if ($con->query($sql_db) === TRUE) {
        echo "Database created successfully";
    }else {
        echo "Error creating database: " . $con->error . "/n";
    }
} 

$query = "CREATE TABLE IF NOT EXISTS trips (
    trip_id varchar(20) NOT NULL,
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
mysqli_query($con, $query);

$passenger_query = "CREATE TABLE IF NOT EXISTS passengers (
    id varchar(20) NOT NULL,
    trip_id varchar(20) NOT NULL,
    seat_no int(3) NOT NULL,
    trip_date date NOT NULL,
    trip_time varchar(10) NOT NULL,
    firstname varchar (100) NOT NULL,
    middlename varchar (100) NOT NULL,
    lastname varchar (100) NOT NULL,
    gender varchar (6) NOT NULL,
    email varchar (50) NOT NULL,
    contact varchar (50) NOT NULL,
    city varchar (100) NOT NULL,
    province varchar (100) NOT NULL,
    reservation datetime NOT NULL,
    payable decimal (6,2) NOT NULL,
    paid int(1) NOT NULL,
    PRIMARY KEY (id)
)";
mysqli_query($con, $passenger_query);

$create = "CREATE TABLE IF NOT EXISTS inquiries (
    id varchar(15) NOT NULL,
    sender varchar (100) NOT NULL,
    company varchar (100) NOT NULL,
    email varchar (100) NOT NULL,
    txt_mssg varchar (2000) NOT NULL,
    sent_time datetime NOT NULL,
    responded int(1) NOT NULL,
    PRIMARY KEY (id)
)";
mysqli_query($con, $create);

$announcements = "CREATE TABLE IF NOT EXISTS announcements (
    id varchar(15) NOT NULL,
    title varchar (200) NOT NULL,
    context varchar (2000) NOT NULL,
    post_time datetime NOT NULL,
    PRIMARY KEY (id)
)";
mysqli_query($con, $announcements);

$users = "CREATE TABLE IF NOT EXISTS users (
    id varchar(15) NOT NULL,
    username varchar (10) NOT NULL,
    pass varchar (50) NOT NULL,
    created_at datetime NOT NULL,
    PRIMARY KEY (id)
)";
mysqli_query($con, $users);

$sql_useradmin = "SELECT * FROM users";
$res_useradmin = mysqli_query($con, $sql_useradmin);
$create_datetime = date("Y-m-d H:i:s");
if (mysqli_num_rows($res_useradmin) == 0) {
    $userID = uniqid();
    $admin = "INSERT INTO users (id, username, pass, created_at) VALUES ('$userID', 'tribe2022', '".md5('tribeadmin')."', '$create_datetime')";
    mysqli_query($con, $admin);
}

?>