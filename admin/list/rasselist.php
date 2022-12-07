<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	
	if (isset($_POST['delete'])) {	
		$id = $_POST['delete-id'];
		
		//delete relations
		$char_stmt = $conn->prepare('DELETE FROM rasse_charakter WHERE rasse_id = ?');
		$char_stmt->bind_param('i', $id);
		$char_stmt->execute();
		$char_stmt->close();
		
		$farbe_stmt = $conn->prepare('DELETE FROM rasse_farbe WHERE rasse_id = ?');
		$farbe_stmt->bind_param('i', $id);
		$farbe_stmt->execute();
		$farbe_stmt->close();
		
		$fell_stmt = $conn->prepare('DELETE FROM rasse_fell WHERE rasse_id = ?');
		$fell_stmt->bind_param('i', $id);
		$fell_stmt->execute();
		$fell_stmt->close();
		
		//delete entry
		$stmt = $conn->prepare('DELETE FROM rasse WHERE id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
	}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Rasse Verwaltung</title>
</head>
<script src="../../js/adminscript.js"></script>
<body>
    <h1 class="page-title">Rasse Verwaltung</h1>

    <div class="button-layout">
		<form style="margin:0; padding:0" action="../form/rasseform.php" method="post">
			<input type="hidden" name="selected-id" id="selected-id">
			<button type="submit" name="add" id="add" class="button btn-primary">Hinzufügen</button>
			<button type="submit" name="edit" id="edit" class="button">Bearbeiten</button>
		</form>
		<form id="deleteForm" style="margin:0; padding:0" method="post">
			<input type="hidden" name="delete-id" id="delete-id">
			<button type="submit" name="delete" id="delete" class="button btn-delete">Löschen</button>
		</form>
        <a href="../dashboard.html"><button type="button" class="button">Zurück</button></a>
    </div>

    <div class="table-wrapper">
        <table>
            <tr>
                <th style="width:0"></th>
                <th style="width:0">Id</th>
                <th>Bezeichnung</th>
                <th>Gruppe</th>
                <th>Lebenserwartung</th>
                <th>Min Gewicht</th>
                <th>Max Gewicht</th>
                <th>Min Widerrist</th>
                <th>Max Widerrist</th>
                <th>Herkunft</th>
                <th>Arbeit</th>
                <th>Sozial</th>
                <th>Geschichte</th>
                <th>Zu achten auf</th>
                <th>Bild</th>
            </tr>
            <?php
				$query = "SELECT rasse.*, gruppe.bezeichnung as grp_bez FROM rasse LEFT JOIN gruppe on rasse.gruppe_id = gruppe.id";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<tr onclick='select(" .$row['id'] .")'>";
					echo "<td><input style='margin:0' type='radio' id='" .$row['id'] ."' name='entry'></td>";
					echo "<td>" .$row['id'] ."</td>";
					echo "<td>" .utf8_encode($row['bezeichnung']) ."</td>";
					echo "<td>" .$row['grp_bez'] ."</td>";
					echo "<td>" .$row['lebenserwartung'] ."</td>";
					echo "<td>" .$row['minimal_gewicht'] ."</td>";
					echo "<td>" .$row['maximal_gewicht'] ."</td>";
					echo "<td>" .$row['minimal_widerrist'] ."</td>";
					echo "<td>" .$row['maximal_widerrist'] ."</td>";
					echo "<td>" .utf8_encode($row['herkunft']) ."</td>";
					echo "<td>" .($row['verwendung_arbeit'] ? 'true' : 'false') ."</td>";
					echo "<td>" .($row['verwendung_sozial'] ? 'true' : 'false') ."</td>";
					echo "<td>" .utf8_encode(substr($row['geschichte'], 0, 50)) .(strlen($row['geschichte']) > 50 ? '...' : '') ."</td>";
					echo "<td>" .utf8_encode(substr($row['zu_achten_auf'],0 , 50)) .(strlen($row['zu_achten_auf']) > 50 ? '...' : '') ."</td>";
					#TODO: display image
					echo "<td>" /*.$row['bild']*/ ."</td>";
					echo "</tr>";
				}
			?>
        </table>
    </div>
</body>
</html>