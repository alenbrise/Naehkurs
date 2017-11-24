<h1>Login</h1>

<form method="post" action="index.php?page=login">
    <div class="form-group">
        <label for="txtEmail">Email:</label>
        <input type="email" class="form-control" name="txtEmail" placeholder="E-Mail eingebgen">
    </div>
    <div class="form-group">
        <label for="txtPasswort">Passwort:</label>
        <input type="password" class="form-control" name="txtPasswort" placeholder="Passwort">
    </div>
    <button type="submit">Anmelden</button>

    <div class="form-group">
        <a href="index.php?page=registration">Registrierung</a><br>
        <a href="index.php?page=passwortVergessen">Passwort vergessen</a>
    </div>
</form>