
<?php
    if (isset($_POST['txtEmail'])) {
    $email = $_POST['txtEmail'];

    $pw = generatePassword();
    
    setPassword($email, $pw);
    
}

function generatePassword() {
$length = 8;
$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
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
