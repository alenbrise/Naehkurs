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
                <div class="navbar-brand" >Benutzer bearbeiten</div>
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
$userID = $_GET['userID'];

$link = getDbConnection();

$abfrage = "SELECT * FROM `benutzer` WHERE Benutzer_ID = $userID";
$res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

//form fields are filled with current values
$userDetails = array();
while ($zeile = mysqli_fetch_Assoc($res)) {
    while (list($key, $value) = each($zeile)) {
        $userDetails[$key] = $value;
    }
}

if (isset($_POST['gender']) and ( $_POST['txtFirstname']) and ( $_POST['txtNachname']) and ( $_POST['txtAddresse']) and ( $_POST['txtZipCode']) and ( $_POST['txtCity']) and ( $_POST['txtEmail'])) {
        $gender = $_POST['gender'];
        $firstname = $_POST['txtFirstname'];
        $lastname = $_POST['txtNachname'];
        $address = $_POST['txtAddresse'];
        $zipcode = $_POST['txtZipCode'];
        $city = $_POST['txtCity'];
        $email = $_POST['txtEmail'];
        $isAdmin = $_POST['txtIsAdmin'];
        
        
        if($isAdmin == "on"){
            $isAdmin = 1;
        }else{
            $isAdmin = 0;
        }

    $update = "UPDATE `benutzer`SET Anrede='$gender', Vorname='$firstname', Nachname='$lastname', Adresse='$address', PLZ='$zipcode', Ort='$city', Email='$email', IsAdmin='$isAdmin' WHERE Benutzer_ID='$userID'";
    $res = mysqli_query($link, $update) or die("Eintrag nicht geklappt");

    header("Location:index.php?page=users&forwarded=1");
}
mysqli_close($link);
?>
<body>
    <form name ="reditUser" method="post" action="index.php?page=editUser&userID=<?php echo $userID?>">
        <div class="form-group">
            <select name="gender" class="form-control">
                <option value="male">Herr</option>
                <option value="female">Frau</option>
            </select>
        </div>

        <div class="form-group">
            <label for="txtFirstname">Vorname</label>
            <input type="text" class="form-control" name="txtFirstname" value="<?php echo $userDetails["Vorname"];?>">
        </div>
        <div class="form-group">
            <label for="txtNachname">Nachname</label>
            <input type="text" class="form-control" name="txtNachname" value="<?php echo $userDetails["Nachname"]?>">
        </div>

        <div class="form-group">
            <label for="txtAddresse">Adresse</label>
            <input type="text" class="form-control" name="txtAddresse" value="<?php echo $userDetails["Adresse"]?>">
        </div>
        <div class="form-group">
            <label for="txtZipCode">PLZ</label>
            <input type="number" class="form-control" name="txtZipCode" value="<?php echo $userDetails["PLZ"]?>">
        </div>
        <div class="form-group">
            <label for="txtCity">Ort</label>
            <input type="text" class="form-control" name="txtCity" value="<?php echo $userDetails["Ort"]?>">
        </div>
        <div class="form-group">
            <label for="txtEmail">Email</label>
            <input type="email" class="form-control" name="txtEmail" aria-describedby="emailHelp" value="<?php echo $userDetails["Email"]?>">
        </div>
        <div class="form-group">
            <label for="txtIsAdmin">Administrator</label>
            <input type="checkbox" class="form-control" name="txtIsAdmin" <?php if($userDetails["IsAdmin"] == 1){echo 'checked="checked"';}?>>
        </div>
        <button type="submit" >Änderungen speichern</button>
    </form>
</body>