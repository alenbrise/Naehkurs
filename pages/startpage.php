<?php
if (isset($_GET['forwarded'])){
    echo "<div class='alert alert-success' role='alert'>Ihre Daten wurden erfasst!</div>";
}
?>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div class="navbar-brand" >Startseite</div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?page=startPage">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <h1 >Herzlich Willkommen!</h1>
    <h2 class="h2">Hier können Sie Nähkurse buchen, bitte melden Sie sich an!</h2>
    <a class="btn btn-default" href="index.php?page=registration">Registrierung</a>
    <a class="btn btn-default" href="index.php?page=login">Login</a>
    <a class="btn btn-default" href="index.php?page=passwordForgot">Passwort vergessen</a>
</body>