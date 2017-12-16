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
                <div class="navbar-brand" >Kurs bearbeiten</div>
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
$courseID = $_GET['courseID'];

$link = getDbConnection();

$abfrage = "SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum, Kursort, Kursstatus, Preis, Max_Plaetze, Min_Plaetze, Freie_Plaetze, Kurszeit FROM `kurs` WHERE Kurs_ID = $courseID";
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//form fields are filled with current values
$courseDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $courseDetails[$key] = $value;
    }
}

$courseID = $courseDetails['Kurs_ID'];

if (isset($_POST['txtCoursename']) and ( $_POST['txtCoursetext']) and ( $_POST['txtCourseplace'])and ( $_POST['txtCoursedate']) and ( $_POST['txtPrice']) and ( $_POST['txtMax']) and ( $_POST['txtMin']) and ( $_POST['txtTime'])) {
    $coursename = $_POST['txtCoursename'];
    $coursetext = $_POST['txtCoursetext'];
    $courseplace = $_POST['txtCourseplace'];
    $coursedate = $_POST['txtCoursedate'];
    $price = $_POST['txtPrice'];
    $max = $_POST['txtMax'];
    $min = $_POST['txtMin'];
    $time = $_POST['txtTime'];

    $update = "UPDATE `kurs`SET Kursname='$coursename', Kursbeschreibung='$coursetext', Kursort='$courseplace', Kursdatum='$coursedate', Preis='$price', Max_Plaetze='$max', Min_Plaetze='$min', Kurszeit='$time' WHERE Kurs_ID='$courseID'";
    $res = mysqli_query($link, $update) or die("Eintrag nicht geklappt");

    header("Location:index.php?page=adminHome&forwarded=1");
}
mysqli_close($link);
?>
<body>
    <form name ="editCourse" method="post" action="index.php?page=editCourse&courseID=<?php echo $courseID ?>">
        <div class="form-group">
            <label for="txtCoursename">Kursname</label>
            <input type="text" class="form-control" name="txtCoursename" value="<?php echo $courseDetails["Kursname"] ?>">
        </div>
        <div class="form-group">
            <label for="txtCoursetext">Kursbeschreibung</label>
            <textarea class="form-control" name="txtCoursetext" rows="5" cols="20"><?php echo $courseDetails["Kursbeschreibung"] ?></textarea>
        </div>
        <div class="form-group">
            <label for="txtCourseplace">Kursort</label>
            <input type="text" class="form-control" name="txtCourseplace" value="<?php echo $courseDetails["Kursort"] ?>">
        </div>
        <div class="form-group">
            <label for="txtCoursedate">Kursdatum</label>
            <input type="date" class="form-control" name="txtCoursedate" value="<?php echo $courseDetails["Kursdatum"] ?>">
        </div>
        <div class="form-group">
            <label for="txtPrice">Preis</label>
            <input type="number" class="form-control" name="txtPrice" value="<?php echo $courseDetails["Preis"] ?>">
        </div>
        <div class="form-group">
            <label for="txtMax">Max. Pl&auml;tze</label>
            <input type="number" class="form-control" name="txtMax" value="<?php echo $courseDetails["Max_Plaetze"] ?>">
        </div>
        <div class="form-group">
            <label for="txtMin">Min. Pl&auml;tze</label>
            <input type="number" class="form-control" name="txtMin" value="<?php echo $courseDetails["Min_Plaetze"] ?>">
        </div>
        <div class="form-group">
            <label for="txtTime">Uhrzeit</label>
            <input type="text" class="form-control" name="txtTime" value="<?php echo $courseDetails["Kurszeit"] ?>">
        </div>
        <button type="submit" >Änderungen speichern</button>
        <button type="submit" >Kurs löschen</button>
    </form>
</body>

