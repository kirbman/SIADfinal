<html>
<!-- COMMENTS PAGE -->

<!-- MENU BAR -->
<div class="topnav" id="myTopnav">
	<a href='index.php'>Home</a>
	<a href='admin.php'>Admin</a>
	<a href='logout.php'>Logout</a>
</div>		
<?php require "authentication.php";
	$postid = htmlspecialchars($_GET['postid']);
	if($stmt = $mysqli->prepare("SELECT title, content, time, author FROM posts WHERE postid=?")){
	$stmt->bind_param("i", $postid);
	$stmt->execute();
	//$stmt->store_result();
	$stmt->bind_result($title, $content, $time, $author);
	} else {
		echo "Prepared failed";	
	}	
	while($stmt->fetch()){
		//$postid = $row["postid"];				
		echo"<h3>". htmlentities($title)."</h3>";
		echo htmlentities($content) . "<br><br>" . "author: " . htmlentities($author) . " // time: " . htmlentities($time) . "<br>";
		echo "<h4>Comments</h4>";
	}
	if($stmt2 = $mysqli->prepare("SELECT content, time, commenter FROM comments WHERE postid=?")){
		$stmt2->bind_param("i", $postid);
		$stmt2->execute();
		$stmt2->bind_result($content, $time, $commenter);
		while($stmt2->fetch()){
			echo htmlentities($content) . "<br>" . "Commenter: " . htmlentities($commenter) . " // time: " . htmlentities($time) . "<br><br>";
		}
		echo"<a	href='commentForm.php?postid=$postid'>";
		echo "Add a comment</a><br><br>";
	} else {
		echo "Prepare failed";
	}		
?>
</html>
