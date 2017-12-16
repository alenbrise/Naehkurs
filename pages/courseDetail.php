<?php checkForAuthorization(false);?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <div class="navbar-brand" >Kursdetails</div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php?page=userHome">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php?page=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php
$courseID = $_GET['courseID'];

if(isset($_POST['buttonClicked'])) {
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
    <!--<button id = "logout" type="submit">Ausloggen</button>-->
</form>