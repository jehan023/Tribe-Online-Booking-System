<?php
require("db.php");
include("indexsearch_trip.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket · Tribe Transport</title>

    <link rel="icon" href="images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Montserrat", sans-serif;
            background-color: #f3f3f3;
            box-sizing: border-box;
            display: flex;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            align-content: center;
            padding: 0 10px;
        }

        .notif {
            padding: 15px 20px;
        }

        h2 {
            /* display: block; */
            background-color: rgb(93, 203, 93);
            color: green;
            border: 2px solid green;
            border-radius: 10px;
            width: 100% !important;
            padding: 15px;
            /* margin: 15px 50px; */
            text-align: center;
        }

        .back-button-content {
            width: 100%;
            display: block;
            padding: 15px 20px;
        }

        .download-btn {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-family: "Montserrat", sans-serif;
            cursor: pointer;
        }

        .back-to-index-btn {
            width: 100%;
            min-height: 100px;
            background: brown;
            color: white;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.8rem;
            font-family: "Montserrat", sans-serif;
        }

        .back-to-index-btn:hover {
            background-color: #0a3d52;
        }
    </style>

<body>
    <div class="container">
        <div class="notif">
            <h2>Your reservation ticket is sent to your email. Thank you!</h2>
        </div>
        <!-- <div class="back-button-content">
            <a href="generate-ticket.php" rel="noopener noreferrer" class="download-btn">
                <button class="back-to-index-btn">
                    Download Ticket
                </button>
            </a>
        </div> -->

        <div class="back-button-content">
            <button class="back-to-index-btn" onclick="backtoIndex()">Back to Main</button>
        </div>
    </div>
</body>
<script>
    function backtoIndex() {
        if (confirm("Are you done DOWNLOADING your reservation ticket?")) {
            // Save it!
            location.href = "index.php";
        } else {
            // Do nothing!
        }
    }
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>

</html>