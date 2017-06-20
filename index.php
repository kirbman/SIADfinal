<html>
<!-- INDEX PAGE -->

<!-- MENU BAR -->
<div class="topnav" id="myTopnav">
	<a href='admin.php'>Admin</a>
	<a href='logout.php'>Logout</a>
	<a href='addPostForm.php'>Create New Post</a>
</div>
		
<?php require "authentication.php"; 
	if($stmt = $mysqli->prepare("SELECT title, content, time, author, postid FROM posts")){
	$stmt->execute();
	$stmt->bind_result($title, $content, $time, $author, $postid);
	$result = $stmt->store_result();
	} else {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;	
	}

	
	while($stmt->fetch()){
		echo"<h3>".htmlentities($title)."</h3>";
		echo htmlentities($content) . "<br><br>" . "author: " . htmlentities($author) . " // time: " . htmlentities($time) . "<br><br>";
		if($stmt2 = $mysqli->prepare("SELECT content FROM comments WHERE postid=?")){
			$stmt2->bind_param("i", $postid);
			$stmt2->execute();
			$stmt2->bind_result($cid);
			$result = $stmt2->store_result();
		} else {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$numComm = $stmt2->num_rows;
		if($numComm < 1) {
			echo"<a	href='commentForm.php?postid=$postid'>";
			echo "Post your first comment.</a><br><br>";
		} else {
			echo"<a	href='comments.php?postid=$postid'>";
			echo htmlentities($numComm)." comment(s)</a>";
		}	
	}

?>
</html>
