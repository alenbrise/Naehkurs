<?php checkForAuthorization(true); ?>
<body>
   <?php 
   $pagename = "users";
   echo getAdminNavbar($pagename);
   ?>
</body>
<?php
if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded'] == 1) {
        echo "<div class='alert alert-success' role='alert'>Die Benutzerdaten wurden erfolgreich aktualisiert!</div>";
    }
}
$linecolor = false;

@$sortieren = $_GET['sortieren'];
if (!isset($sortieren)) {
    $sortieren = "Nachname";
    $link = getDbConnection();

    $abfrage = "SELECT Benutzer_ID, Vorname, Nachname, Ort, Email FROM `benutzer` ORDER BY $sortieren";

    $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//Tabellenüberschrift erstellen (automatisch)
    echo "<table class='table table-dark' border='0'>";

//wir stellen den tabellentitel als sortierlink dar
    echo "<tr bgcolor='#DCDCDC'>";
    echo "<th scope='col'>Benutzer ID</th>";
    echo "<th scope='col'>Vorname</th>";
    echo "<th scope='col'>Nachname</th>";
    echo "<th scope='col'>Ort</th>";
    echo "<th scope='col'>E-Mail</th>";
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
            if ($key == "Benutzer_ID") {
                $row = $value;
            }
        }
        echo "<td><a class='btn btn-default' href=index.php?page=editUser&userID=$row>bearbeiten</a>";
        echo"</tr>";
    }

    echo "</table>";
    mysqli_close($link);
}
?>