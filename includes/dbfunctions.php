
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <script type="text/javascript">
    //erstellt neuen Benutzer in der Datenbank
function createUser($firstname, $lastname, $address, $zipcode, $city, $email, $password1, $password2) {
 
    if($firstname == "") {
    alert("Bitte tragen Sie Ihren Vornamen ein!");
    document.registration.txtFirstname.focus();
    return false;
    }
    if($lastname == "") {
    alert("Bitte geben sie Ihren Nachnamen ein!");
    document.registration.txtNachname.focus();
    return false;
    }
    if($address == "") {
    alert("Bitte geben sie Ihre Adresse ein!");
    document.registration.txtAddresse.focus();
    return false;
    }
    if($zipcode == "") {
    alert("Bitte geben sie Ihre PLZ ein!");
    document.registration.txtZipCode.focus();
    return false;
    }    
    if($city == "") {
    alert("Bitte geben sie Ihren Wohnort ein!");
    document.registration.txtCity.focus();
    return false;
    }    
    if($email == "") {
    alert("Bitte geben sie Ihre E-Mail Adresse ein!");
    document.registration.txtEmail.focus();
    return false;
    }
    if($password1 == "") {
    alert("Bitte geben sie ein Passwort ein!");
    document.registration.txtPassword.focus();
    return false;
    }
    if($password2 == "") {
    alert("Bitte geben sie Ihr Passwort nochmals ein!");
    document.registration.txtPasswordRepeat.focus();
    return false;
    }
    if($password1 < 8) {
    alert("Bitte geben sie ein Passwort mit mindestens 8 Zeichen ein!");
    document.registration.txtPassword.focus();
    return false;
    }
    
    $nr_length = document.registration.password1.value.replace("/[^0-9]/g", '').length;
    if($nr_length < 1){
        alert("Das Passwort muss mind. 1 Zahl beinhalten!");
        document.registration.password1.focus();
        return false;
    }    
    if (document.registration.password1.value == document.registration.password2.value)
    { 
        return true;         
    }else{  
	alert("Die PasswÃ¶rter sind nicht identisch!");
	return false; 
    }
}
	
</script>
<?php

    $servername = "localhost";
    $username = "root";
    $passwordDb = "";
    $dbname = "naehkurs";
    
    $sql = "INSERT INTO '$dbname' (Vorname, Nachname, Adresse, PLZ, Ort, Email, Passwort) "
        . "VALUES('$firstname', '$lastname', '$address', '$zipcode', '$city', '$email', '$password1')";


// Create connection
    $connection = new mysqli($servername, $username, $passwordDb, $dbname);
// Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (mysqli_query($connection, $sql)) {
        echo "Benutzer registriert";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }

    $connection->close();

//prÃ¼ft ob Benutzer bereits existiert
function checkUser($email) {

}

?>
