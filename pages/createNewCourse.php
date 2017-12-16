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
                <div class="navbar-brand" >Kurs erstellen</div>
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
if (isset($_POST['txtCoursename']) and ( $_POST['txtCoursetext']) and ( $_POST['txtCourseplace'])and ( $_POST['txtCoursedate']) and ( $_POST['txtPrice']) and ( $_POST['txtMax']) and ( $_POST['txtMin']) and ( $_POST['txtTime'])) {
    $coursename = $_POST['txtCoursename'];
    $coursetext = $_POST['txtCoursetext'];
    $courseplace = $_POST['txtCourseplace'];
    $coursedate = $_POST['txtCoursedate'];
    $price = $_POST['txtPrice'];
    $max = $_POST['txtMax'];
    $min = $_POST['txtMin'];
    $time = $_POST['txtTime'];

    createCourse($coursename, $coursetext, $courseplace, $coursedate, $price, $max, $min, $time);
}
?>
<body>
    <form name ="createNewCourse" method="post" action="index.php?page=createNewCourse">
        <div class="form-group">
            <label for="txtCoursename">Kursname</label>
            <input type="text" class="form-control" name="txtCoursename" placeholder="Kursname">
        </div>
        <div class="form-group">
            <label for="txtCoursetext">Kursbeschreibung</label>
            <textarea class="form-control" name="txtCoursetext" rows="5" cols="20">
            </textarea>
        </div>
        <div class="form-group">
            <label for="txtCourseplace">Kursort</label>
            <input type="text" class="form-control" name="txtCourseplace" placeholder="Kursort">
        </div>
        <div class="form-group">
            <label for="txtCoursedate">Kursdatum</label>
            <input type="date" class="form-control" name="txtCoursedate" placeholder="Kursdatum">
        </div>
        <div class="form-group">
            <label for="txtPrice">Preis</label>
            <input type="number" class="form-control" name="txtPrice" placeholder="Preis">
        </div>
        <div class="form-group">
            <label for="txtMax">Max. Pl&auml;tze</label>
            <input type="number" class="form-control" name="txtMax" placeholder="Max. Pl&auml;tze">
        </div>
        <div class="form-group">
            <label for="txtMin">Min. Pl&auml;tze</label>
            <input type="number" class="form-control" name="txtMin" placeholder="Min. Pl&auml;tze">
        </div>
        <div class="form-group">
            <label for="txtTime">Uhrzeit</label>
            <input type="text" class="form-control" name="txtTime" placeholder="20:00">
        </div>
        <button type="submit" >Kurs erstellen</button>
    </form>
</body>
