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
      <div class="forms">
        <div class="registration">
        <div data-role="main" class="ui-content">
          <p>Registration</p>
          <form data-ajax="false" id="loginformular" method="post"
              action="index.php#login">
              <div data-role="fieldcontain">
                <fieldset>
                  <label for="surname">Vorname</label>
                  <input type="text" name="surname" id="s-name" focus><br>
                  <label for="lastname">Nachname</label>
                  <input type="text" name="username" id="username" focus><br>
                  <label for="username">Benutzername</label>
                  <input type="text" name="lastname" id="l-name" focus><br>
                  <label for="kennwort">Kennwort</label>
                  <input type="password" name="password" id="password"><br>
                  <input type="submit" value="register">
                </fieldset>
              </div>
          </form>
      </div>
      </div>
        <div class="login">
        <div data-role="main" class="ui-content">
          <p>Login</p>
          <form data-ajax="false" id="loginformular" method="post"
              action="index.php#login">
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
  </div>
  </body>
</html>