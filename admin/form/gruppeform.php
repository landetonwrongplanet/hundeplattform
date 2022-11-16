<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	
	//process action if submitted else display form
	if (isset($_POST['submit'])) {
		$gruppennummer = $_POST['nummer'];
		$bezeichnung = utf8_decode($_POST['bezeichnung']);
		if ($_POST['id'] == null) {
			//create new entry
			$stmt = $conn->prepare('INSERT INTO gruppe(gruppennummer, bezeichnung) VALUES(?,?)');
			$stmt->bind_param('is', $gruppennummer, $bezeichnung);
			$stmt->execute();
			$stmt->close();
		} else {
			//update entry
		}
		//redirect to list view
		$url = '../list/gruppelist.php';
		header('location: ' .$url);
		exit();
	}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Gruppe Formular</title>
</head>
<body>
    <h1 class="page-title">Rassengruppe Formular</h1>
    <form method="post" id="gruppe-form">
		<input type="hidden" name="id" id="id">
        <label for="nummer">Gruppennummer</label>
        <input type="number" name="nummer" id="nummer"><br>
        <label for="bezeichnung">Bezeichnung</label><br>
        <input type="text" name="bezeichnung" id="bezeichnung"><br>
        <div class="button-layout">
            <button class="button btn-primary" type="submit" name="submit" id="submit">Absenden</button>
            <a href="../list/gruppelist.php"><button type="button" class="button">Abbrechen</button></a>
        </div>
    </form>
</body>
</html>