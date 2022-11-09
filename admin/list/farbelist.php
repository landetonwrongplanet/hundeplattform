<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Farbe Verwaltung</title>
</head>
<body>
    <h1 class="page-title">Farbe Verwaltung</h1>

    <div class="button-layout">
        <a href="../form/farbeform.php"><button type="button" class="button btn-primary">Hinzufügen</button></a>
        <a href="../form/farbeform.php"><button type="button" class="button">Bearbeiten</button></a>
        <button type="button" class="button btn-delete" onclick="delete_entity()">Löschen</button>
        <a href="../dashboard.html"><button type="button" class="button">Zurück</button></a>
    </div>

    <div class="table-wrapper">
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