<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div class="navbar-brand" >Passwort zurücksetzen</div>
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
if (isset($_POST['txtEmail'])) {
    $email = $_POST['txtEmail'];

    $pw = generatePassword();

    setPassword($email, $pw);

    header("Location:index.php?page=login&forwarded=1");
}
?>
<body>
    <form name ="passwordForgot" method="post" action="index.php?page=passwordForgot">
        <div class="form-group">
            <label for="txtEmail">E-Mail</label>
            <input type="email" class="form-control" name="txtEmail" placeholder="E-Mail eingeben">
        </div>
        <button class="btn btn-default" type="submit" >Passwort anfordern</button>
    </form>
</body>
