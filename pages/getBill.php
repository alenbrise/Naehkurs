
<?php checkForAuthorization(true); ?>
<body>
    <?php
    $pagename = "getBill";
    echo getAdminNavbar($pagename);
    ?>
</body>

<?php
if (isset($_POST['txtUserMail']) and ( $_POST['txtCourse'])) {
    $mail = $_POST['txtUserMail'];
    $course = $_POST['txtCourse'];

    if (checkIfUserExists($mail) && checkIfCourseExists($course)) {
        $userID = getUserIDFromMail($mail);
        $courseID = getCourseIDFromName($course);
        if (checkIfBillExists($userID, $courseID)) {
            $billID = getBillID($userID, $courseID);
            generateBill($userID, $billID, $courseID, "D");
        } else {
            echo "<div class='alert alert-danger' role='alert'>Dieser Benutzer hat sich nicht für den angegebenen Kurs angemeldet!</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Diesen Kurs oder Benutzer gibt es nicht!</div>";
    }
}
?>

<body>
    <form name ="getBill" method="post" action="index.php?page=getBill">
        <div class="form-group">
            <label for="txtUserMail">E-mail Teilnehmer</label>
            <input type="text" class="form-control" name="txtUserMail" placeholder="muster@google.ch">
        </div>
        <div class="form-group">
            <label for="txtCourse">Kursname</label>
            <input type="text" class="form-control" name="txtCourse" placeholder="Stricken">
        </div>
        <button class="btn btn-default" type="submit" >Rechnung abrufen</button>
    </form>
</body>