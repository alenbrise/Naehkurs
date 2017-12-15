
<?php
    if (isset($_POST['txtEmail'])) {
    $email = $_POST['txtEmail'];

    $pw = generatePassword();
    
    setPassword($email, $pw);
   
    
    header("Location:index.php?page=login&forwarded=1");
    
}

?>

<h1>Passwort vergessen</h1>
<form name ="passwordForgot" method="post" action="index.php?page=passwordForgot">
    <div class="form-group">
        <label for="txtEmail">E-Mail</label>
        <input type="email" class="form-control" name="txtEmail" placeholder="E-Mail eingeben">
    </div>
    <button type="submit" >Passwort anfordern</button>
</form>
