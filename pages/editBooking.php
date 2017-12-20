<?php 

checkForAuthorization(true);

//check ob user im url etwas ändert
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
   <?php
   $pagename = "editBooking";
   echo getAdminNavbar($pagename);
   ?>
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