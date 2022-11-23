<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <title>Charakter Formular</title>
</head>
<body>
    <h1 class="page-title">Charakter Formular</h1>
    <form action="../form/charakterform.php" method="post" id="charakter-form">
        <label for="bezeichnung">Bezeichnung</label><br>
        <input type="text" name="bezeichnung" id="bezeichnung"><br>
        <div class="button-layout">
            <button class="button btn-primary" type="submit" id="submit">Absenden</button>
            <a href="../list/charakterlist.php"><button type="button" class="button">Abbrechen</button></a>
        </div>
    </form>
</body>
</html>