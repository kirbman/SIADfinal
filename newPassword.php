<?php
	//newPassword.php

	require "authentication.php";
	function changePassword($username, $password) {
		global $mysqli;
		echo "1";
	        $stmt = $mysqli->prepare("UPDATE users SET password = password(?) WHERE username = ?;");
		$stmt->bind_param("ss", $password, $username);
		if($stmt->execute()) {
			echo "$username 's password changed successfully<br>";
		} else {
			echo "Cannot change password for '$username':" . $mysqli->error;
		}
	}
	$username = htmlspecialchars($_SESSION["username"]);
	$password = htmlspecialchars($_POST["newPassword"]);
	$currentEntered = htmlspecialchars($_POST["currentPassword"]);
	if(!checkLogin($username,$currentEntered)){
		echo "Current passwords do not match.";
		header("refresh:1; url = changepassform.php");
		die();
	}
	if(isset($username) and isset($password)) {
		changePassword($username, $password);
		echo"Redirecting...";
		header("refresh:3; url = index.php");
	}
?>
