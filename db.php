<?php
// Enter your host name, database username, password, and database name.
// If you have not set database password on localhost then set empty.
$con = mysqli_connect("localhost", "root", "", "tribetransport_db");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

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
mysqli_query($con, $query);

$passenger_query = "CREATE TABLE IF NOT EXISTS passengers (
    id int(11) NOT NULL AUTO_INCREMENT,
    trip_id int(7) zerofill NOT NULL,
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
    mssg_id int(11) NOT NULL AUTO_INCREMENT,
    sender varchar (100) NOT NULL,
    company varchar (100) NOT NULL,
    email varchar (100) NOT NULL,
    txt_mssg varchar (2000) NOT NULL,
    sent_time datetime NOT NULL,
    responded int(1) NOT NULL,
    PRIMARY KEY (mssg_id)
)";
mysqli_query($con, $create);


?>