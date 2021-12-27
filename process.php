<?php 
  $db = mysqli_connect('localhost', 'root', '', 'tribetransport_db');
  $username = "";
  if (isset($_POST['register'])) {
  	$username = $_POST['username'];
  	$password = $_POST['password'];

  	$sql_u = "SELECT * FROM users WHERE username='$username'";
  	$res_u = mysqli_query($db, $sql_u);
	$create_datetime = date("Y-m-d H:i:s");

  	if (mysqli_num_rows($res_u) > 0) {
  	  $name_error = "*Sorry, '" . $username . "' is already taken"; 	
  	} else {
		  if ($password == $_POST['confirm-password']) {
			$query = "INSERT INTO users (username, pass, created_at) VALUES ('$username', '$password', '$create_datetime')";
			$results = mysqli_query($db, $query);
			echo "<script>
			alert('Registration Complete.');
			window.location.href='dashboard.php';
			</script>";
			exit();
		  } else {
			$pass_error = "*password inputs should be matched.";
		  }
		} 
	}
?>