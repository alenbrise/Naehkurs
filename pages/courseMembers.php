<?php 
$courseID = $_GET['courseID'];
$link =  getDbConnection();
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

echo "<h1>Teilnehmerliste zum Kurs ".$coursename."</h1>";
//Tabellenüberschrift erstellen (automatisch)
echo "<table border='0'>";

//wir stellen den tabellentitel als sortierlink dar
echo "<tr bgcolor='#DCDCDC'>";
echo "<th>Vorname</th>";
echo "<th>Nachname</th>";
echo "<th>E-Mail</th>";
echo "<th>Anmeldestatus</th>";
echo "<th>Rechnungsnr.</th>";
echo "</th>";
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
        }
    }
    /*echo "<td><a href=index.php?page=courseMembers&courseID=$row>Teilnehmerliste</a>\n"
    . "<a href=index.php?page=editCourse&courseID=$row>Kurs bearbeiten</a></td>";*/


    echo"</tr>";
}

echo "</table>";

mysqli_close($link);
?>




