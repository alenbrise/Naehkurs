<?php checkForAuthorization(false) ?>
<body>
    <?php 
    $pagename = "userHome";
    echo getUserNavbar($pagename);
    ?>
</body>

<?php
if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded'] == 1) {
        echo "<div class='alert alert-success' role='alert'>Sie haben sich erfolgreich für den Kurs angemeldet!</div>";
    } else if ($_GET['forwarded'] == 2) {
        echo "<div class='alert alert-danger' role='alert'>Sie haben sich bereits für diesen Kurs eingetragen!</div>";
    } else if ($_GET['forwarded'] == 3) {
        echo "<div class='alert alert-danger' role='alert'>Der Kurs ist bereits ausgebucht!</div>";
    } else if ($_GET['forwarded'] == 4) {
        echo "<div class='alert alert-success' role='alert'>Ihre Daten wurden erfasst!</div>";
    }
}
$linecolor = false;

@$sortieren = $_GET['sortieren'];
if (!isset($sortieren)) {
    $sortieren = "Kursdatum";
}

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
    /* foreach($zeile as $key=>$value){
      echo "<td>".$value."</td>";//könnte auch den $key ausgeben
      } */

    while (list($key, $value) = each($zeile)) {
        echo "<td>" . $value . "</td>"; //könnte auch den $key ausgeben
        if ($key == "Kurs_ID") {
            $row = $value;
        }
    }
    echo "<td><a class='btn btn-default' href=index.php?page=courseDetail&courseID=$row>mehr</a></td>";
    echo"</tr>";
}
echo "</table>";
mysqli_close($link);
?>
