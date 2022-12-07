<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	$id = null;
	$bezeichnung = null;
	
	if (isset($_POST['edit']) && isset($_POST['selected-id'])) {
		//set form data
		$id = $_POST['selected-id'];
		
		$query = $conn->prepare("SELECT * FROM fell where id = ?");
		$query->bind_param('i', $id);
		$query->execute();
		$result = $query->get_result();
		$entry = $result->fetch_assoc();
		
		$bezeichnung = $entry['bezeichnung'];
		
		$query->close();
	}
	
	//process action if submitted else display form
	if (isset($_POST['submit'])) {
		$bezeichnung = utf8_decode($_POST['bezeichnung']);
		if ($_POST['id'] == null) {
			//create new entry
			$stmt = $conn->prepare('INSERT INTO fell(bezeichnung) VALUES(?)');
			$stmt->bind_param('s', $bezeichnung);
			$stmt->execute();
			$stmt->close();
		} else {
			//update entry
			$id = $_POST['id'];
		
			$stmt = $conn->prepare('UPDATE fell SET bezeichnung = ? WHERE id = ?');
			$stmt->bind_param('si', $bezeichnung, $id);
			$stmt->execute();
			$stmt->close();
		}
		//redirect to list view
		$url = '../list/felllist.php';
		header('location: ' .$url);
		exit();
	}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Fell Formular</title>
</head>
<body>
    <h1 class="page-title">Fell Formular</h1>
    <form method="post" id="fell-form">
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        <label for="bezeichnung">Bezeichnung</label><br>
        <input type="text" name="bezeichnung" id="bezeichnung" value="<?php echo utf8_encode($bezeichnung); ?>"><br>
        <div class="button-layout">
            <button class="button btn-primary" type="submit" name="submit" id="submit">Absenden</button>
            <a href="../list/felllist.php"><button type="button" class="button">Abbrechen</button></a>
        </div>
    </form>
</body>
</html>