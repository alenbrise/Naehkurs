<?php

//disconnect db
function dbClose($connection) {
    $connection->close();
}

//erstellt neuen Benutzer in der Datenbank
function createUser($firstName, $nachname, $adresse, $zipCode, $city, $email, $password) {
    $sql = "INSERT INTO '$dbname' (firstName, nachname, adresse, zipCode, city, email, password) "
        . "VALUES('$firstName', '$nachname', '$adresse', '$zipCode', '$city', '$email', '$password')";

    $servername = "localhost";
    $username = "";
    $passwordDb = "";
    $dbname = "naehkurs";

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
}

//prüft ob Benutzer bereits existiert
function checkUser($email) {

}

?>