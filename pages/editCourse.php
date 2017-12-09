

<?php

require "./includes/db.inc.php";
$courseID = $_GET['courseID'];

$link = mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zum Localhost möglich.");
mysqli_select_db($link, $dbname) or die("DB nicht gefunden");

$abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum, Kursort, Kursstatus, Preis, Max_Plaetze, Min_Plaetze, Freie_Plaetze, Kurszeit FROM `kurs` WHERE Kurs_ID = $courseID";
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

$courseDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseDetails[$key] = $value;
    }
}
?>

<h1>Kurs bearbeiten</h1>
<form name ="editCourse" method="post" action="index.php?page=editCourse">
    <div class="form-group">
        <label for="txtCoursename">Kursname</label>
        <input type="text" class="form-control" name="txtCoursename" value="<?php echo $courseDetails["Kursname"]?>">
    </div>
    <div class="form-group">
        <label for="txtCoursetext">Kursbeschreibung</label>
        <textarea class="form-control" name="txtCoursetext" rows="5" cols="20"><?php echo $courseDetails["Kursbeschreibung"]?></textarea>
    </div>
    <div class="form-group">
        <label for="txtCourseplace">Kursort</label>
        <input type="text" class="form-control" name="txtCourseplace" value="<?php echo $courseDetails["Kursort"]?>">
    </div>
    <div class="form-group">
        <label for="txtCoursedate">Kursdatum</label>
        <input type="date" class="form-control" name="txtCoursedate" value="<?php echo $courseDetails["Kursdatum"]?>">
    </div>
    <div class="form-group">
        <label for="txtPrice">Preis</label>
        <input type="number" class="form-control" name="txtPrice" value="<?php echo $courseDetails["Preis"]?>">
    </div>
    <div class="form-group">
        <label for="txtMax">Max. Pl&auml;tze</label>
        <input type="number" class="form-control" name="txtMax" value="<?php echo $courseDetails["Max_Plaetze"]?>">
    </div>
    <div class="form-group">
        <label for="txtMin">Min. Pl&auml;tze</label>
        <input type="number" class="form-control" name="txtMin" value="<?php echo $courseDetails["Min_Plaetze"]?>">
    </div>
     <div class="form-group">
        <label for="txtTime">Uhrzeit</label>
        <input type="text" class="form-control" name="txtTime" value="<?php echo $courseDetails["Kurszeit"]?>">
    </div>
    <button type="submit" >Änderungen speichern</button>
    <button type="submit" >Kurs löschen</button>
</form>


