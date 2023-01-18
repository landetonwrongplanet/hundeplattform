<?php
	#Config for database and session (eventually outsource)

	#Configuration details for the database connection
	$db_user = "bsfh";
	$pass = "151Mhfsb";
	$host = "localhost";
	$db = "hunde";
	
	#Connection stored here
	$conn = mysqli_connect($host, $db_user, $pass, $db) or die("A connection could not be established.");
	//echo "Verbindung erfolgreich";

	session_start();
	
	if(isset($_SESSION["user"])) {
		#do admin control
	} else {
		#redirect to login
	}
?>