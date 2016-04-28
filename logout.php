<?php
	require 'header.php'; 
	$databaseObj->setOnlineFalse($_SESSION['userName']);
	session_start();
	unset($_SESSION);
	session_destroy();
	header("Location: index.php");
	exit();
?>
