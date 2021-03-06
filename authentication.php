<?php
	session_set_cookie_params(1200);
	session_start();	
	$mysqli = new mysqli('localhost', 'SIAD_lab7', 'secretpass', 'SIAD_lab7');
	if($mysqli->connect_error){
		die('Connection to the database has error: ' . $mysqli->connect_error);
	}

	function checkLogin($username, $password) {
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username=? AND password=password(?)");
		$stmt->bind_param("ss",$username,$password);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows == 1 ){
			return TRUE;
		} else {
			return FALSE;
		}		
	}

	//store a login session in $_SESSION["logged"]
	$username = $_POST["username"];
	$password = $_POST["password"];
	if(isset($username) and isset($password)) {
		$username = mysql_real_escape_string(htmlspecialchars($username));
        	$password = mysql_real_escape_string(htmlspecialchars($password));
		echo "username = $username, password = $password";		
		if(checkLogin($username, $password)){
			echo "Valid username and password <br>";
			$_SESSION["logged"] = TRUE;
			$_SESSION["username"] = $username;
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
			$_SESSION["address"] = $_SERVER["REMOTE_ADDR"];
		} else {
			//header("refresh:1; url = login.php");
			echo "Incorrect username or password <br>";
			session_destroy();	
		}
	}

	if(!isset($_SESSION["logged"])) {
		session_destroy();
		header("refresh:1; url = login.php");
		echo "You have not logged in before<br>";
	}
	
	if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
		echo "Unknown HTTP_USER_AGENT detected";
		session_destroy();
		die();
	}
	
	if($_SESSION["address"] != $_SERVER["REMOTE_ADDR"]) {
		echo "Unknown REMOTE_ADDR detected";
		session_destroy();
		die();
	}
?>
