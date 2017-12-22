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
    $jsonData = '{
  "personalizations": [
    {
      "to": [
        {
          "email": "' . $receiver . '",
          "name": "' . $name . '"
        }
      ]
    }
  ],
  "from": {
    "email": "info@stoffzentrale.ch",
    "name": "Stoffzentrale Baden"
  },
  "subject": "Passwort zurückgesetzt",
  "content": [
    {
      "type": "text/html",
      "value": "<html><p>' . $password . '</p></html>"
    }
  ]
}';

    /* TODO: add your API key */
    $options = ["http" => [
            "method" => "POST",
            "header" => ["Content-Type: application/json",
                "Authorization: Bearer " . $GLOBALS['APIkey']],
            "content" => $jsonData
    ]];

    /* TODO: Use stream_context_create and file_get_contents to send the API request */
    $context = stream_context_create($options);
    $response = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);
    echo json_decode($response);
}

function sendBill($receiver, $name, $userID, $billID, $courseID) {
    require "./sendgrid-php/vendor/autoload.php";
    require "createPDF.php";
    
    $bill = generateBill($userID, $billID, $courseID);
    
    $from = new SendGrid\Email("Stoffzentrale Baden", "info@stoffzentrale.ch");
    $subject = "Rechnung zur Kursanmeldung";
    $to = new SendGrid\Email($name, $receiver);
    $content = new SendGrid\Content("text/html", "<h1>Ihre Rechnung</h1>");
    $attachment = new SendGrid\Attachment();
    $attachment->setContent($bill);
    $attachment->setType("application/pdf");
    $attachment->setFilename($billID.".pdf");
    $attachment->setDisposition("attachment");
    $attachment->setContentId("Balance Sheet");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);
    $mail->addAttachment($attachment);

    $sg = new \SendGrid($GLOBALS['APIkey']);

    $response = $sg->client->mail()->send()->post($mail);
}   
?>

