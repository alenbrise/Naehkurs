<?php
  
if (isset($_POST['gender']) and ( $_POST['txtFirstname']) and ( $_POST['txtNachname']) and ( $_POST['txtAddresse']) and ( $_POST['txtZipCode']) and ( $_POST['txtCity']) and ( $_POST['txtEmail']) and ( $_POST['txtPassword'])) {
    $gender = $_POST['gender'];
    $firstname = $_POST['txtFirstname'];
    $lastname = $_POST['txtNachname'];
    $address = $_POST['txtAddresse'];
    $zipcode = $_POST['txtZipCode'];
    $city = $_POST['txtCity'];
    $email = $_POST['txtEmail'];
    $password1 = $_POST['txtPassword'];
    $password2 = $_POST['txtPasswordRepeat'];
    $pass = md5($password1);
    
    createUser($gender, $firstname, $lastname, $address, $zipcode, $city, $email, $password1, $password2, $pass);
}
    


    /* $user = checkUser($firstName, $nachname, $adresse, $zipCode, $city, $email, $password1, $password2);
      if($user){
      echo "user erstellt";
      }else{
      echo "nicht funktioniert";
      } */

?>

<h1>Registrierung</h1>


<form name ="registration" method="post" onsubmit="onSumbit()" action="index.php?page=registration">
    <div class="form-group">
        <select name="gender" class="form-control">
            <option value="male">Herr</option>
            <option value="female">Frau</option>
        </select>
    </div>

    <div class="form-group">
        <label for="txtFirstname">Vorname</label>
        <input type="text" class="form-control" name="txtFirstname" placeholder="Vorname">
    </div>
    <div class="form-group">
        <label for="txtNachname">Nachname</label>
        <input type="text" class="form-control" name="txtNachname" placeholder="Nachname">
    </div>

    <div class="form-group">
        <label for="txtAddresse">Adresse</label>
        <input type="text" class="form-control" name="txtAddresse" placeholder="Adresse">
    </div>
    <div class="form-group">
        <label for="txtZipCode">PLZ</label>
        <input type="number" class="form-control" name="txtZipCode" placeholder="PLZ">
    </div>
    <div class="form-group">
        <label for="txtCity">Ort</label>
        <input type="text" class="form-control" name="txtCity" placeholder="Ort">
    </div>
    <div class="form-group">
        <label for="txtEmail">Email</label>
        <input type="email" class="form-control" name="txtEmail" aria-describedby="emailHelp" placeholder="E-Mail eingebgen">
    </div>
    <div class="form-group">
        <label for="txtPassword">Passwort</label>
        <input type="password" class="form-control" name="txtPassword" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="txtPasswordRepeat">Passwort wiederholen</label>
        <input type="password" class="form-control" name="txtPasswordRepeat" placeholder="Passwort wiederholen">
    </div>
    <button type="submit" >Registrieren</button>
</form>