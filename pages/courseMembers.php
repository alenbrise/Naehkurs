<?php 
require "./includes/db.inc.php";
$link = mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zum Localhost möglich.");
mysqli_select_db($link, $dbname) or die("DB nicht gefunden");

$abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE Kursdatum >= Curdate()";

$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

$courseDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseDetails[$key] = $value;
    }
}
?>
<h1>Teilnehmerliste zum Kurs <?php echo $courseDetails["Kursname"]?> </h1>



