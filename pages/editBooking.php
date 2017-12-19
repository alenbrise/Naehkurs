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
                <div class="navbar-brand" >Kursanmeldung bearbeiten</div>
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
$bookingID = $_GET['bookingID'];
$link = getDbConnection();

$abfrage = "SELECT * FROM `kursanmeldung` WHERE Rechnung_ID = $bookingID";
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//form fields are filled with current values
$bookingDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $bookingDetails[$key] = $value;
    }
}

$abfrage = "SELECT Kursname FROM `kurs` WHERE Kurs_ID = " . $bookingDetails["Kurs_ID"];
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//form fields are filled with current values
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseName = $value;
    }
}


$abfrage = "SELECT Vorname, Nachname FROM `benutzer` WHERE Benutzer_ID = " . $bookingDetails["Benutzer_ID"];
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//form fields are filled with current values
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        if ($key == "Vorname") {
            $userName = $value;
        } else if ($key == "Nachname") {
            $userName = $userName . " " . $value;
        }
    }
}

echo "<h2> Kursanmeldung von " . $userName . " zum Kurs " . $courseName . "</h2>";

$userID = $bookingDetails["Benutzer_ID"];
$courseID = $bookingDetails["Kurs_ID"];

if(isset ($_POST['Anmeldestatus'])){
    $status = $_POST['Anmeldestatus'];

    $update = "UPDATE `kursanmeldung`SET Anmeldestatus='$status' WHERE Benutzer_ID='$userID' AND Kurs_ID='$courseID'";
    $res = mysqli_query($link, $update) or die("Eintrag nicht geklappt");

    header("Location:index.php?page=courseMembers&courseID=".$courseID);
}

mysqli_close($link);
?>
<body>
    <form name ="editBoking" method="post" action="index.php?page=editBooking&bookingID=<?php echo $bookingID ?>">
        <fieldset>
            <input type="radio" id="prov" name="Anmeldestatus" value="provisorisch" <?php if($bookingDetails["Anmeldestatus"] == "provisorisch" ){echo 'checked="checked"';}?>>
            <label for="prov"> Provisorisch</label> 
            <input type="radio" id="def" name="Anmeldestatus" value="definitiv" <?php if($bookingDetails["Anmeldestatus"] == "definitiv" ){echo 'checked="checked"';}?>>
            <label for="def"> Definitiv</label>
            <button class="btn btn-default" type="submit">Änderungen speichern</button>
            <button class="btn btn-default" type="submit">Anmeldung löschen</button>
    </form>
</body>