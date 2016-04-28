<?php
session_name("wecrazy943556");
session_start();
date_default_timezone_set('America/Denver'); 
if(!isset($_SESSION["startTime"])) {
	$_SESSION["startTime"] = time();
}
require "global.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<title>My Trainer</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
		<a class="navbar-brand" href="index.php">My Trainer</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
	        <?php
	        	if(isLoggedIn()) {
	        		$userName = $_SESSION['userName'];
	        		echo "<li><a href=\"profile.php?userName= $userName\">Welcome! $userName</a></li>";
				echo "<li><a href=\"logout.php\">Logout</a></li>";
				
	        	} 
	        ?>
	      </ul>
	      <form class="navbar-form navbar-right" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-default">Submit</button>
	      </form>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
