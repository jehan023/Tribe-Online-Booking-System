<?php
require('db.php');

// Retrieve the search parameters from the AJAX request
$tripId = $_POST['trip_id-search'];
$contact = $_POST['contact-search'];
$lastname = $_POST['lastname-search'];

// Perform the search and generate the result HTML
// Modify this part with your actual database query and result generation logic
$search_inputs_passenger = "SELECT * FROM passengers WHERE trip_id = '$tripId' AND contact = '$contact' AND lastname = '$lastname'";
$resultHtml = '';
$bookingsearch = mysqli_query($con, $search_inputs_passenger);

// Example result HTML
if (mysqli_num_rows($bookingsearch) > 0) {
    while($row = mysqli_fetch_array($bookingsearch)) {
        if ($row['paid'] == 0){
            $resultHtml = '<div class="search-status on-going"><p>Your reservation is still pending.</p></div>';
        } else {
            $resultHtml = '<div class="search-status on-going"><p>Your ticket was already paid.</p></div>';
        }
    }
} else {
    $resultHtml = '<div class="search-status invalid"><p>No record found.</p></div>';
}

// Return the result HTML
echo $resultHtml;
?>  