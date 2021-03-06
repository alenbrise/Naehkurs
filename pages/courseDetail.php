<?php checkForAuthorization(false); ?>
<body>
   <?php 
   $pagename = "courseDetail";
    echo getUserNavbar($pagename);
    ?>
</body>
<?php
$courseID = $_GET['courseID'];

if (isset($_POST['buttonClicked'])) {
    if ($_POST['buttonClicked'] == 1) {
        createNewEnrolment($courseID, getUserIDFromMail($_SESSION['benutzer_id']));
    }
}
$link = getDbConnection();

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
<script>
    function buttonClick(value) {
        document.getElementById('buttonClicked').value = value;
        document.getElementById('courseDetails').submit();
    }
</script>
<body>
    <h1><?php echo $courseDetails["Kursname"]; ?></h1>
    <form id="courseDetails" name ="courseDetails" method="post" action="index.php?page=courseDetail&courseID=<?php echo $courseID ?>">
        <div class="courseDescription"><?php echo $courseDetails["Kursbeschreibung"]; ?></div>
        <div class="courseDescription"><?php echo "Kursstatus: " . $courseDetails["Kursstatus"]; ?></div>    
        <div class="courseDescription"><?php echo "Kursdatum: " . $courseDetails["Kursdatum"]/* (\d).". ".$courseDetails["Kursdatum"](\M).". ".$courseDetails["Kursdatum"](\Y) */; ?></div> 
        <div class="courseDescription"><?php echo "Kurszeit: " . $courseDetails["Kurszeit"] . " Uhr"; ?></div>
        <div class="courseDescription"><?php echo "Kursort: " . $courseDetails["Kursort"]; ?></div>
        <div class="courseDescription"><?php echo "Preis: Fr." . $courseDetails["Preis"] . ".-"; ?></div>
        <div class="courseDescription"><?php echo "Maximale Anzahl Kursteilnehmer " . $courseDetails["Max_Plaetze"]; ?></div>
        <div class="courseDescription"><?php echo "Minimale Anzahl Kursteilnehmer " . $courseDetails["Min_Plaetze"]; ?></div>
        <div class="courseDescription"><?php echo "Anzahl freie Plätze: " . $courseDetails["Freie_Plaetze"]; ?></div>
        <input type="hidden" id="buttonClicked" name="buttonClicked">
        <input type="button" value="Anmelden" onclick="buttonClick(1);">
    </form>
</body>