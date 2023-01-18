<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	$id = null;
	$bezeichnung = null;
	$lebenserwartung = null;
	$min_gewicht = null;
	$max_gewicht = null;
	$min_widerrist = null;
	$max_widerrist = null;
	$herkunft = null;
	$arbeit = null;
	$sozial = null;
	$gruppe = null;
	$geschichte = null;
	$zu_achten_auf = null;
	$bild = null;
	$charakter[] = null; 
	$farbe[] = null;
	$fell[] = null;
	
	if (isset($_GET['id'])) {
		//set form data
		$id = $_GET['id'];
		
		$query = $conn->prepare("SELECT * FROM rasse where id = ?");
		$query->bind_param('i', $id);
		$query->execute();
		$result = $query->get_result();
		$entry = $result->fetch_assoc();
		
		$bezeichnung = $entry['bezeichnung'];
		$lebenserwartung = $entry['lebenserwartung'];
		$min_gewicht = $entry['minimal_gewicht'];
		$max_gewicht = $entry['maximal_gewicht'];
		$min_widerrist = $entry['minimal_widerrist'];
		$max_widerrist = $entry['maximal_widerrist'];
		$herkunft = $entry['herkunft'];
		$arbeit = $entry['verwendung_arbeit'];
		$sozial = $entry['verwendung_sozial'];
		$gruppe = $entry['gruppe_id'];
		$geschichte = $entry['geschichte'];
		$zu_achten_auf = $entry['zu_achten_auf'];
		$bild = $entry['bild'];
	
		$char_query = $conn->prepare("SELECT * FROM rasse_charakter where rasse_id = ?");
		$char_query->bind_param('i', $id);
		$char_query->execute();
		$char_result = $char_query->get_result();
		while ($row = $char_result->fetch_assoc()) {
			array_push($charakter, $row['charakter_id']);
		}
		
		$farbe_query = $conn->prepare("SELECT * FROM rasse_farbe where rasse_id = ?");
		$farbe_query->bind_param('i', $id);
		$farbe_query->execute();
		$farbe_result = $farbe_query->get_result();
		while ($row = $farbe_result->fetch_assoc()) {
			array_push($farbe, $row['farbe_id']);
		}
		
		$fell_query = $conn->prepare("SELECT * FROM rasse_fell where rasse_id = ?");
		$fell_query->bind_param('i', $id);
		$fell_query->execute();
		$fell_result = $fell_query->get_result();
		while ($row = $fell_result->fetch_assoc()) {
			array_push($fell, $row['fell_id']);
		}
		
		$char_query->close();
	}
	
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
			$stmt = null;
			
			$stmt = $conn->prepare('INSERT INTO rasse(bezeichnung, lebenserwartung, minimal_gewicht, maximal_gewicht, minimal_widerrist, maximal_widerrist, herkunft, verwendung_arbeit, verwendung_sozial, gruppe_id, geschichte, zu_achten_auf, bild) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)');
			$stmt->bind_param('siiiiisiiisss', $bezeichnung, $lebenserwartung, $min_gewicht, $max_gewicht, $min_widerrist, $max_widerrist, $herkunft, $arbeit, $sozial, $gruppe, $geschichte, $zu_achten_auf, $bild);
			
			//set id for adding relations
			if(mysqli_stmt_execute($stmt)) {
				$id = $conn->insert_id;
			}

		} else {
			//update entry
			$id = $_POST['id'];
			$stmt = null;
			if ($bild != null || isset($_POST['bild-delete'])) {
				$stmt = $conn->prepare('UPDATE rasse SET bezeichnung = ?, lebenserwartung = ?, minimal_gewicht = ?, maximal_gewicht = ?, minimal_widerrist = ?, maximal_widerrist = ?, herkunft = ?, verwendung_arbeit = ?, verwendung_sozial = ?, gruppe_id = ?, geschichte = ?, zu_achten_auf = ?, bild = ? WHERE id = ?');
				$stmt->bind_param('siiiiisiiisssi', $bezeichnung, $lebenserwartung, $min_gewicht, $max_gewicht, $min_widerrist, $max_widerrist, $herkunft, $arbeit, $sozial, $gruppe, $geschichte, $zu_achten_auf, $bild, $id);
			} else {
					$stmt = $conn->prepare('UPDATE rasse SET bezeichnung = ?, lebenserwartung = ?, minimal_gewicht = ?, maximal_gewicht = ?, minimal_widerrist = ?, maximal_widerrist = ?, herkunft = ?, verwendung_arbeit = ?, verwendung_sozial = ?, gruppe_id = ?, geschichte = ?, zu_achten_auf = ? WHERE id = ?');
				$stmt->bind_param('siiiiisiiissi', $bezeichnung, $lebenserwartung, $min_gewicht, $max_gewicht, $min_widerrist, $max_widerrist, $herkunft, $arbeit, $sozial, $gruppe, $geschichte, $zu_achten_auf, $id);
			}
			$stmt->execute();
			$stmt->close();
			
			//delete old relations
			$del_char = $conn->prepare('DELETE FROM rasse_charakter WHERE rasse_id = ?');
			$del_char->bind_param('i', $id);
			$del_char->execute();
			$del_char->close();
			
			$del_farbe = $conn->prepare('DELETE FROM rasse_farbe WHERE rasse_id = ?');
			$del_farbe->bind_param('i', $id);
			$del_farbe->execute();
			$del_farbe->close();
			
			$del_fell = $conn->prepare('DELETE FROM rasse_fell WHERE rasse_id = ?');
			$del_fell->bind_param('i', $id);
			$del_fell->execute();
			$del_fell->close();
		}
		
		if ($id != null) {
			//add new relations
			foreach ($_POST['charakter'] as $val) {
				$char_id = null;
				if (is_numeric($val)) {
					$char_id = $val;
					
				} else {
					//add new entry
					$stmt_new_char = $conn->prepare('INSERT INTO charakter(bezeichnung) VALUES(?)');
					$stmt_new_char->bind_param('s', $val);
					
					if (mysqli_stmt_execute($stmt_new_char)) {
						$char_id = $conn->insert_id;
					}
				}
				if ($char_id != null) {
					$stmt_char = $conn->prepare('INSERT INTO rasse_charakter(rasse_id, charakter_id) VALUES(?,?)');
					$stmt_char->bind_param('ii', $id, $char_id);
					$stmt_char->execute();
					$stmt_char->close();
				}
			}
			
			foreach ($_POST['farbe'] as $val) {
				$farbe_id;
				if (is_numeric($val)) {
					$farbe_id = $val;
					
				} else {
					//add new entry
					$stmt_new_farbe = $conn->prepare('INSERT INTO farbe(bezeichnung) VALUES(?)');
					$stmt_new_farbe->bind_param('s', $val);
					
					if (mysqli_stmt_execute($stmt_new_farbe)) {
						$farbe_id = $conn->insert_id;
					}
				}
				if ($farbe_id != null) {
					$stmt_farbe = $conn->prepare('INSERT INTO rasse_farbe(rasse_id, farbe_id) VALUES(?,?)');
					$stmt_farbe->bind_param('ii', $id, $farbe_id);
					$stmt_farbe->execute();
					$stmt_farbe->close();
				}
			}
			
			foreach ($_POST['fell'] as $val) {
				$fell_id;
				if (is_numeric($val)) {
					$fell_id = $val;
					
				} else {
					//add new entry
					$stmt_new_fell = $conn->prepare('INSERT INTO fell(bezeichnung) VALUES(?)');
					$stmt_new_fell->bind_param('s', $val);
					
					if (mysqli_stmt_execute($stmt_new_fell)) {
						$fell_id = $conn->insert_id;
					}
				}
				if ($fell_id != null) {
					$stmt_fell = $conn->prepare('INSERT INTO rasse_fell(rasse_id, fell_id) VALUES(?,?)');
					$stmt_fell->bind_param('ii', $id, $fell_id);
					$stmt_fell->execute();
					$stmt_fell->close();
				}
			}
		}
		
		//redirect to list view
		$url = '../list/rasselist.php';
		header('location: ' .$url);
		exit();
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
    <h1 class="page-title">Hunderasse Formular</h1>
    <form method="post" id="rasse-form" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        <label for="bezeichnung">Bezeichnung</label><br>
        <input type="text" name="bezeichnung" id="bezeichnung" value="<?php echo utf8_encode($bezeichnung); ?>"><br>
        <label for="lebenserwartung">Lebenserwartung</label><br>
        <input type="number" name="lebenserwartung" id="lebenserwartung" value="<?php echo $lebenserwartung; ?>"><br>
        <label for="min-gewicht">Minimum Gewicht (kg)</label><br>
        <input type="number" name="min-gewicht" id="min-gewicht" min="0" max="100" value="<?php echo $min_gewicht; ?>"><br>
        <label for="max-gewicht">Maximum Gewicht (kg)</label><br>
        <input type="number" name="max-gewicht" id="max-gewicht" min="0" max="100" value="<?php echo $max_gewicht; ?>"><br>
        <label for="min-widerrist">Minimum Widerrist (cm)</label><br>
        <input type="number" name="min-widerrist" id="min-widerrist" min="0" max="200" value="<?php echo $min_widerrist; ?>"><br>
        <label for="max-widerrist">Maximum Widerrist (cm)</label><br>
        <input type="number" name="max-widerrist" id="max-widerrist" min="0" max="200" value="<?php echo $max_widerrist; ?>"><br>
        <label for="herkunft">Herkunft</label><br>
        <input type="text" name="herkunft" id="herkunft" value="<?php echo utf8_encode($herkunft); ?>"><br>
        <label for="arbeit">Verwendung Arbeit</label>
        <input type="checkbox" name="arbeit" id="arbeit" <?php echo $arbeit ? " checked" : ""; ?>><br>
        <label for="sozial">Verwendung Sozial</label>
        <input type="checkbox" name="sozial" id="sozial" <?php echo $sozial ? " checked" : ""; ?>><br>
        <label for="geschichte">Geschichte</label><br>
        <textarea rows="2" name="geschichte" form="rasse-form"><?php echo utf8_encode($geschichte); ?></textarea><br>
        <label for="zu-achten-auf">Zu achten auf</label><br>
        <textarea rows="2" name="zu-achten-auf" form="rasse-form"><?php echo utf8_encode($zu_achten_auf); ?></textarea><br>
        <label for="bild">Bild</label><br>
        <input type="file" name="bild" id="bild"><br>
		<label for="bild-delete">Aktuelles Bild löschen</label>
		<input type="checkbox" name="bild-delete" id="bild-delete"><br>
        <label for="gruppe">Gruppe</label><br>
        <select name="gruppe" id="gruppe">
			<?php
				$query = "SELECT * FROM gruppe";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'" .($row['id'] == $gruppe ? " selected" : "") .">" .utf8_encode($row['bezeichnung']) ."</option>";
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
					echo "<option value='" .$row['id'] ."'" .(in_array($row['id'], $charakter) ? " selected" : "") .">" .utf8_encode($row['bezeichnung']) ."</option>";
				}
			?>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-charakter" id="custom-charakter">
            <button type="button" class="custom-input-button" onclick="add_custom_charakter()">+</button>
        </div>
        <label for="farbe">Farbe</label><br>
        <select name="farbe[]" id="farbe" multiple>
            <?php
				$query = "SELECT * FROM farbe";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'" .(in_array($row['id'], $farbe) ? " selected" : "") .">" .utf8_encode($row['bezeichnung']) ."</option>";
				}
			?>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-farbe" id="custom-farbe">
            <button type="button" class="custom-input-button" onclick="add_custom_farbe()">+</button>
        </div>
        <label for="fell">Fell</label><br>
        <select name="fell[]" id="fell" multiple>
            <?php
				$query = "SELECT * FROM fell";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<option value='" .$row['id'] ."'" .(in_array($row['id'], $fell) ? " selected" : "") .">" .utf8_encode($row['bezeichnung']) ."</option>";
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