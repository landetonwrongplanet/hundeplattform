<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	
	$print_message = "start...<br>";
	//process action if submitted else display form
	if (isset($_POST['submit'])) {
		$bezeichnung = utf8_decode($_POST['bezeichnung']);
		$lebenserwartung = $_POST['lebenserwartung'];
		$min_gewicht = $_POST['min-gewicht'];
		$max_gewicht = $_POST['max-gewicht'];
		$min_widerrist = $_POST['min-widerrist'];
		$max_widerrist = $_POST['max-widerrist'];
		$herkunft = utf8_decode($_POST['herkunft']);
		$arbeit = isset($_POST['arbeit']);
		$sozial = isset($_POST['sozial']);
		$gruppe = $_POST['gruppe'];
		$geschichte = utf8_decode($_POST['geschichte']);
		$zu_achten_auf = utf8_decode($_POST['zu-achten-auf']);
		$bild = null;
		if (!empty($_FILES['bild']['tmp_name'])) {
			$bild = file_get_contents($_FILES['bild']['tmp_name']);
		}
		
		if ($_POST['id'] == null) {
			//create new entry
			$stmt = $conn->prepare('INSERT INTO rasse(bezeichnung, lebenserwartung, minimal_gewicht, maximal_gewicht, minimal_widerrist, maximal_widerrist, herkunft, verwendung_arbeit, verwendung_sozial, gruppe_id, geschichte, zu_achten_auf, bild) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)');
			$stmt->bind_param('siiiiisiiisss', $bezeichnung, $lebenserwartung, $min_gewicht, $max_gewicht, $min_widerrist, $max_widerrist, $herkunft, $arbeit, $sozial, $gruppe, $geschichte, $zu_achten_auf, $bild);
			
			//set up relations
			if(mysqli_stmt_execute($stmt)) {
				$rasse_id = $conn->insert_id;
				$print_message .= "inserted data rasse id = " .$rasse_id ."<br>";
				
				$charakter = $_POST['charakter[]'];
				$print_message .= "charakter = "	.$charakter			."<br>";
				
				foreach ($_POST['charakter'] as $val) {
					$print_message .= "charakter loop: value = " .$val ."<br>";
					$id = null;
					if (is_string($val)) {
						//add new entry
						$print_message .= "adding new charakter <br>";
						$stmt_new_char = $conn->prepare('INSERT INTO charakter(bezeichnung), VALUES(?)');
						$stmt_new_char->bind_param('s', $val);
						
						if (mysqli_stmt_execute($stmt_new_char)) {
							$id = $conn->insert_id;
							$print_message .= "inserted data charakter id = " .$id ."<br>";
						}
					} else {
						$id = $val;
						$print_message .= "charakter id = " .$id ."<br>";
					}
			
					if ($id != null) {
						$stmt_char = $conn->prepare('INSERT INTO rasse_charakter(rasse_id, charakter_id) VALUES(?,?)');
						$stmt_char->bind_param('ii', $rasse_id, $id);
						$stmt_char->execute();
						$print_message .= "inserted relation entry rasse charakter <br>";
					}
				}
				foreach ($_POST['farbe'] as $val) {
					$print_message .= "farbe loop: value = " .$val ."<br>";
					$id;
					if (is_string($val)) {
						//add new entry
						$print_message .= "adding new farbe <br>";
						$stmt_new_farbe = $conn->prepare('INSERT INTO farbe(bezeichnung), VALUES(?)');
						$stmt_new_farbe->bind_param('s', $val);
						
						if (mysqli_stmt_execute($stmt_new_farbe)) {
							$id = $conn->insert_id;
							$print_message .= "inserted data farbe id = " .$id ."<br>";
						}
					} else {
						$id = $val;
						$print_message .= "farbe id = " .$id ."<br>";
					}
					if ($id != null) {
						$stmt_farbe = $conn->prepare('INSERT INTO rasse_farbe(rasse_id, farbe_id) VALUES(?,?)');
						$stmt_farbe->bind_param('ii', $rasse_id, $id);
						$stmt_farbe->execute();
						$print_message .= "inserted relation entry rasse farbe <br>";
					}
				}
				foreach ($_POST['fell'] as $val) {
					$print_message .= "fell loop: value = " .$val ."<br>";
					$id;
					if (is_string($val)) {
						//add new entry
						$print_message .= "adding new fell <br>";
						$stmt_new_fell = $conn->prepare('INSERT INTO fell(bezeichnung), VALUES(?)');
						$stmt_new_fell->bind_param('s', $val);
						
						if (mysqli_stmt_execute($stmt_new_fell)) {
							$id = $conn->insert_id;
							$print_message .= "inserted data fell id = " .$id ."<br>";
						}
					} else {
						$id = $val;
						$print_message .= "fell id = " .$id ."<br>";
					}
					if ($id != null) {
						$stmt_fell = $conn->prepare('INSERT INTO rasse_fell(rasse_id, fell_id) VALUES(?,?)');
						$stmt_fell->bind_param('ii', $rasse_id, $id);
						$stmt_fell->execute();
						$print_message .= "inserted relation entry rasse fell <br>";
					}
				}
			}

		} else {
			//update entry
		}
		//redirect to list view
		/*
		$url = '../list/rasselist.php';
		header('location: ' .$url);
		exit();
		*/
	}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Hunderasse Formular</title>
