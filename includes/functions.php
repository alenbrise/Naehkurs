<?php

//prompts a message
function alert($message){
     echo "<script type='text/javascript'> alert('$message'); </script>";
}

//sends Bill to customer after sign up for course
function sendBill($receiver, $name, $billID){
    include "config.inc.php";
    $jsonData = '{
  "personalizations": [
    {
      "to": [
        {
          "email": "'.$receiver.'",
          "name": "'.$name.'"
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

/* TODO: add your API key*/
$options = ["http" => [
    "method" => "POST",
    "header" => ["Content-Type: application/json",
        "Authorization: Bearer ".$APIkey],
    "content" => $jsonData
]];

/* TODO: Use stream_context_create and file_get_contents to send the API request */
$context = stream_context_create($options);
$response = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);
echo json_decode($response);
}

//sends password to user after resetting it
function sendPW($receiver, $name, $password){
    include "config.inc.php";
    $jsonData = '{
  "personalizations": [
    {
      "to": [
        {
          "email": "'.$receiver.'",
          "name": "'.$name.'"
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
      "value": "<html><p>'.$password.'</p></html>"
    }
  ]
}';

/* TODO: add your API key*/
$options = ["http" => [
    "method" => "POST",
    "header" => ["Content-Type: application/json",
        "Authorization: Bearer ".$APIkey],
    "content" => $jsonData
]];

/* TODO: Use stream_context_create and file_get_contents to send the API request */
$context = stream_context_create($options);
$response = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);
echo json_decode($response);
}



?>

