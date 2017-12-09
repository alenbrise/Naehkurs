<h1>Kursdetail</h1>
<?php

$courseID = $_GET['courseID'];
displayCourse($courseID);
    
function displayCourse($courseID){
    
     require "./includes/db.inc.php";
     
     $link = mysqli_connect("localhost",$benutzer,$passwort) or die("Keine Verbindung zum Localhost möglich.");
     mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
     $abfrage="SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE $courseID = Kurs_ID";
        
     $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");
     
     echo "Kursname";
     echo "Kursbeschreibung";
}


/* 
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

