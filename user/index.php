<?php
session_start();

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Hundeplattform</title>
  </head>
  <body>
  <div class="container">
      <div class="header">
        <div class="logo"><img src="logo.jpeg" alt="Dog on computer" width="180" height="200" class="logo"></div>
        <div class="sitetitle"><p class="title">Hundeplattform</p></div>
      </div>
        <div class="landing">
            <div class="forms">
              <div class="registration">
              <p>Registration</p>
                <form  method="post" action="user.php">
                        <label for="surname">Vorname</label><br>
                        <input type="text" name="surname" ><br>
                        <label for="lastname">Nachname</label><br>
                        <input type="text" name="lastname" ><br>
                        <label for="username">Benutzername</label><br>
                        <input type="text" name="username" ><br>
                        <label for="email">E-Mail</label><br>
                        <input type="email" name="email" ><br>
                        <label for="password">Kennwort</label><br>
                        <input type="password" name="password1" ><br>
                        <input type="submit" value="register" name="submit" class="button">
                </form>
            </div>
            <div class="login">
              <p>Login</p>
                <form action="user.php" method="post">
                  <label for="surname">Vorname</label><br>
                  <input type="text" name="vorname"><br>
                  <label for="lastname">Nachname</label><br>
                  <input type="text" name="nachname"><br>
                  <input type="submit" value="login" name="submit" class="button" >
                </form>
            </div>
          </div>
      <div class="intro">
        <p class="landingtext">
            Hallo! Sie scheinen eine interessierte Hundeperson zu sein. 
            Hier sind Sie auf jeden Fall am richtigen Ort. 
            Nach der erfolgreichen Registrierung, 
            können Sie sich einloggen um von unserem Datenbankservice vollumfänglich zu profitieren.
            Sie können zu Hunderassen nachlesen, 
            Bilder zu den jeweiligen Rassen ansehen und sich via Quiz die passende Rasse heraussuchen.
        </p>
      </div>
    </div>
      <div class="footer">
        <p class="author">Author: Beth Williams, Ilenia Castano</p>
      </div>
    </div> 
  </body>
</html>