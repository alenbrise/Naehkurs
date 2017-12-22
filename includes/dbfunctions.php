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
    $newUser = false;
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
            echo "<div class='alert alert-danger' role='alert'>Diese E-Mail wurde bereits erfasst!</div>";
        } else if ($password1 != $password2) {
            echo "<div class='alert alert-danger' role='alert'>Ihre Passwörter stimmen nicht überein!</div>";
        } else {
            // Benutzer erfassen, weil noch nicht in DB vorhanden
            $insert = "INSERT INTO benutzer (`Benutzer_ID`, `Email`, `Passwort`, `Anrede`, `Vorname`, `Nachname`, `Adresse`, `PLZ`, `Ort`) VALUES('', '$email', '$pass', '$gender', '$firstname', '$lastname', '$address', '$zipcode', '$city')";
            mysqli_query($link, $insert)or die("DB-Eintrag hat nicht geklappt!");
            $newUser = true;
            header("Location:index.php?page=startpage&forwarded=1");
            return $newUser;
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
    header("Location:index.php?page=adminHome&forwarded=2");

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
        $billID = getBillID($userID, $courseID);
        sendBill($_SESSION['benutzer_id'], $name . " " . $surname, $userID, $billID, $courseID);
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
    mysqli_close($link);
    return $userID;
}

function getCourseIDFromName($name) {
    $link = getDbConnection();
    $abfrage = "SELECT Kurs_ID FROM `kurs` WHERE Kursname='$name'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        $courseID = $row["Kurs_ID"];
    }
    mysqli_close($link);
    return $courseID;   
}

function getBillID($userID, $courseID) {
    $link = getDbConnection();
    $abfrage = "SELECT Rechnung_ID FROM `kursanmeldung` WHERE Kurs_ID='$courseID' AND Benutzer_ID='$userID'";
    $res = mysqli_query($link, $abfrage)or die("DB-Eintrag hat nicht geklappt!");
    while ($row = mysqli_fetch_Assoc($res)) {
        $billID = $row["Rechnung_ID"];
    }
    return $billID;

    mysqli_close($link);
}

function getBookingByBookingId($bookingId) {
    $abfrage = "SELECT * FROM `kursanmeldung` WHERE Rechnung_ID = $bookingId";
    $res = mysqli_query(getDbConnection(), $abfrage) or die("Abfrage nicht geklappt");
    $bookingDetails = array();

    //form fields are filled with current values
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $bookingDetails[$key] = $value;
        }
    }
    return $bookingDetails;
}

function updateParticipantStatus($userId, $courseId, $status) {
    $status = $_POST['Anmeldestatus'];
    $link = getDbConnection();
    $update = "UPDATE `kursanmeldung` SET Anmeldestatus='$status' WHERE Benutzer_ID='$userId' AND Kurs_ID='$courseId'";
    mysqli_query($link, $update) or die("Eintrag nicht geklappt");

    $abfrage = "SELECT Email, Vorname, Nachname FROM `benutzer` WHERE $userId = Benutzer_ID";
    $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

    $userDetails = array();
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $userDetails[$key] = $value;
        }
    }

    $abfrage = "SELECT Kursname, Kursdatum FROM `kurs` WHERE $courseId=Kurs_ID";
    $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

    $courseDetails = array();
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $courseDetails[$key] = $value;
        }
    }

    $billID = getBillID($userId, $courseId);
    echo $status;
    if ($status == "definitiv") {
        sendDef($userDetails["Email"], $billID, $userDetails["Vorname"] . " " . $userDetails["Nachname"], $courseId, $courseDetails["Kursname"], $courseDetails["Kursdatum"]);
    }

    mysqli_close($link);
}

function getUsernameByBookingId($bookingId) {

    $booking = getBookingByBookingId($bookingId);
    $course = getCourseNameByBookingId($bookingId);

    $abfrage = "SELECT Vorname, Nachname FROM `benutzer` WHERE Benutzer_ID =" . $booking["Benutzer_ID"];
    $res = mysqli_query(getDbConnection(), $abfrage) or die("Abfrage nicht geklappt");
    $username = "";
    //form fields are filled with current values
    while ($zeile = mysqli_fetch_Assoc($res)) {
        $username = $zeile['Vorname'] . ' ' . $zeile['Nachname'];
        /* while (list($key, $value) = each($zeile)) {
          if ($key == "Vorname") {
          $userName = $value;
          } else if ($key == "Nachname") {
          $userName = $userName . " " . $value;
          }
          } */
    }
    return $username;
}

function getCourseNameByBookingId($bookingId) {

    $booking = getBookingByBookingId($bookingId);
    $abfrage = "SELECT Kursname FROM `kurs` WHERE Kurs_ID = " . $booking["Kurs_ID"];
    $res = mysqli_query(getDbConnection(), $abfrage) or die("Abfrage nicht geklappt");
    $courseName = "";
    //form fields are filled with current values
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $courseName = $value;
        }
    }
    return $courseName;
}

function deleteUserRegistrationByBookingId($bookingId) {
    $booking = getBookingByBookingId($bookingId);
    $userId = $booking['Benutzer_ID'];
    $courseId = $booking['Kurs_ID'];
    $query = "DELETE FROM `kursanmeldung` WHERE Kurs_ID='$courseId' AND Benutzer_ID='$userId'";
    mysqli_query(getDbConnection(), $query);

    $query = "SELECT Rechnung_ID FROM `kursanmeldung` WHERE Kurs_ID='$courseId'";
    $res = mysqli_query(getDbConnection(), $query) or die("Abfrage nicht geklappt");
    $count = mysqli_num_rows($res);

    $query = "SELECT Max_Plaetze FROM `kurs` WHERE Kurs_ID='$courseId'";
    $res = mysqli_query(getDbConnection(), $query) or die("Abfrage nicht geklappt");
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $max = $value;
        }
    }

    $freeSeats = $max - $count;

    $update = "UPDATE `kurs`SET Freie_Plaetze='$freeSeats' WHERE Kurs_ID='$courseId'";
    mysqli_query(getDbConnection(), $update) or die("Abfrage nicht geklappt");
}

function getRevenueByCourse($startdate, $enddate) {
    $abfrage = "SELECT kurs.Kursname as kursname, kurs.Kurs_ID as kursnummer, kurs.Kursdatum as kursdatum, SUM(kurs.Preis) as umsatz FROM `kurs` left join `kursanmeldung` ON kurs.Kurs_ID=kursanmeldung.Kurs_ID WHERE Kursdatum >= '" . date($startdate) . "' AND Kursdatum <= '" . date($enddate) . "' AND kursanmeldung.Anmeldestatus='definitiv' GROUP by kurs.Kurs_ID ORDER BY kurs.Kursdatum";
    $res = mysqli_query(getDbConnection(), $abfrage) or die("Abfrage nicht geklappt");
    $courseRevenues = array();
    //form fields are filled with current values
    while ($zeile = mysqli_fetch_Assoc($res)) {
        $courseRevenues[] = $zeile;
    }
    return $courseRevenues;
}

function deleteCourseByCourseId($courseId) {
    $query = "DELETE FROM `kurs` WHERE Kurs_ID='$courseId'";
    mysqli_query(getDbConnection(), $query);
}

?>