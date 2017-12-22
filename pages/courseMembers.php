<?php checkForAuthorization(true); ?>
<body>
   <?php
   $pagename = "courseMembers";
   echo getAdminNavbar($pagename);
   ?>
</body>

<?php
if(isset($_GET["userDeleted"])){
    echo "<div class='alert alert-success' role='alert'>Der Benutzer wurde erfolgreich gelöscht!</div>";
}

$courseID = $_GET['courseID'];
$link = getDbConnection();
$linecolor = false;

$courseDetails = array();
$abfrage = "SELECT Kurs_ID, Kursname, Kursdatum, Kurszeit FROM `kurs` WHERE Kurs_ID = $courseID";
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseDetails[$key] = $value;
    }
}

$coursename = $courseDetails["Kursname"];
$coursedate = $courseDetails["Kursdatum"];
$coursetime = $courseDetails["Kurszeit"];


$abfrage = "SELECT Vorname, Nachname, Email, Anmeldestatus, Rechnung_ID FROM `benutzer` JOIN `kursanmeldung` USING (Benutzer_ID) WHERE Kurs_ID=$courseID";

$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");


echo "<h1>$coursename</h1>";
//Tabellenüberschrift erstellen (automatisch)
echo "<table class='table table-dark' border='0'>";

//wir stellen den tabellentitel als sortierlink dar
echo "<tr bgcolor='#DCDCDC'>";
echo "<th scope='col'>Vorname</th>";
echo "<th scope='col'>Nachname</th>";
echo "<th scope='col'>E-Mail</th>";
echo "<th scope='col'>Anmeldestatus</th>";
echo "<th scope='col'>Rechnungsnr.</th>";
echo "<th scope='col'>&nbsp;</th>";
echo "<th scope='col'>&nbsp;</th>";
echo "</tr>";

//Tabelleninhalt auflisten
while ($zeile = mysqli_fetch_Assoc($res)) {
    if ($linecolor == true) {
        echo"<tr bgcolor='#DCDCDC'>";
        $linecolor = false;
    } else {
        echo "<tr>";
        $linecolor = true;
    }

    while (list ($key, $value) = each($zeile)) {
        echo "<td>" . $value . "</td>"; //könnte auch den $key ausgeben
        if ($key == "Benutzer_ID") {
            $row = $value;
        }else if($key == "Rechnung_ID"){
            $bookingID = $value;
        }
    }
    echo "<td><a class='btn btn-default' href=index.php?page=editBooking&bookingID=$bookingID>Anmeldung bearbeiten</a></td>";
    echo "<td><a class='btn btn-default' href=index.php?page=editBooking&deleteRegistration=1&bookingID=$bookingID>Anmeldung löschen</a></td>";
    echo"</tr>";
}

echo "</table>";

mysqli_close($link);
?>