</head>
<script src="../../js/adminscript.js"></script>
<body>
	<p><?php echo $print_message ?></p>
    <h1 class="page-title">Hunderasse Formular</h1>
    <form method="post" id="rasse-form" enctype="multipart/form-data">
		<input type="hidden" name="id" id="id">
        <label for="bezeichnung">Bezeichnung</label><br>
        <input type="text" name="bezeichnung" id="bezeichnung"><br>
        <label for="lebenserwartung">Lebenserwartung</label><br>
        <input type="number" name="lebenserwartung" id="lebenserwartung"><br>
        <label for="min-gewicht">Minimum Gewicht (kg)</label><br>
        <input type="number" name="min-gewicht" id="min-gewicht" min="0" max="100"><br>
        <label for="max-gewicht">Maximum Gewicht (kg)</label><br>
        <input type="number" name="max-gewicht" id="max-gewicht" min="0" max="100"><br>
        <label for="min-widerrist">Minimum Widerrist (cm)</label><br>
        <input type="number" name="min-widerrist" id="min-widerrist" min="0" max="200"><br>
        <label for="max-widerrist">Maximum Widerrist (cm)</label><br>
        <input type="number" name="max-widerrist" id="max-widerrist" min="0" max="200"><br>
        <label for="herkunft">Herkunft</label><br>
        <input type="text" name="herkunft" id="herkunft"><br>
        <label for="arbeit">Verwendung Arbeit</label>
        <input type="checkbox" name="arbeit" id="arbeit"><br>
        <label for="sozial">Verwendung Sozial</label>
        <input type="checkbox" name="sozial" id="sozial"><br>
        <label for="geschichte">Geschichte</label><br>
        <textarea rows="2" name="geschichte" form="rasse-form"></textarea><br>
        <label for="zu-achten-auf">Zu achten auf</label><br>
        <textarea rows="2" name="zu-achten-auf" form="rasse-form"></textarea><br>
        <label for="bild">Bild</label><br>
        <input type="file" name="bild" id="bild"><br>
        <label for="gruppe">Gruppe</label><br>
        <select name="gruppe" id="gruppe">
			<?php
				$query = "SELECT * FROM gruppe";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'>" .utf8_encode($row['bezeichnung']) ."</option>";
				}
			?>
        </select><br>
        <label for="charakter">Charakter</label><br>
        <select name="charakter[]" id="charakter" multiple>
            <?php
				$query = "SELECT * FROM charakter";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'>" .utf8_encode($row['bezeichnung']) ."</option>";
				}
			?>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-charakter" id="custom-charakter">
            <button type="button" class="custom-input-button" onclick="add_custom_charakter()">+</button>
        </div>
        <label for="farbe">Farbe</label><br>
        <select name="farbe" id="farbe" multiple>
            <?php
				$query = "SELECT * FROM farbe";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'>" .utf8_encode($row['bezeichnung']) ."</option>";
				}
			?>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-farbe" id="custom-farbe">
            <button type="button" class="custom-input-button" onclick="add_custom_farbe()">+</button>
        </div>
        <label for="fell">Fell</label><br>
        <select name="fell" id="fell" multiple>
            <?php
				$query = "SELECT * FROM fell";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'>" .utf8_encode($row['bezeichnung']) ."</option>";
				}
			?>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-fell" id="custom-fell">
            <button type="button" class="custom-input-button" onclick="add_custom_fell()">+</button>
        </div>
        <div class="button-layout">
            <button class="button btn-primary" type="submit" name="submit" id="submit">Absenden</button>
            <a href="../list/rasselist.php"><button type="button" class="button" >Abbrechen</button></a>
        </div>
    </form>
</body>
</html>