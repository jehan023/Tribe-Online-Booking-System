<?php
require('db.php');

if (isset($_POST['Contact_btnSubmit'])) {
    $sender = $_POST['ContactContent_Name'];
    $company = $_POST['ContactContent_Company'];
    $contact = $_POST['ContactContent_Email'];
    $message = $_POST['ContactContent_Message'];

    $send_datetime = date("Y-m-d H:iA");

    $message_insert = "INSERT INTO inquiries (sender, company, email, txt_mssg, sent_time, responded) 
    VALUES ('$sender', '$company', '$contact', '$message', '$send_datetime', '0')";

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
    } else {
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

        $new = mysqli_query($con, $create);
        $new_result = mysqli_query($con, "SHOW TABLES LIKE 'inquiries'");
        if ($new_result->num_rows == 1) {
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
}

?>