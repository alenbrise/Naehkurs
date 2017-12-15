<h1>Hallo Admin!</h1>
<?php
require "./includes/db.inc.php"; //anstelle von include, weil unbedingt erforderlich
$linecolor = false;

@$sortieren = $_GET['sortieren'];
if (!isset($sortieren)) {
    $sortieren = "Kursdatum";
}

$link =  getDbConnection();
mysqli_query($link, "SET NAMES 'utf8'");

$abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE Kursdatum >= Curdate()ORDER BY $sortieren";

$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//Tabellenüberschrift erstellen (automatisch)
echo "<table border='0'>";

//wir stellen den tabellentitel als sortierlink dar
echo "<tr bgcolor='#DCDCDC'>";
echo "<th>Kursnummer</th>";
echo "<th>Kursname</th>";
echo "<th>Kursbeschreibung</th>";
echo "<th>Kursdatum</th>";
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
        if ($key == "Kurs_ID") {
            $row = $value;
        }
    }
    echo "<td><a href=index.php?page=courseMembers&courseID=$row>Teilnehmerliste</a>\n"
    . "<a href=index.php?page=editCourse&courseID=$row>Kurs bearbeiten</a></td>";


    echo"</tr>";
}

echo "</table>";
mysqli_close($link);

