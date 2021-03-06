<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div class="navbar-brand" >Login</div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?page=startPage">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>    
<?php
if (isset($_GET['forwarded'])) {
    if ($_GET['forwarded'] == 1) {
        echo "<div class='alert alert-success' role='alert'>Ihr neues Passwort sollten Sie in Kürze per E-Mail erhalten!</div>";
    }
    if ($_GET['forwarded'] == 2) {
        echo "<div class='alert alert-success' role='alert'>Sie haben hier keinen Zutritt!</div>";
    }
}

if (isset($_POST['txtEmail']) AND isset($_POST['txtPasswort'])) {
    $email = $_POST['txtEmail'];
    $pass = $_POST['txtPasswort'];
    $pass = md5($pass);

    // Datenbankverbindung


    $link = getDbConnection();

    // prüfen ob es user und passwort gibt
    $abfrage = "SELECT Benutzer_ID, IsAdmin, Email, Passwort FROM `benutzer` WHERE Email='$email' and Passwort='$pass'";
    $res = mysqli_query($link, $abfrage) or die("Verbindung zu Datenbank fehlgeschlagen");
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $isAdmin = isAdmin($email, $pass);

        setSessionID($email, $isAdmin);
        if ($isAdmin) {
            header("Location:index.php?page=adminHome");
        } else {
            header("Location:index.php?page=userHome");
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Login hat nicht geklappt!</div>";
    }
    mysqli_close($link);
}
?>
<body>
    <form method="post" action="index.php?page=login">
        <div class="form-group">
            <label for="txtEmail">Email:</label>
            <input type="email" class="form-control" name="txtEmail" placeholder="E-Mail eingeben">
        </div>
        <div class="form-group">
            <label for="txtPasswort">Passwort:</label>
            <input type="password" class="form-control" name="txtPasswort" placeholder="Passwort">
        </div>
        <button class="btn btn-default" type="submit">Anmelden</button>
    </form>
</body>

