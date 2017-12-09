<?php

function alert($message){
     echo "<script type='text/javascript'> alert('$message'); </script>";
}

function sendMail($receiver, $name, $password, $billID){
    include config.inc.php;
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
    "email": "stierli@itopia.ch",
    "name": "René Stierli"
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
        "Authorization: Bearer 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"],
    "content" => $jsonData
]];

/* TODO: Use stream_context_create and file_get_contents to send the API request */
$context = stream_context_create($options);
$response = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);
echo json_decode($response);
}


?>

