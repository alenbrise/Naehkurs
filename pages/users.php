<?php checkForAuthorization(true); ?>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div class="navbar-brand" >Benutzerübersicht</div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?page=adminHome">Home</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menü <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?page=createNewCourse">Kurs erstellen</a></li>
                            <li><a href="index.php?page=revenue">Abrechnung ausgeben</a></li>
                            <li><a href="index.php?page=adminHome">Rechnung aufrufen</a></li>
                            <li><a href="index.php?page=users">Benutzerübersicht</a></li>
                        </ul>
                    </li> 
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?page=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>
<?php
if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded'] == 1) {
        prompt("Die Benutzerdaten wurden aktualisiert!");
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
        echo "<td><a href=index.php?page=editUser&userID=$row>bearbeiten</a>";
        echo"</tr>";
    }

    echo "</table>";
    mysqli_close($link);
}
?>