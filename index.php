<?php
session_start();

include "./includes/config.inc.php";
include "./includes/dbfunctions.php";
include "./includes/functions.php";

$page = "./pages/";
if (!isset($_GET['page']) || $_GET['page']=='' || !isLoggedIn()) {
    $page .= 'startpage.php';
} else {
    $page .= $_GET['page'] . '.php';
}
?>

<html>
<head>
    <link href="res/ext/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="res/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container-fluid">

    <div class="row">
        <div class="col col-lg-9">
            <?php
            include $page;
            ?>
        </div>
        <div class="col col-lg-3">
            <img src="res/img/stoffzentrale.jpg" alt=""/>
        </div>
    </div>
</div>
</body>
</html>