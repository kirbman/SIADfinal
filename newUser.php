<?php
	require "authentication.php";
	$secrettoken = $_POST["secrettoken"];
	echo "debug \$secrettoken = $secrettoken <br>\$_SESSION[\"secret\"] = ". $_SESSION["secret"];
	if(!isset($secrettoken) or ($secrettoken != $_SESSION["secret"])) {
		echo "CSRF attack detected";
		die();
	}
	function addUser($username, $password) {
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql = "INSERT INTO users VALUE('$username',password('$password'));";
		//debug
		global $mysqli;
		$result = $mysqli->query($sql);
		if($result === TRUE){
			echo "$username added successfully";
		} else {
			echo "Cannot add user '$username':" . $mysqli->error;
		}
	}

	$username = $_POST["Newusername"];
	$password = $_POST["Newpassword"];
	echo "<debugin'> Username = $username; Password = $password<br>";
	if(isset($username) and isset($password)) {
		addUser($username, $password);
	}
?>
