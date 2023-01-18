<?php

	include('../config/config.php');

	// fetch users and addresses from database
	$query = $conn->prepare("SELECT username, vorname, nachname, email, strasse, plz, ortschaft FROM benutzer LEFT JOIN addresse on benutzer.addresse_id = addresse.id LEFT JOIN ort on addresse.ort_id = ort.id");
	$query->execute();
	$result = $query->get_result();
	
	// create csv file
	$file = "adressliste.csv";
	$csv = fopen($file, "w") or die("Unable to open file!");
	fwrite($csv, "username,vorname,nachname,email,strasse,plz,ort" .PHP_EOL);
	foreach ($result as $row) {
		//fputcsv($csv, $row["username"] ."," .$row["vorname"] ."," .$row["nachname"] ."," .$row["email"] ."," .$row["strasse"] ."," .$row["plz"] ."," .$row["ortschaft"]);
		fputcsv($csv, $row);
	}
	fclose($csv);
	
	// start download
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	header("Content-Type: text/csv");
	readfile($file);
?>