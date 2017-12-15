<?php 
require "./includes/db.inc.php";
$link =  getDbConnection();

$abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE Kursdatum >= Curdate()";

$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");
mysqli_query($link, "SET NAMES 'utf8'");

$courseDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseDetails[$key] = $value;
    }
}
?>
<h1>Teilnehmerliste zum Kurs <?php echo $courseDetails["Kursname"]?> </h1>



