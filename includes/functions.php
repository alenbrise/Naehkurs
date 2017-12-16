<?php

function setSessionID($email, $isAdmin){
    $_SESSION['benutzer_id'] = $email;
    if($isAdmin){
        $_SESSION['is_admin'] = true;    
    }
    
}

function isLoggedIn(){
    if(isset($_SESSION['benutzer_id'])){
        return true;
    }
    return false;
}

function isLoggedAsAdmin(){
    if(isset($_SESSION['is_admin'])){
        return true;
    }
    return false;
}

function routeToPage(){
    $page = "./pages/";
    
    if (!isset($_GET['page']) || $_GET['page']=='') {
        return getStartpage();
    } else {
        $page .= $_GET['page'] . '.php';
    }
    return $page;
}

function forwardToStartpage(){
    header("Location: " . 'index.php?page=startpage');
}
function getStartpage(){
    return "./pages/startpage.php";
}
function checkForAuthorization($needAdminPermission){
    if($needAdminPermission){
        if(!isLoggedAsAdmin()){
            forwardToStartpage();
        }
    }
    if(!isLoggedIn()){
        forwardToStartpage();
    }
}


//prompts a message
function prompt($message) {
    echo "<script type='text/javascript'> alert('$message'); </script>";
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

//sends Bill to customer after sign up for course
function sendBill($receiver, $name, $billID, $courseID) {
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
  "subject": "Rechnung zur Kursanmeldung",
  "content": [
    {
      "type": "text/html",
      "value": "<html><p>text</p></html>"
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
?>

