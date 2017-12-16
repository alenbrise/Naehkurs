<?php checkForAuthorization(false) ?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <div class="navbar-brand" >Kursübersicht</div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php?page=userHome">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php?page=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php

if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded'] == 1) {
        prompt("Sie haben sich erfolgreich für den Kurs angemeldet!");
    }else if($_GET['forwarded'] == 2){
        prompt("Sie sind bereits für diesen Kurs eingetragen!");
    }else if($_GET['forwarded'] == 3){
        prompt("Dieser Kurs ist bereits ausgebucht!");
    }else if($_GET['forwarded'] == 4){
        prompt("Ihre Daten wurden erfasst!");
    }
}
$linecolor = false;

@$sortieren=$_GET['sortieren'];
if(!isset($sortieren)){
    $sortieren="Kursdatum";
}

$link = getDbConnection();        
$abfrage="SELECT Kurs_ID, Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE Kursdatum >= Curdate()ORDER BY $sortieren";        
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//Tabellenüberschrift erstellen (automatisch)
echo "<table border='0'>";

//wir stellen den tabellentitel als sortierlink dar
echo "<tr bgcolor='#DCDCDC'>";
echo "<th>Kursnummer</th>";
echo "<th>Kursname</th>";
echo "<th>Kursbeschreibung</th>";
echo "<th>Kursdatum</th>";
echo "</th>";
echo "</tr>";
//Tabelleninhalt auflisten

while($zeile=mysqli_fetch_Assoc($res)){
    if($linecolor == true){
        echo"<tr bgcolor='#DCDCDC'>";
        $linecolor = false;
    }else{
        echo "<tr>";
        $linecolor = true;
    }
    /*foreach($zeile as $key=>$value){
      echo "<td>".$value."</td>";//könnte auch den $key ausgeben
    }*/

     while(list($key, $value)=each ($zeile)){
         echo "<td>".$value."</td>";//könnte auch den $key ausgeben
         if($key == "Kurs_ID"){
             $row = $value;
         }
    }
    echo "<td><a href=index.php?page=courseDetail&courseID=$row>mehr</a></td>";
    echo"</tr>";
}
echo "</table>";
mysqli_close($link);
?>
