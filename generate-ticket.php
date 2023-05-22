<?php

require __DIR__ . "/vendor/autoload.php";
session_start();

use Dompdf\Dompdf;
use Dompdf\Options;

$date = strval(date("m/d/y", strtotime($_SESSION['date_depart'])));
$time = strval(date('h:i A', strtotime($_SESSION['trip_time'])));
$origin = strval($_SESSION['origin']);
$destination = strval($_SESSION['destination']);
$tripID = strval($_SESSION['selected_tID']);
$seat = strval($_SESSION['seat_reserve']);
$busCode = strval($_SESSION['bus_code']);
$busPlate = strval($_SESSION['bus_plate']);
$fname = strval($_SESSION['pFname']);
$mname = strval($_SESSION['pMname']);
$lname = strval($_SESSION['pLname']);
$gender = strval($_SESSION['pGender']);
$email = strval($_SESSION['pEmail']);
$contact = strval($_SESSION['pMobile']);
$city = strval($_SESSION['pCity']);
$province = strval($_SESSION['pProvince']);
$fare = strval($_SESSION['trip_fare']);
$payable = strval(sprintf('%.2f', $_SESSION['payable']));
$reserveTime = strval($_SESSION['reservation_time']);


//$html = "<h1 style='color: green'>HELLO JEHAN</h1>";

$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('Letter', "portrait");

$html = file_get_contents("reservationticket.html");

$html = str_replace(
    ["{{ origin }}", "{{ destination }}", "{{ date }}", "{{ time }}", "{{ seat no }}", "{{ trip id }}", "{{ bus code }}", 
    "{{ bus plate }}", "{{ fname }}", "{{ mname }}", "{{ lname }}", "{{ gender }}", "{{ email }}", "{{ contact }}", "{{ city }}",
    "{{ province }}", "{{ fare }}", "{{ payable }}", "{{ reserve-time }}"], 
    [$origin, $destination, $date, $time, $seat, $tripID, $busCode, $busPlate, $fname, $mname, $lname, $gender, $email, $contact,
    $city, $province, $fare, $payable, $reserveTime], 
    $html);

$dompdf->loadHtml($html);
//$dompdf->loadHtmlFile("reservationticket.html");
$dompdf->render();
$dompdf->addInfo("Title", "Reservation Ticket");
$dompdf->addInfo("Author", "Tribe Transport");
$dompdf->stream("tribe-ticket.pdf");

?>