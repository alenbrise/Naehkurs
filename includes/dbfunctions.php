<!--
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <script type="text/javascript">
    //erstellt neuen Benutzer in der Datenbank
function checkUser($firstname, $lastname, $address, $zipcode, $city, $email, $password1, $password2) {
 
    if($firstname == "") {
    alert("Bitte tragen Sie Ihren Vornamen ein!");
    document.registration.txtFirstname.focus();
    return false;
    }
    if($lastname == "") {
    alert("Bitte geben sie Ihren Nachnamen ein!");
    document.registration.txtNachname.focus();
    return false;
    }
    if($address == "") {
    alert("Bitte geben sie Ihre Adresse ein!");
    document.registration.txtAddresse.focus();
    return false;
    }
    if($zipcode == "") {
    alert("Bitte geben sie Ihre PLZ ein!");
    document.registration.txtZipCode.focus();
    return false;
    }    
    if($city == "") {
    alert("Bitte geben sie Ihren Wohnort ein!");
    document.registration.txtCity.focus();
    return false;
    }    
    if($email == "") {
    alert("Bitte geben sie Ihre E-Mail Adresse ein!");
    document.registration.txtEmail.focus();
    return false;
    }
    if($password1 == "") {
    alert("Bitte geben sie ein Passwort ein!");
    document.registration.txtPassword.focus();
    return false;
    }
    if($password2 == "") {
    alert("Bitte geben sie Ihr Passwort nochmals ein!");
    document.registration.txtPasswordRepeat.focus();
    return false;
    }
    if($password1 < 8) {
    alert("Bitte geben sie ein Passwort mit mindestens 8 Zeichen ein!");
    document.registration.txtPassword.focus();
    return false;
    }
    
    $nr_length = document.registration.password1.value.replace("/[^0-9]/g", '').length;
    if($nr_length < 1){
        alert("Das Passwort muss mind. 1 Zahl beinhalten!");
        document.registration.password1.focus();
        return false;
    }    
    if (document.registration.password1.value == document.registration.password2.value)
    { 
        return true;         
    }else{  
        alert("Die Passwörter sind nicht identisch!");
        return false; 
    }
}
        
</script>
-->

<?php

//reset Password for given E-Mail-Address
function setPassword($email, $password) {
    include "db.inc.php";
    include "functions.php";

    // Create connection
    $link = mysqli_connect($servername, $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank");
    mysqli_select_db($link, $dbname) or die("Datenbank nicht gefunden!");

    // prüfen ob email bereits vorhanden
    $abfrage = "SELECT email,Nachname,Vorname FROM `benutzer` WHERE Email='$email'";
    $ergebnis = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt!");
    $count = mysqli_num_rows($ergebnis);

    while ($zeile = mysqli_fetch_Assoc($ergebnis)) {
        while (list($key, $value) = each($zeile)) {
            if ($key == "Nachname") {
                $surname = $value;
            } if($key == "Vorname"){
                $name = $value;
            }
        }
    }
    
    if ($count == 1) {
        $name = $name." ".$surname;
        $pw = md5($password);
        $update = "UPDATE `benutzer`SET Passwort='$pw' WHERE Email='$email'";
        mysqli_query($link, $update) or die("Eintrag hat nicht geklappt!");
        sendPW($email, $name, $password);
    } else {
        alert("Diese E-Mail-Adresse existiert nicht!");
       
    }
}

function createUser() {

    if (isset($_POST['gender']) and ( $_POST['txtFirstname']) and ( $_POST['txtNachname']) and ( $_POST['txtAddresse']) and ( $_POST['txtZipCode']) and ( $_POST['txtCity']) and ( $_POST['txtEmail']) and ( $_POST['txtPassword'])) {
        $gender = $_POST['gender'];
        $firstname = $_POST['txtFirstname'];
        $lastname = $_POST['txtNachname'];
        $address = $_POST['txtAddresse'];
        $zipcode = $_POST['txtZipCode'];
        $city = $_POST['txtCity'];
        $email = $_POST['txtEmail'];
        $password1 = $_POST['txtPassword'];
        $password2 = $_POST['txtPasswordRepeat'];
        $pass = md5($password1);

        include "db.inc.php";

// Create connection
        $link = mysqli_connect($servername, $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank");
        mysqli_select_db($link, $dbname) or die("Datenbank nicht gefunden!");

        mysqli_query($link, "SET NAMES 'utf8'");

        // prüfen ob email bereits vorhanden
        $abfrage = "SELECT email FROM `benutzer` WHERE Email='$email'";
        $ergebnis = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt!");
        $count = mysqli_num_rows($ergebnis);

        if ($count == 1) {
            echo "<font>Diese E-Mail-Adresse wurde bereits erfasst!</font>";
        } else {
            // Benutzer erfassen, weil noch nicht in DB vorhanden
            $insert = "INSERT INTO benutzer (`Benutzer_ID`, `Email`, `Passwort`, `Anrede`, `Vorname`, `Nachname`, `Adresse`, `PLZ`, `Ort`) VALUES('', '$email', '$pass', '$gender', '$firstname', '$lastname', '$address', '$zipcode', '$city')";
            mysqli_query($link, $insert)or die("DB-Eintrag hat nicht geklappt!");
            echo "<font>Daten wurden erfasst!!</font><br/>";
        }

        // Datenbankverbindung beenden
        mysqli_close($link);
    }
}

function createCourse($coursename, $coursetext, $courseplace, $coursedate, $price, $max, $min) {

    include "db.inc.php";
    include "functions.php";

    // Create connection
    $link = mysqli_connect($servername, $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank");
    mysqli_select_db($link, $dbname) or die("Datenbank nicht gefunden!");

    mysqli_query($link, "SET NAMES 'utf8'");

    $insert = "INSERT INTO kurs (`Kurs_ID`, `Kursname`, `Kursbeschreibung`, `Kursort`, `Kursdatum`, `Kursstatus`, `Preis`, `Max_Plaetze`, `Min_Plaetze`, `Freie_Plaetze`) VALUES('', '$coursename', '$coursetext', '$courseplace', '$coursedate', '', '$price', '$max', '$min', '$max')";
    mysqli_query($link, $insert)or die("DB-Eintrag hat nicht geklappt!");
    alert("Daten wurden erfasst!");

    // Datenbankverbindung beenden
    mysqli_close($link);
}
?>
