<?php
if (isset($_POST['txtEmail']) AND isset($_POST['txtPasswort'])) {
    $email = $_POST['txtEmail'];
    $pass = $_POST['txtPasswort'];
    $pass = md5($pass);

    // Datenbankverbindung
    include "./includes/db.inc.php";
    include "./includes/functions.php";

    $link = mysqli_connect($servername, $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank!");
    mysqli_select_db($link, $dbname) or die("Datenbank nicht gefunden!");

    // prüfen ob es user und passwort gibt
    $abfrage = "SELECT Email, Passwort FROM `benutzer` WHERE Email='$email' and Passwort='$pass'";
    $ergebnis = mysqli_query($link, $abfrage) or die("Email oder Passwort stimmt nicht!");
    $count = mysqli_num_rows($ergebnis);

    if ($count == 1) {
        if($email=="anasti@bluewin.ch"){
            header("Location:index.php?page=adminHome");
        }else{
            header("Location:index.php?page=userHome");
        }
    } else {
        alert("Login hat nicht geklappt. \\nVersuchen Sie es erneut!");
    }
}
?>
<h1>Login</h1>

<form method="post" action="index.php?page=login">
    <div class="form-group">
        <label for="txtEmail">Email:</label>
        <input type="email" class="form-control" name="txtEmail" placeholder="E-Mail eingebgen">
    </div>
    <div class="form-group">
        <label for="txtPasswort">Passwort:</label>
        <input type="password" class="form-control" name="txtPasswort" placeholder="Passwort">
    </div>
    <button type="submit">Anmelden</button>

    <div class="form-group">
        <a href="index.php?page=registration">Registrierung</a><br>
        <a href="index.php?page=passwortVergessen">Passwort vergessen</a>
    </div>
</form>

