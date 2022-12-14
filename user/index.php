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
        <div data-role="main" class="ui-content">
          <p>Registration</p>
          <form data-ajax="false" id="loginformular" method="post"
              action="user.php">
              <div data-role="fieldcontain">
                <fieldset>
                  <label for="surname">Vorname</label>
                  <input type="text" name="surname" id="s-name" focus><br>
                  <label for="lastname">Nachname</label>
                  <input type="text" name="lastname" id="l-name" focus><br>
                  <label for="username">Benutzername</label>
                  <input type="text" name="username" id="username" focus><br>
                  <label for="email">E-Mail</label>
                  <input type="email" name="email" id="email" focus><br>
                  <label for="password">Kennwort</label>
                  <input type="password" name="password1" id="password1"><br>
                  <label for="password2">Kennwort wiederholen</label>
                  <input type="password" name="password2" id="password2"><br>
                  <input type="submit" value="register">
                </fieldset>
              </div>
          </form>
      </div>
      </div>
        <div class="login">
        <div data-role="main">
          <p>Login</p>
          <form data-ajax="false" id="loginformular" method="post"
              action="user.php">
              <div data-role="fieldcontain">
                <fieldset>
                  <label for="username">Benutzername</label>
                  <input type="text" name="username" id="username" focus><br>
                  <label for="password">Kennwort</label>
                  <input type="password" name="password" id="password"><br>
                  <input type="submit" value="login">
                </fieldset>
              </div>
          </form>
        </div>
        </div>
    </div>
    <div class="intro">
      <p class="landingtext">
        Hallo! Sie scheinen eine interessierte Hundeperson zu sein. 
        Hier sind Sie auf jeden Fall am richtigen Ort. 
        Nach der erfolgreichen Registrierung, 
        k??nnen Sie sich einloggen um von unserem Datenbankservice vollumf??nglich zu profitieren.
        Sie k??nnen zu Hunderassen nachlesen, 
        Bilder zu den jeweiligen Rassen ansehen und sich via Quiz die passende Rasse heraussuchen.
      </p>
      <form action="user.php" method="post">
        <input type="text" name="vorname">
        <input type="text" name="nachname">
        <input type="submit" value="register" name="submit">
      </form>
    </div>
</div>
<div class="footer">
  <p>Author: Beth Williams, Ilenia Castano</p>
  
</div>
  </div>
  </body>
</html>