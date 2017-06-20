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
		global $mysqli;
		if (!($stmt = $mysqli->prepare("INSERT INTO users VALUE(?,password(?));"))) {
    			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$stmt->bind_param("ss", $username, $password);
		if($stmt->execute()){
			echo "$username added successfully";
			header("refresh:3; url = index.php");
		} else {
			echo "Cannot add user '$username':" . $mysqli->error;
		}
		
		//$sql = "INSERT INTO users VALUE('$username',password('$password'));";
		/*if($result === TRUE){
			echo "$username added successfully";
		} else {
			echo "Cannot add user '$username':" . $mysqli->error;
		}*/
	}

	$username = htmlspecialchars($_POST["Newusername"]);
	$password = htmlspecialchars($_POST["Newpassword"]);
	echo "<debugin'> Username = $username; Password = $password<br>";
	if(isset($username) and isset($password)) {
		addUser($username, $password);
	}
?>
