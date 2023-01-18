<?php
	#This file displays BLOB data as an image.

	include("config/config.php");
	
	$id = isset($_GET["rasse_id"]) ? $_GET["rasse_id"] : 0;
	$file = null;
	
	$sql = "SELECT bild FROM rasse WHERE id = " .$id .";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	
	if($row != null) {
		$file = $row[0];
	}
	
	if($file != null) {
		#Set Content-type to the recorded mime type in the header.
		header("Content-type: image/webp");
		
		#BLOB data here
		echo $file;
	} else {
		echo "<img src='img/no-image.jpg' alt='no-image'>";
	}
?>
