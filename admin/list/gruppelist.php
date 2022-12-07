<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	
	if (isset($_POST['delete'])) {	
		$id = $_POST['delete-id'];
		
		$var = null;
		
		//remove relations
		$rel_stmt = $conn->prepare('UPDATE rasse SET gruppe_id = ? WHERE gruppe_id = ?');
		$rel_stmt->bind_param('ii', $var, $id);
		$rel_stmt->execute();
		$rel_stmt->close();
		
		//delete entry
		$stmt = $conn->prepare('DELETE FROM gruppe WHERE id = ?');
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
    <title>Gruppe Verwaltung</title>
</head>
<script src="../../js/adminscript.js"></script>
<body>
    <h1 class="page-title">Gruppe Verwaltung</h1>

   <div class="button-layout">
		<form style="margin:0; padding:0" action="../form/gruppeform.php" method="post">
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
                <th>Gruppennummer</th>
                <th>Bezeichnung</th>
            </tr>
            <?php
				$query = "SELECT * FROM gruppe";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<tr onclick='select(" .$row['id'] .")'>";
					echo "<td><input style='margin:0' type='radio' id='" .$row['id'] ."' name='entry'></td>";
					echo "<td>" .$row['id'] ."</td>";
					echo "<td>" .$row['gruppennummer'] ."</td>";
					echo "<td>" .utf8_encode($row['bezeichnung']) ."</td>";
					echo "</tr>";
				}
			?>
        </table>
    </div>
</body>
</html>