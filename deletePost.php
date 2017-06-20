<?php
	require "authentication.php";
	$secrettoken = htmlspecialchars($_POST["secrettoken"]);
	//echo "debug \$secrettoken = $secrettoken <br>\$_SESSION[\"secret\"] = ". $_SESSION["secret"];
	if(!isset($secrettoken) or ($secrettoken != $_SESSION["secret"])) {
		echo "CSRF attack detected";
		die();
	}
	function addPost($author, $title, $content) {
		$author = mysql_real_escape_string($author);
		$title = mysql_real_escape_string($title);
		$content = mysql_real_escape_string($content);
		$time = date("Y-m-d h:i:sa");
		global $mysqli;
		if (!($stmt = $mysqli->prepare("INSERT INTO posts (title,content,time,author) VALUES (?,?,?,?);"))) {
    			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$stmt->bind_param("ssss", $title, $content, $time, $author);
		if($stmt->execute()){
			echo "New post created successfully";
			header("refresh:3; url = index.php");
		} else {
			echo "Cannot create post: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
	}
	
	$author = htmlspecialchars($_SESSION["username"]);
	$title = htmlspecialchars($_POST["title"]);
	$content = htmlspecialchars($_POST["content"]);
	echo "<debugin'> title = $title<br> content = $content<br>author = $author<br>";
	if(isset($title) and isset($content) and isset($author)) {
		addPost($author, $title, $content);
	}
?>
