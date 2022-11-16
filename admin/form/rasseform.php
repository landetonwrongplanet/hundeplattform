<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	
	//process action if submitted else display form
	if (isset($_POST['submit'])) {
		$bezeichnung = utf8_decode($_POST['bezeichnung']);
		$lebenserwartung = $_POST['lebenserwartung'];
		$min_gewicht = $_POST['min-gewicht'];
		$max_gewicht = $_POST['max-gewicht'];
		$min_widerrist = $_POST['min-widerrist'];
		$max_widerrist = $_POST['max-widerrist'];
		$herkunft = utf8_decode($_POST['herkunft']);
		$arbeit = $_POST['arbeit'];
		$sozial = $_POST['sozial'];
		$gruppe = $_POST['gruppe'];
		$geschichte = utf8_decode($_POST['geschichte']);
		$zu_achten_auf = utf8_decode($_POST['zu-achten-auf']);
		$bild = null;
		if (!empty($_FILES['bild']['tmp_name'])) {
			$bild = file_get_contents($_FILES['bild']['tmp_name']);
		}
		if ($_POST['id'] == null) {
			//create new entry
			$stmt = $conn->prepare('INSERT INTO rasse(bezeichnung, lebenserwartung, minimal_gewicht, maximal_gewicht, minimal_widerrist, maximal:widerrist, herkunft, verwendung_arbeit, verwendung_sozial, gruppe_id, geschichte, zu_achten_auf, bild) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)');
			$stmt->bind_param('siiiiisiiissb', $bezeichnung, $lebenserwartung, $min_gewicht, $max_gewicht, $min_widerrist, $max_widerrist, $herkunft, $arbeit, $sozial, $gruppe, $geschichte, $zu_achten_auf, $bild);
			$stmt->execute();
			$stmt->close();
		} else {
			//update entry
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
    <form method="post" id="rasse-form">
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
            <option value="1">Hütehunde und Treibhunde</option>
            <option value="2">Pinscher, Schnauzer, Molosser und Schweizer Sennenhunde</option>
            <option value="3">Terrier</option>
            <option value="4">etc...</option>
        </select><br>
        <label for="charakter">Charakter</label><br>
        <select name="charakter" id="charakter" multiple>
            <option value="freundlich">Freundlich</option>
            <option value="aggressiv">Aggressiv</option>
            <option value="sanft">Sanft</option>
            <option value="loving">Loving</option>
            <option value="timid">Timid</option>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-charakter" id="custom-charakter">
            <button type="button" class="custom-input-button" onclick="add_custom_charakter()">+</button>
        </div>
        <label for="farbe">Farbe</label><br>
        <select name="farbe" id="farbe" multiple>
            <option value="braun">Braun</option>
            <option value="blonde">Blonde</option>
            <option value="schwarz">Schwarz</option>
            <option value="weiss">Weiss</option>
        </select><br>
        <div class="custom-input-layout">
            <input class="inline" type="text" name="custom-farbe" id="custom-farbe">
            <button type="button" class="custom-input-button" onclick="add_custom_farbe()">+</button>
        </div>
        <label for="fell">Fell</label><br>
        <select name="fell" id="fell" multiple>
            <option value="lang">Lang</option>
            <option value="kurz">Kurz</option>
            <option value="wavy">Wavy</option>
            <option value="curly">Curly</option>
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