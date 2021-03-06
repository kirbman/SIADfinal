<?php
	require "authentication.php";
	$secrettoken = $_POST["secrettoken"];
	//echo "debug \$secrettoken = $secrettoken <br>\$_SESSION[\"secret\"] = ". $_SESSION["secret"];
	if(!isset($secrettoken) or ($secrettoken != $_SESSION["secret"])) {
		echo "CSRF attack detected";
		die();
	}
	function addComment($commenter, $postid, $content) {
		$commenter = mysql_real_escape_string($commenter);
		$postid = mysql_real_escape_string($postid);
		$content = mysql_real_escape_string($content);
		$time = date("Y-m-d h:i:sa");
		global $mysqli;
		if (!($stmt = $mysqli->prepare("INSERT INTO comments (content,commenter,time,postid) VALUES (?,?,?,?);"))) {
    			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$stmt->bind_param("ssss", $content, $commenter, $time, $postid);
		if($stmt->execute()){
			echo "New comment added successfully";
			header("refresh:3; url = index.php");
		} else {
			echo "Cannot add comment: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
	}
	
	$commenter = htmlspecialchars($_SESSION["username"]);
	$postid = htmlspecialchars($_POST["postid"]);
	$content = htmlspecialchars($_POST["content"]);
	echo "<debugin'> commenter = $commenter<br> content = $content<br>postid = $postid<br>";
	if(isset($commenter) and isset($content) and isset($postid)) {
		addComment($commenter, $postid, $content);
	}
?>
