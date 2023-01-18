<!DOCTYPE html>
<html lang="en">
<?php 
	include("config/config.php");
	$id = isset($_GET['id']) ? $_GET['id'] : 0;

	$stmt = $conn->prepare("SELECT rasse.*, gruppe.gruppennummer, gruppe.bezeichnung as grp_bez, GROUP_CONCAT(DISTINCT charakter.bezeichnung SEPARATOR ', ') as char_bez, GROUP_CONCAT(DISTINCT farbe.bezeichnung SEPARATOR ', ') as farbe_bez, GROUP_CONCAT(DISTINCT fell.bezeichnung SEPARATOR ', ') as fell_bez
									FROM rasse 
									LEFT JOIN gruppe on rasse.gruppe_id = gruppe.id
									LEFT JOIN rasse_charakter on rasse_charakter.rasse_id = rasse.id
									LEFT JOIN charakter on charakter.id = rasse_charakter.charakter_id
									LEFT JOIN rasse_farbe on rasse_farbe.rasse_id = rasse.id
									LEFT JOIN farbe on farbe.id = rasse_farbe.farbe_id
									LEFT JOIN rasse_fell on rasse_fell.rasse_id = rasse.id
									LEFT JOIN fell on fell.id = rasse_fell.fell_id
									WHERE rasse.id = ?
									GROUP BY rasse.id;");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$entry = $result->fetch_assoc();
	
	if ($entry == null) {
		header('Location: /bsfh/hundeplattform/search.php');
	}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo utf8_encode($entry['bezeichnung']); ?></title>
</head>
<body>
	<div style="text-align:center;padding-bottom:20px;">
		<h1 class="title" style="margin-bottom:0;"><?php echo utf8_encode($entry['bezeichnung']); ?></h1>
		<a href="/bsfh/hundeplattform/search.php">Zurück zur Suchseite</a>
	</div>
	<div class="rasse-card">
		<div>
		<?php
			echo "<img class='card-image' src='image-view.php?rasse_id=" .$entry['id'] ."'>";
		?>
		</div>
		<div>
			<?php
				echo "<p><span class='rasse-label'>Herkunft:</span> " .utf8_encode($entry['herkunft']) ."</p>";
				echo "<p><span class='rasse-label'>Gruppe:</span> " .$entry['gruppennummer'] .". " .utf8_encode($entry['grp_bez']) ."</p>";
				echo "<p><span class='rasse-label'>Lebenserwartung:</span> " .utf8_encode($entry['lebenserwartung']) ." Jahre</p>";
				echo "<p><span class='rasse-label'>Gewicht:</span> " .$entry['minimal_gewicht'] ."-" .$entry['maximal_gewicht'] ."kg</p>";
				echo "<p><span class='rasse-label'>Widerrist:</span> " .$entry['minimal_widerrist'] ."-" .$entry['maximal_widerrist'] ."cm</p>";
				echo "<p><span class='rasse-label'>Charakter:</span> " .utf8_encode($entry['char_bez']) ."</p>";
				echo "<p><span class='rasse-label'>Farbe:</span> " .utf8_encode($entry['farbe_bez']) ."</p>";
				echo "<p><span class='rasse-label'>Fell:</span> " .utf8_encode($entry['fell_bez']) ."</p>";
				echo "<p><span class='rasse-label'>Verwendung:</span> Sozial " 
						.($entry['verwendung_sozial'] ? "<span style='color:green;font-weight:bold;padding-right:10px;'>&#10004;</span>" : "<span style='color:red;font-weight:bold'>X</span>")
						."  Arbeit "
						.($entry['verwendung_arbeit'] ? "<span style='color:green;font-weight:bold;'>&#10004;</span>" : "<span style='color:red;font-weight:bold'>X</span>")
						."</p>";
			?>
		</div>
	</div>
	<div class="rasse-info">
		<h4 style="margin-bottom:0">Geschichte</h4>
		<?php
			echo utf8_encode($entry['geschichte']);
		?>
	</div>
	<div class="rasse-info">
		<h4 style="margin-bottom:0">Zu achten auf</h4>
		<?php
			echo utf8_encode($entry['zu_achten_auf']);
		?>
	</div>
</body>