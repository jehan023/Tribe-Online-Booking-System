<?php
date_default_timezone_set("Asia/Manila");
require('db.php');
$username = "";

if (isset($_POST['register'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql_username = "SELECT * FROM users WHERE username='$username'";
	$res_username = mysqli_query($con, $sql_username);
	$create_datetime = date("Y-m-d H:i:s");

	if (mysqli_num_rows($res_username) > 0) {
		$name_error = "*Sorry, '" . $username . "' is already taken";
	}
	else {
		if ($password == $_POST['confirm-password']) {
			$query = "INSERT INTO users (username, pass, created_at) VALUES ('$username', '".md5($password)."', '$create_datetime')";

			if (mysqli_query($con, $query)) {
                echo "<script>
                    alert('Registration Complete.');
					window.location.href='dashboard.php?view_panel=addUserAcct';
                    </script>";
            }
            else {
                echo "<script>
                    alert('ERROR: Could not able to execute $query');
                    </script>";
            }
		}
		else {
			$pass_error = "*password inputs should be matched.";
		}
	}
}
?>