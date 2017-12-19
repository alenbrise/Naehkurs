<?php 

checkForAuthorization(true);

if(!isset($_GET['bookingID']) || $_GET['bookingID']==""){
    header('Location:index.php?page=adminHome');
}

$booking = getBookingByBookingId($_GET['bookingID']);

if(isset($_GET['deleteRegistration']) && isset($_GET['bookingID'])){    
    deleteUserRegistrationByBookingId($_GET['bookingID']);
    header("Location:index.php?page=courseMembers&userDeleted=1&courseID=".$booking['Kurs_ID']);
}else if(isset($_GET['bookingID'])){
    $username = getUsernameByBookingId($_GET['bookingID']);
    $courseName = getCourseNameByBookingId($_GET['bookingID']);      
    $userID = $booking["Benutzer_ID"];
    $courseID = $booking["Kurs_ID"];

    if(isset ($_POST['Anmeldestatus'])){
        updateParticipantStatus($userID, $courseID, $_POST['Anmeldestatus']);
        header("Location:index.php?page=courseMembers&courseID=".$courseID);
    }
    
    $provisorischChecked = ($booking["Anmeldestatus"] == "provisorisch") ? "checked=checked" : "";
    $definitvChecked = ($booking["Anmeldestatus"] == "definitiv") ? "checked=checked" : "";
}


?>
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


echo "<h2> Kursanmeldung von " . $username . " zum Kurs " . $courseName . "</h2>";

?>
<body>
    <form name ="editBoking" method="post" action="index.php?page=editBooking&bookingID=<?php echo $_GET['bookingID'] ?>">
        <fieldset>
            <input type="radio" id="prov" name="Anmeldestatus" value="provisorisch" <?php echo $provisorischChecked ?>>
            <label for="prov"> Provisorisch</label> 
            <input type="radio" id="def" name="Anmeldestatus" value="definitiv" <?php echo $definitvChecked ?>>
            <label for="def"> Definitiv</label>
            <button class="btn btn-default" type="submit">Änderungen speichern</button>            
    </form>
</body>