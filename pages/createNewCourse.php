<?php

$page ="./includes/dbfunctions.php";
include $page;

if (isset($_POST['txtCoursename']) and ( $_POST['txtCoursetext']) and ( $_POST['txtCourseplace'])and ( $_POST['txtCoursedate']) and ( $_POST['txtPrice']) and ( $_POST['txtMax']) and ( $_POST['txtMin'])) {
    $coursename = $_POST['txtCoursename'];
    $coursetext = $_POST['txtCoursetext'];
    $courseplace = $_POST['txtCourseplace'];
    $coursedate = $_POST['txtCoursedate'];
    $price = $_POST['txtPrice'];
    $max = $_POST['txtMax'];
    $min = $_POST['txtMin'];

    createCourse($coursename, $coursetext, $courseplace, $coursedate, $price, $max, $min);
    
}
    ?>

<h1>Kurs erstellen</h1>
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
    <button type="submit" >Kurs erstellen</button>
</form>
