<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Gruppe Formular</title>
</head>
<body>
    <h1 class="page-title">Rassengruppe Formular</h1>
    <form action="../form/gruppeform.php" method="post" id="gruppe-form">
        <label for="nummer">Gruppennummer</label>
        <input type="number" name="nummer" id="nummer"><br>
        <label for="bezeichnung">Bezeichnung</label><br>
        <input type="text" name="bezeichnung" id="bezeichnung"><br>
        <div class="button-layout">
            <button class="button btn-primary" type="submit" id="submit">Absenden</button>
            <a href="../list/gruppelist.php"><button type="button" class="button">Abbrechen</button></a>
        </div>
    </form>
</body>
</html>