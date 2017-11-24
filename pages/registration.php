<?php
print_r($_GET);

$page = "./includes/dbFunctions.php";
include $page;

if (isset ($_POST['txtFirstname']) and ($_POST['txtNachname']) and ($_POST['txtAddresse']) and ($_POST['txtZipCode']) and ($_POST['txtCity']) and ($_POST['txtEmail']) and ($_POST['txtPassword'])){
    $firstName = $_POST['txtFirstname'];
    $nachname = $_POST['txtNachname'];
    $adresse = $_POST['txtAddresse'];
    $zipCode = $_POST['txtZipCode'];
    $city = $_POST['txtCity'];
    $email = $_POST['txtEmail'];
    $password = $_POST['password'];

    createUser($firstName, $nachname, $adresse, $zipCode, $city, $email, $password);
    echo "hallo";
}else{
    echo "nicht funktioniert";
}

?>

<h1>Registrierung</h1>


<form method="post" action="index.php?page=registration">
    <div class="form-group">
        <select name="gender" class="form-control">
            <option value="male">Herr</option>
            <option value="female">Frau</option>
        </select>
    </div>

    <div class="form-group">
        <label for="txtFirstname">Vorname</label>
        <input type="text" class="form-control" id="txtFirstname" placeholder="Vorname">
    </div>
    <div class="form-group">
        <label for="txtNachname">Nachname</label>
        <input type="text" class="form-control" id="txtNachname" placeholder="Nachname">
    </div>

    <div class="form-group">
        <label for="txtAddresse">Addresse</label>
        <input type="text" class="form-control" id="txtAddresse" placeholder="Addresse">
    </div>
    <div class="form-group">
        <label for="txtZipCode">PLZ</label>
        <input type="text" class="form-control" id="txtZipCode" placeholder="PLZ">
    </div>
    <div class="form-group">
        <label for="txtCity">Ort</label>
        <input type="text" class="form-control" id="txtCity" placeholder="Ort">
    </div>
    <div class="form-group">
        <label for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" aria-describedby="emailHelp" placeholder="E-Mail eingebgen">
    </div>
    <div class="form-group">
        <label for="txtPassword">Password</label>
        <input type="password" class="form-control" id="txtPassword" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="txtPasswordRepeat">Passwort wiederholen</label>
        <input type="password" class="form-control" id="txtPasswordRepeat" placeholder="Passwort wiederholen">
    </div>
    <button type="submit">Submit</button>
</form>