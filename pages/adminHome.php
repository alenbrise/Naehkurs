<?php checkForAuthorization(true); ?>
<body>
   <?php
   $pagename = "adminHome";
   echo getAdminNavbar($pagename);
   ?>
</body>

<?php
if (isset($_GET['deletedCourse'])){
    echo "<div class='alert alert-success' role='alert'>Der Kurs konnte erfolgreich gelöscht werden</div>";
}
if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded'] == 1) {
        prompt("Die Kursdaten wurden aktualisiert!");
    }else if($_GET['forwarded'] == 2){
         echo "<div class='alert alert-success' role='alert'>Die Kursdaten konnten erfolgreich erfasst werden!</div>";
    }
}
$linecolor = false;

@$sortieren = $_GET['sortieren'];
if (!isset($sortieren)) {
    $sortieren = "Kursdatum";


    $link = getDbConnection();

    $abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE Kursdatum >= Curdate()ORDER BY $sortieren";

    $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//Tabellenüberschrift erstellen (automatisch)
    echo "<table class='table table-dark' border='0'>";

//wir stellen den tabellentitel als sortierlink dar
    echo "<tr bgcolor='#DCDCDC'>";
    echo "<th scope='col'>Kursnummer</th>";
    echo "<th scope='col'>Kursname</th>";
    echo "<th scope='col'>Kursbeschreibung</th>";
    echo "<th scope='col'>Kursdatum</th>";
    echo "<th scope='col'></th>";
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
        echo "<td><a class='btn btn-default' href=index.php?page=courseMembers&courseID=$row>Teilnehmerliste</a>"
                . "<a class='btn btn-default' href=index.php?page=editCourse&courseID=$row>Kurs bearbeiten</a>"
                . "<a class='btn btn-default' href=index.php?page=editCourse&deleteCourse=1&courseID=$row>Kurs löschen</a></td>";


        echo"</tr>";
    }

    echo "</table>";
    mysqli_close($link);
} else {
    header("Location:index.php?page=login&forwarded=2");
}
?>

