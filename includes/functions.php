<?php

function setSessionID($email, $isAdmin) {
    $_SESSION['benutzer_id'] = $email;
    if ($isAdmin) {
        $_SESSION['is_admin'] = true;
    }
}

function isLoggedIn() {
    if (isset($_SESSION['benutzer_id'])) {
        return true;
    }
    return false;
}

function isLoggedAsAdmin() {
    if (isset($_SESSION['is_admin'])) {
        return true;
    }
    return false;
}

function routeToPage() {
    $page = "./pages/";

    if (!isset($_GET['page']) || $_GET['page'] == '') {
        return getStartpage();
    } else {
        $page .= $_GET['page'] . '.php';
    }
    return $page;
}

function forwardToStartpage() {
    header("Location: " . 'index.php?page=startpage');
}

function getStartpage() {
    return "./pages/startpage.php";
}

function checkForAuthorization($needAdminPermission) {
    if ($needAdminPermission) {
        if (!isLoggedAsAdmin()) {
            forwardToStartpage();
        }
    }
    if (!isLoggedIn()) {
        forwardToStartpage();
    }
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

function getPageName($pagename) {
    if ($pagename == "adminHome") {
        return "Kursübersicht";
    } else if ($pagename == "editBooking") {
        return "Buchung bearbeiten";
    } else if ($pagename == "courseMembers") {
        return "Teilnehmerliste";
    } else if ($pagename == "revenue") {
        return "Abrechnung erstellen";
    } else if ($pagename == "users") {
        return "Benutzer";
    } else if ($pagename == "createNewCourse") {
        return "Kurs erstellen";
    } else if ($pagename == "courseDetail") {
        return "Kursdetail";
    } else if ($pagename == "editCourse") {
        return "Kurs bearbeiten";
    } else if ($pagename == "editUser") {
        return "Benutzer bearbeiten";
    } else if ($pagename == "userHome") {
        return "Kursübersicht";
    }
}

function getAdminNavbar($pagename) {
    $pagenameForNavbar = getPageName($pagename);
    $navbar = ' <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div class="navbar-brand"> <p>' . $pagenameForNavbar . '</p> </div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?page=adminHome">Home</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menü <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?page=createNewCourse">Kurs erstellen</a></li>
                            <li><a href="index.php?page=revenue">Abrechnung ausgeben</a></li>
                            <li><a href="index.php?page=adminHome">Rechnung aufrufen</a></li>
                            <li><a href="index.php?page=users">Benutzerübersicht</a></li>
                        </ul>
                    </li> 
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?page=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>';
    return $navbar;
}

function getUserNavbar() {
    $navbar = ' <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <div class="navbar-brand" >Kursübersicht</div>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php?page=userHome">Home</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?page=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>';
    return $navbar;
}

function getRevenueTable($courseRevenues) {
    $revenueTable = "<table class='table table-dark' border='0'>";

    $revenueTable .= "<tr bgcolor='#DCDCDC'>";
    $revenueTable .= "<th scope='col'>Kursnummer</th>";
    $revenueTable .= "<th scope='col'>Kursname</th>";
    $revenueTable .= "<th scope='col'>Kursdatum</th>";
    $revenueTable .= "<th scope='col'>Umsatz</th>";
    $revenueTable .= "</tr>";

    //Tabelleninhalt auflisten
    $rowCounter = 0;
    foreach ($courseRevenues as $courseRevenue) {
        $backgroundColor = ($rowCounter % 2 == 1) ? 'bgcolor=#DCDCDC' : '';
        $revenueTableRow = "<tr>";
        $revenueTableRow = '<tr' . ' ' . $backgroundColor . '>';
        foreach ($courseRevenue as $val) {
            $revenueTableRow .= '<td>' . $val . '</td>';
        }
        $revenueTableRow .= '</tr>';
        $revenueTable .= $revenueTableRow;
        $rowCounter++;
    }
    $revenueTable .= '</table>';
    return $revenueTable;
}

//sends password to user after resetting it
function sendPW($receiver, $name, $password) {
    require "./sendgrid-php/vendor/autoload.php";

    $from = new SendGrid\Email("Stoffzentrale Baden", "info@stoffzentrale.ch");
    $subject = "Passwort zurückgesetzt";
    $to = new SendGrid\Email($name, $receiver);
    $content = new SendGrid\Content("text/html", "<h1>Neues Passwort</h1></br><p>Guten Tag</p><p>Ihr Passwort zur E-Mail-Adresse ".$receiver." wurde zurückgesetzt. Es lautet nun ".$password." !</p><p>Ihr Stoffzentrale-Team in Baden</p>");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $sg = new \SendGrid($GLOBALS['APIkey']);

    $response = $sg->client->mail()->send()->post($mail);
}

function sendDef($receiver, $billID, $name, $courseID, $courseName, $courseDate){
    require "./sendgrid-php/vendor/autoload.php";

    $from = new SendGrid\Email("Stoffzentrale Baden", "info@stoffzentrale.ch");
    $subject = "Definitive Kursanmeldung";
    $to = new SendGrid\Email($name, $receiver);
    $content = new SendGrid\Content("text/html", "<h1>Definitive Kursteilnahme</h1></br><p>Guten Tag</p><p>Wir haben Ihre Zahlung zur Rechnung Nr. ".$billID." erhalten, besten Dank dafür.</p><p>Wir freuen uns, Sie am ".$courseDate." zum Kurs ".$courseName." begrüssen zu dürfen.</p><p>Bis dahin eine gute Zeit!</p></br><p>Ihr Stoffzentrale-Team in Baden </p>");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $sg = new \SendGrid($GLOBALS['APIkey']);

    $response = $sg->client->mail()->send()->post($mail);
}

function sendBill($receiver, $name, $userID, $billID, $courseID) {
    require "./sendgrid-php/vendor/autoload.php";
    require "createPDF.php";

    $bill = generateBill($userID, $billID, $courseID);

    $from = new SendGrid\Email("Stoffzentrale Baden", "info@stoffzentrale.ch");
    $subject = "Rechnung zur Kursanmeldung";
    $to = new SendGrid\Email($name, $receiver);
    $content = new SendGrid\Content("text/html", "<h1>Rechnung Nr. ".$billID."</h1></br></br><p>Besten Dank für Ihre Anmeldung. Anbei erhalten Sie die Rechnung zu Ihrer Kursanmeldung und alle Details, die Sie zu deren Begleichung benötigen.</p><p>Bei Fragen können Sie uns selbstverständlich kontaktieren.</p></br></br></br><p>Wir freuen uns auf Sie!</p><p>Ihr Stoffzentrale-Team in Baden</p>");
    $attachment = new SendGrid\Attachment();
    $attachment->setContent($bill);
    $attachment->setType("application/pdf");
    $attachment->setFilename($billID . ".pdf");
    $attachment->setDisposition("attachment");
    $attachment->setContentId("Balance Sheet");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);
    $mail->addAttachment($attachment);

    $sg = new \SendGrid($GLOBALS['APIkey']);

    $response = $sg->client->mail()->send()->post($mail);
}
?>

