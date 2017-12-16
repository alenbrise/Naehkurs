<?php checkForAuthorization(true);?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <div class="navbar-brand" >Teilnehmerliste</div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php?page=adminHome">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menü <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?page=createNewCourse">Kurs erstellen</a></li>
            <li><a href="index.php?page=adminHome">Abrechnung ausgeben</a></li>
            <li><a href="index.php?page=adminHome">Rechnung aufrufen</a></li>
          </ul>
        </li> 
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php?page=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

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

echo "<h1>$coursename</h1>";
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
     echo"</tr>";
}

echo "</table>";

mysqli_close($link);
?>




