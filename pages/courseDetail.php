<?php
checkForAuthorization(false);
$courseID = $_GET['courseID'];

$link =  getDbConnection();

$abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum, Kursort, Kursstatus, Preis, Max_Plaetze, Min_Plaetze, Freie_Plaetze, Kurszeit FROM `kurs` WHERE $courseID = Kurs_ID";

$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

$courseDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseDetails[$key] = $value;
    }
}
mysqli_close($link);
?>

<h1><?php echo $courseDetails["Kursname"]; ?></h1>
<div class="courseDescription"><?php echo $courseDetails["Kursbeschreibung"]; ?></div>
<div class="courseDescription"><?php echo "Kursstatus: " . $courseDetails["Kursstatus"]; ?></div>    
<div class="courseDescription"><?php echo "Kursdatum: " . $courseDetails["Kursdatum"]/* (\d).". ".$courseDetails["Kursdatum"](\M).". ".$courseDetails["Kursdatum"](\Y) */; ?></div> 
<div class="courseDescription"><?php echo "Kurszeit: " . $courseDetails["Kurszeit"] . " Uhr"; ?></div>
<div class="courseDescription"><?php echo "Kursort: " . $courseDetails["Kursort"]; ?></div>
<div class="courseDescription"><?php echo "Preis: Fr." . $courseDetails["Preis"] . ".-"; ?></div>
<div class="courseDescription"><?php echo "Maximale Anzahl Kursteilnehmer " . $courseDetails["Max_Plaetze"]; ?></div>
<div class="courseDescription"><?php echo "Minimale Anzahl Kursteilnehmer " . $courseDetails["Min_Plaetze"]; ?></div>
<div class="courseDescription"><?php echo "Anzahl freie Plätze: " . $courseDetails["Freie_Plaetze"]; ?></div>
<button type="submit">Anmelden</button>
<button id = "logout" type="submit">Ausloggen</button>