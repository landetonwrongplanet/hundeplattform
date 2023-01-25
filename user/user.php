
<?php 


$hostname = "localhost";
$username = "bsfh";
$password = "151Mhfsb";
$db = "hunde";


$dbconnect=mysqli_connect($hostname,$username,$password,$db);

if ($dbconnect->connect_error) {
  die("Database connection failed: " . $dbconnect->connect_error);
}


if(isset($_POST['submit'])) {
    $name=$_POST['surname'];
    $surname=$_POST['lastname'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password1']
    
    $query = "INSERT INTO test (vorname, nachname, benutzername, email, passwort)
    VALUES ('$name', '$surname', '$username', '$email', '$password')";


if (!mysqli_query($dbconnect, $query)) {
    die('An error occurred when submitting your review.');
} else {
  echo "Thanks for your review.";
}

}
?>



<?php
/*
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
        $statement = $conn->prepare("SELECT * FROM user_login WHERE email = $email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $password1 = password_hash($password1, PASSWORD_DEFAULT);
        
        $statement = $conn->prepare("INSERT INTO user_login (surname, lastname, username, email, `password`) VALUES ('$surname', '$lastname', '$username', '$email', '$password1')");
        $result = $statement->execute(array('email' => $email, 'password1' => $password1));
        
        if($result) {        
            echo 'Du wurdest erfolgreich registriert.Nun kannst du dich einloggen';
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}*/

?>

 
</body>
</html>