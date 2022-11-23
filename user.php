<?php 
//session_start();
$pdo = new PDO('mysql:host=localhost;dbname=hunde', 'bsfhM151', '151Mhfsb');
?>
 
<?php
 
if(isset($_POST['register'])) {

    $error = false;
    $surname = $_POST['surname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if(strlen($surname) == 0) {
        echo 'Bitte einen Vornamen angeben<br>';
        $error = true;
    }
    if(strlen($lastname) == 0) {
        echo 'Bitte einen Nachnamen angeben<br>';
        $error = true;
    }
    if(strlen($username) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($password1) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($password1 != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM user_login WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $password_hash = password_hash($password1, PASSWORD_DEFAULT);
        
        $statement = $pdo->prepare("INSERT INTO user_login (surname, lastname, username, email, `password`) VALUES (:surname, :lastname, :username, :email, :`password`)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $password_hash));
        
        if($result) {        
            echo 'Du wurdest erfolgreich registriert.Nun kannst du dich einloggen';
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form action="?register=1" method="post">
E-Mail:<br>
<input type="email" size="40" maxlength="250" name="email"><br><br>
 
Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>
 
Passwort wiederholen:<br>
<input type="password" size="40" maxlength="250" name="passwort2"><br><br>
 
<input type="submit" value="Abschicken">
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>