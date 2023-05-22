<?php
date_default_timezone_set("Asia/Manila");
require('db.php');

if (isset($_POST['Contact_btnSubmit'])) {
    $sender = $_POST['ContactContent_Name'];
    $company = $_POST['ContactContent_Company'];
    $contact = $_POST['ContactContent_Email'];
    $message = $_POST['ContactContent_Message'];

    $send_datetime = date("Y-m-d H:i:s");
    $mssg_id = uniqid();

    $message_escaped = mysqli_real_escape_string($con, $message);

    $message_insert = "INSERT INTO inquiries (id, sender, company, email, txt_mssg, sent_time, responded) 
    VALUES ('$mssg_id', '$sender', '$company', '$contact', '$message_escaped', '$send_datetime', '0')";

    $check_mssgtable = mysqli_query($con, "SHOW TABLES LIKE 'inquiries'");

    if ($check_mssgtable->num_rows == 1) {
        if (mysqli_query($con, $message_insert)) {
            echo "<script>
                    alert('INQUIRY SENT.');
                    window.location.href='index.php';
                    </script>";
        }
        else {
            echo "<script>
                alert('ERROR: Could not able to execute $message_insert');
                </script>";
        }
    }
}

?>