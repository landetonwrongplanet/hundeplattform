<!DOCTYPE html>
<html lang="en">
<?php 
	include("config/config.php");
	$term = isset($_POST["submit"]) ? $_POST["term"] : "";
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Hunderasse Suche</title>
</head>
<body>
    <div style="text-align:center;padding-bottom:20px;">
		<h1 class="title" style="margin-bottom:0;">Hunderasse Suche</h1>
		<a href="/bsfh/hundeplattform/index.php">Zurück zur Startseite</a>
	</div>

	<form class="search-form" method="post" action="search.php">
		<input type="text" name="term" id="term" placeholder="Suchbegriff" value="<?php echo $term; ?>">
		<input type="submit" value="Suche" name="submit" id="submit">
	</form>
	
	<p></p>
	
	<table class="result-table">
		<tr>
			<th>Bild</th>
			<th>Bezeichnung</th>
			<th>Gruppe</th>
			<th>Grösse (cm)</th>
			<th>Gewicht (kg)</th>
			<th>Charakter</th>
			<th>Farbe</th>
			<th>Fell</th>
		</tr>
		<?php
			$term = "%$term%";
			$stmt = $conn->prepare("SELECT rasse.id as id, bild, rasse.bezeichnung, minimal_widerrist, maximal_widerrist, minimal_gewicht, maximal_gewicht, gruppe.bezeichnung as grp_bez, GROUP_CONCAT(DISTINCT charakter.bezeichnung SEPARATOR ', ') as char_bez, GROUP_CONCAT(DISTINCT farbe.bezeichnung SEPARATOR ', ') as farbe_bez, GROUP_CONCAT(DISTINCT fell.bezeichnung SEPARATOR ', ') as fell_bez
									FROM rasse 
									LEFT JOIN gruppe on rasse.gruppe_id = gruppe.id
									LEFT JOIN rasse_charakter on rasse_charakter.rasse_id = rasse.id
									LEFT JOIN charakter on charakter.id = rasse_charakter.charakter_id
									LEFT JOIN rasse_farbe on rasse_farbe.rasse_id = rasse.id
									LEFT JOIN farbe on farbe.id = rasse_farbe.farbe_id
									LEFT JOIN rasse_fell on rasse_fell.rasse_id = rasse.id
									LEFT JOIN fell on fell.id = rasse_fell.fell_id
									GROUP BY rasse.id
									HAVING rasse.bezeichnung LIKE ? 
                                    OR gruppe.bezeichnung LIKE ?
                                    OR char_bez LIKE ?
                                    OR farbe_bez LIKE ?
                                    OR fell_bez LIKE ?;");
									
			$stmt->bind_param('sssss', $term, $term, $term, $term, $term);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				echo "<td>";
				if ($row['bild'] != null) {
					echo "<img style='max-width:100px; max-height: 100px;' src='image-view.php?rasse_id=" .$row['id'] ."'>";
				}
				echo "</td>";
				echo "<td><a href='rasse.php?id=" .$row['id'] ."'>" .utf8_encode($row['bezeichnung']) ."</a></td>";
				echo "<td>" .utf8_encode($row['grp_bez']) ."</td>";
				echo "<td>" .$row['minimal_widerrist'] ." - " .$row['maximal_widerrist'] ."</td>";
				echo "<td>" .$row['minimal_gewicht'] ." - " .$row['maximal_gewicht'] ."</td>";
				echo "<td>" .utf8_encode($row['char_bez']) ."</td>";
				echo "<td>" .utf8_encode($row['farbe_bez']) ."</td>";
				echo "<td>" .utf8_encode($row['fell_bez']) ."</td>";
				echo "</tr>";
			}
		?>
	</table>
    
</body>
</html>