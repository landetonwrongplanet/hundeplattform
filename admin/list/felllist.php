<!DOCTYPE html>
<html lang="en">
<?php
	include('../../config/config.php');
	
	if (isset($_POST['delete'])) {	
		$id = $_POST['delete-id'];
		
		//delete relations
		$rel_stmt = $conn->prepare('DELETE FROM rasse_fell WHERE fell_id = ?');
		$rel_stmt->bind_param('i', $id);
		$rel_stmt->execute();
		$rel_stmt->close();
		
		//delete entry
		$stmt = $conn->prepare('DELETE FROM fell WHERE id = ?');
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
    <title>Fell Verwaltung</title>
</head>
<script src="../../js/adminscript.js"></script>
<body>
    <h1 class="page-title">Fell Verwaltung</h1>

    <div class="button-layout">
		<form style="margin:0; padding:0" action="../form/fellform.php" method="post">
			<button type="submit" id="add" class="button btn-primary">Hinzufügen</button>
		</form>
		<form style="margin:0; padding:0" action="../form/fellform.php" method="get">
			<input type="hidden" name="id" id="selected-id">
			<button type="submit" id="edit" class="button">Bearbeiten</button>
		</form>
		<form id="deleteForm" style="margin:0; padding:0" method="post">
			<input type="hidden" name="delete-id" id="delete-id">
			<button type="submit" name="delete" id="delete" class="button btn-delete" onClick="return confirm('Sind Sie sicher, dass Sie löschen möchten ?')?this.form.action='<?php echo $_SERVER['PHP_SELF'] ?>':false;">Löschen</button>
		</form>
        <a href="../dashboard.html"><button type="button" class="button">Zurück</button></a>
    </div>

    <div class="table-wrapper">
        <table>
            <tr>
                <th style="width:0"></th>
                <th style="width:0">Id</th>
                <th>Bezeichnung</th>
            </tr>
            <?php
				$query = "SELECT * FROM fell";
				$stmt = $conn->prepare($query);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					echo "<tr onclick='select(" .$row['id'] .")'>";
					echo "<td><input style='margin:0' type='radio' id='" .$row['id'] ."' name='entry'></td>";
					echo "<td>" .$row['id'] ."</td>";
					echo "<td>" .utf8_encode($row['bezeichnung']) ."</td>";
					echo "</tr>";
				}
			?>
        </table>
    </div>
</body>
</html>