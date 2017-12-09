<html>
    <head>
        <meta charset="UTF-8">
        <title>Tabelle ausgeben</title>
        <style type="text/css">
            body, th {color:black; font-family:arial}
            a:link{color:black;text-decoration: none}
            a:visited {color:black;text-decoration: none}
        </style>
    </head>
    <body>
        <h2> Ausgabe der Logins-Tabelle</h2>
        <?php
        require "./includes/db.inc.php"; //anstelle von include, weil unbedingt erforderlich
        $linecolor = false;
        
        @$sortieren=$_GET['sortieren'];
        if(!isset($sortieren)){
            $sortieren="Kursdatum";
        }
        
        $link = mysqli_connect("localhost",$benutzer,$passwort) or die("Keine Verbindung zum Localhost möglich.");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $abfrage="SELECT Kursname, Kursbeschreibung, Kursdatum FROM `kurs` WHERE Kursdatum >= Curdate()ORDER BY $sortieren";
        
        $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");
        
        //Tabellenüberschrift erstellen (automatisch)
        echo "<table border='0'>";
        
        //wir stellen den tabellentitel als sortierlink dar
        echo "<tr bgcolor='#DCDCDC'>";
        echo "<th>Kursname</th>";
        echo "<th>Kursbeschreibung</th>";
        echo "<th>Kursdatum</th>";
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
            }
            echo"</tr>";
        }
        echo "</table>";
        mysqli_close($link);
        ?>
    </body>
</html>