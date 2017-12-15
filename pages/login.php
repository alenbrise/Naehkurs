<?php
if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded']==1) {
    prompt("Ihr neues Passwort sollten Sie in Kürze per E-Mail erhalten!");
    }
    if($_GET['forwarded']==2){
    prompt("Sie haben hier keinen Zutritt!");
    }
}

if (isset($_POST['txtEmail']) AND isset($_POST['txtPasswort'])) {
    $email = $_POST['txtEmail'];
    $pass = $_POST['txtPasswort'];
    $pass = md5($pass);

    // Datenbankverbindung


    $link = getDbConnection();

    // prüfen ob es user und passwort gibt
    $abfrage = "SELECT Benutzer_ID, IsAdmin, Email, Passwort FROM `benutzer` WHERE Email='$email' and Passwort='$pass'";
    $res = mysqli_query($link, $abfrage) or die("Verbindung zu Datenbank fehlgeschlagen");
    $count = mysqli_num_rows($res);
    
    if ($count == 1) {
        $isAdmin = isAdmin($email, $pass);
        
        setSessionID($email, $isAdmin);
        
        if ($isAdmin) {
            header("Location:index.php?page=adminHome");
        } else {
            header("Location:index.php?page=userHome");
        }
    } else {
        prompt("Login hat nicht geklappt. \\nVersuchen Sie es erneut!");
    }
    mysqli_close($link);
}
?>
<h1>Login</h1>

<form method="post" action="index.php?page=login">
    <div class="form-group">
        <label for="txtEmail">Email:</label>
        <input type="email" class="form-control" name="txtEmail" placeholder="E-Mail eingeben">
    </div>
    <div class="form-group">
        <label for="txtPasswort">Passwort:</label>
        <input type="password" class="form-control" name="txtPasswort" placeholder="Passwort">
    </div>
    <button type="submit">Anmelden</button>

    <div class="form-group">
        <a href="index.php?page=registration">Registrierung</a><br>
        <a href="index.php?page=passwordForgot">Passwort vergessen</a>
    </div>
</form>

