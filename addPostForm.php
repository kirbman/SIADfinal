<html>
	<h1>Create Post</h1>

<?php
	require "authentication.php";
	echo "Current time: " . date("Y-m-d h:i:sa");
	$rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["secret"] = $rand;
?>
	<form action="newPost.php" method="POST" class="form addPost">
		<input type="hidden" name="secrettoken" value="<?php echo $rand; ?>">
		<p>Title: <input type="text" name="title"></p>
		
		<p>Content<br><textarea cols="50" rows="4" name="content"></textarea></p>

		<button class="button" type="submit">
			Create New Post

		</button>
	</form>
</html>
