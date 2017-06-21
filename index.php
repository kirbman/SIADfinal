<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Start Bootstrap</a>
            </div>
            
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Welcome to our Blog!
                    <small>Created by Cody and Logan.</small>
                </h1>

                
            </div>
	    <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="addUser.php">Add User</a>
                    </li>
                    <li>
                        <a href="addPostForm.php">New Post</a>
                    </li>
                    <li>
                        <a href="commentForm.php">New Comment</a>
                    </li>
		    <li>
			<a href="changepassform.php">Change Password</a>
		    </li>
		    <li>
			<a href="logout.php">Logout</a>
		    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
            <!-- Blog Sidebar Widgets Column -->
            <div class="$postid">
		   
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Test Project Made By Cody and Logan</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

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
			echo"<a href='commentForm.php?postid=$postid'>";
			echo "Post your first comment.</a><br><br>";
		} else {
			echo"<a href='comments.php?postid=$postid'>";
			echo htmlentities($numComm)." comment(s)</a>";
		}
	}
?>

</html>
