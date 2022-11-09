<!DOCTYPE html>
<html lang="en">
<?php
	#Config for database and session (eventually outsource)

	#Configuration details for the database connection
	$db_user = "bsfh";
	$pass = "151Mhfsb";
	$host = "localhost";
	$db = "hunde";
	
	#Connection stored here
	$conn = mysqli_connect($host, $db_user, $pass, $db) or die("A connection could not be established.");
	
	session_start();
	
	if(isset($_SESSION["user"])) {
		#do admin control
	} else {
		#redirect to login
	}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Charakter Verwaltung</title>
</head>
<body>
	<?php
		echo "test";
	?>
    <h1 class="page-title">Charakter Verwaltung</h1>

    <div class="button-layout">
        <a href="../form/charakterform.php"><button type="button" class="button btn-primary">Hinzufügen</button></a>
        <a href="../form/charakterform.php"><button type="button" class="button">Bearbeiten</button></a>
        <button type="button" class="button btn-delete" onclick="delete_entity()">Löschen</button>
        <a href="../dashboard.html"><button type="button" class="button">Zurück</button></a>
    </div>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Id</th>
                <th>Bezeichnung</th>
            </tr>
            <!--fetch rasse data with sql query-->
            <!--create new row for each record-->
        </table>
    </div>
</body>
</html>