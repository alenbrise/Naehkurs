<?php

function getDbConnection() {
    include "./includes/db.inc.php";
    $link = mysqli_connect($servername, $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank");
    mysqli_select_db($link, $dbname) or die("Datenbank nicht gefunden!");
    mysqli_query($link, "SET NAMES 'utf8'");
    return $link;
}

function isAdmin($email, $pass) {
    $link = getDbConnection();

    $query = "SELECT Benutzer_ID, IsAdmin, Email, Passwort FROM `benutzer` WHERE Email='$email' and Passwort='$pass'";
    $res = mysqli_query($link, $query) or die("Email oder Passwort stimmt nicht!");
    $isAdmin = false;
    while ($row = mysqli_fetch_Assoc($res)) {
        $isAdmin = $row["IsAdmin"];
    }
    return $isAdmin;
    //$count = mysqli_num_rows($res);
}

//reset Password for given E-Mail-Address
function setPassword($email, $password) {
    $link = getDbConnection();

    // prüfen ob email bereits vorhanden
    $abfrage = "SELECT email,Nachname,Vorname FROM `benutzer` WHERE Email='$email'";
    $ergebnis = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt!");
    $count = mysqli_num_rows($ergebnis);

    while ($zeile = mysqli_fetch_Assoc($ergebnis)) {
        while (list($key, $value) = each($zeile)) {
            if ($key == "Nachname") {
                $surname = $value;
            } if ($key == "Vorname") {
                $name = $value;
            }
        }
    }

    if ($count == 1) {
        $name = $name . " " . $surname;
        $pw = md5($password);
        $update = "UPDATE `benutzer`SET Passwort='$pw' WHERE Email='$email'";
        mysqli_query($link, $update) or die("Eintrag hat nicht geklappt!");
        sendPW($email, $name, $password);
    } else {
        prompt("Diese E-Mail-Adresse existiert nicht!");
    }
    mysqli_close($link);
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

        // Create connection
        $link = getDbConnection();

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
            header("Location:index.php?page=userHome&forwarded=4");
        }

        // Datenbankverbindung beenden
        mysqli_close($link);
    }
}

function createCourse($coursename, $coursetext, $courseplace, $coursedate, $price, $max, $min) {

    // Create connection
    $link = getDbConnection();

    $insert = "INSERT INTO kurs (`Kurs_ID`, `Kursname`, `Kursbeschreibung`, `Kursort`, `Kursdatum`, `Kursstatus`, `Preis`, `Max_Plaetze`, `Min_Plaetze`, `Freie_Plaetze`) VALUES('', '$coursename', '$coursetext', '$courseplace', '$coursedate', 'offen', '$price', '$max', '$min', '$max')";
    mysqli_query($link, $insert)or die("DB-Eintrag hat nicht geklappt!");
    prompt("Daten wurden erfasst!");

    // Datenbankverbindung beenden
    mysqli_close($link);
}

function createNewEnrolment($courseID, $userID) {
    $link = getDbConnection();
    $alreadyEnrolled = false;
    $freeSeats = 0;

    $abfrage = "SELECT Benutzer_ID FROM `kursanmeldung` WHERE Kurs_ID='$courseID'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        if ($row["Benutzer_ID"] == $userID) {
            $alreadyEnrolled = true;
        }
    }

    $abfrage = "SELECT Freie_Plaetze FROM `kurs` WHERE Kurs_ID='$courseID'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        $freeSeats = $row["Freie_Plaetze"];
    }

    $abfrage = "SELECT Vorname, Nachname FROM `benutzer` WHERE Benutzer_ID='$userID'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        $name = $row["Vorname"];
        $surname = $row["Nachname"];
    }

    if (!$alreadyEnrolled && $freeSeats > 0) {
        $insert = "INSERT INTO kursanmeldung (`Rechnung_ID`, `Benutzer_ID`, `Kurs_ID`, `Anmeldestatus`) VALUES('', '$userID', '$courseID', 'provisorisch')";
        mysqli_query($link, $insert)or die("DB-Eintrag hat nicht geklappt!");
        $freeSeats--;
        $update = "UPDATE `kurs`SET Freie_Plaetze='$freeSeats' WHERE Kurs_ID='$courseID'";
        mysqli_query($link, $update)or die("DB-Eintrag hat nicht geklappt!");

        sendBill($_SESSION['benutzer_id'], $name." ".$surname, getBillID($userID, $courseID), $courseID);
        header("Location:index.php?page=userHome&forwarded=1");
        mysqli_close($link);
    } else if ($alreadyEnrolled) {
        header("Location:index.php?page=userHome&forwarded=2");
    } else if ($freeSeats <= 0) {
        header("Location:index.php?page=userHome&forwarded=3");
    }
}

function getUserIDFromMail($email) {
    $link = getDbConnection();
    $abfrage = "SELECT Benutzer_ID FROM `benutzer` WHERE Email='$email'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        $userID = $row["Benutzer_ID"];
    }
    return $userID;

    mysqli_close($link);
}

function getBillID($userID, $courseID){
    $link = getDbConnection();
    $abfrage = "SELECT Rechnung_ID FROM `kursanmeldung` WHERE Kurs_ID='$courseID' AND Benutzer_ID='$userID'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        $billID = $row["Rechnung_ID"];
    }
    return $billID;

    mysqli_close($link);
}

?>
