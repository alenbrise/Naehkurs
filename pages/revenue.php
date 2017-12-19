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
                <div class="navbar-brand" >Abrechnung</div>
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
$linecolor = false;

@$sortieren = $_GET['sortieren'];
if (isset($_POST['txtStartdate']) and ( $_POST['txtEnddate'])) {
    $startDate = $_POST['txtStartdate'];
    $endDate = $_POST['txtEnddate'];

    $sortieren = "Kursdatum";

    $link = getDbConnection();

    $abfrage = "SELECT Kurs_ID FROM `kurs` WHERE Kursdatum >= '".date($startDate)."' AND Kursdatum <= '".date($endDate)."'";
    $res = mysqli_query($link, $abfrage) or die("Verbindung zu Datenbank fehlgeschlagen");
    $courseIDs = array();
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            array_push($courseIDs, $value);
        }
    }
    
    $numOfBookings = array();
    array_fill_keys($courseIDs, null);

    foreach ($courseIDs as $value) {
        $abfrage = "SELECT Kurs_ID FROM `kursanmeldung` WHERE Anmeldestatus='definitiv' AND Kurs_ID=$value";
        $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");
        $count = mysqli_num_rows($res);
        $numOfBookings[$value] = $count;
    }
    
    foreach ($numOfBookings as $courseID => $count) {
        $abfrage = "SELECT Preis FROM `kurs` WHERE Kurs_ID = $courseID";
        $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

        while ($zeile = mysqli_fetch_Assoc($res)) {
            while (list ($key, $value) = each($zeile)) {
                    $price = $value;
            }
        }
        
        $numOfBookings[$courseID] = $price * $count;
    }


    $abfrage = "SELECT Kurs_ID, Kursname, Kursdatum FROM `kurs` WHERE Kursdatum >= '".date($startDate)."' AND Kursdatum <= '".date($endDate)."'ORDER BY $sortieren";
    $res = mysqli_query($link, $abfrage) or die("Verbindung zu Datenbank fehlgeschlagen");

//Tabellenüberschrift erstellen (automatisch)
    echo "<table class='table table-dark' border='0'>";

//wir stellen den tabellentitel als sortierlink dar
    echo "<tr bgcolor='#DCDCDC'>";
    echo "<th scope='col'>Kursnummer</th>";
    echo "<th scope='col'>Kursname</th>";
    echo "<th scope='col'>Kursdatum</th>";
    echo "<th scope='col'>Umsatz</th>";
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
            echo "<td>CHF " . $numOfBookings [$row]. ".-</td>";
        echo"</tr>";
    }

    echo "</table>";
    mysqli_close($link);
}
?>

<body>
    <form name ="revenue" method="post" action="index.php?page=revenue">
        <div class="form-group">
            <label for="txtStartdate">Anfangsdatum</label>
            <input type="date" class="form-control" name="txtStartdate" placeholder="01.01.1900">
        </div>
        <div class="form-group">
            <label for="txtEnddate">Enddatum</label>
            <input type="date" class="form-control" name="txtEnddate" placeholder="01.01.1900">
        </div>
        <button type="submit" >Abrechnung erstellen</button>
    </form>
</body>