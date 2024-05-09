<!--?php
   
    $my_verify_token = "12345678901MVT";


    $challenge=$_GET['hub_challenge'];
    $verify_token=$_GET['hub_verify_token'];

    if($my_verify_token===$verify_token){

        echo $challenge;
        exit;

    }


    $access_token='EAAVzzjQKYWoBOzyonfk86DGkIZC64BeJlTpYoOXPyL2DF3b65tx43BGoKz3q3WD3anqmMvNG7X7aZCxpvFQ7Ph8z4bSZA0ZArfxeGcXbas1JlaiTngJDvhDVn1nIhJNBVkqTdaFmRYYCwscUFz9djZA40UOgSFcnZBgTF97MmIezVSBFrf6ajzu7CxCl6JvxMW';


    $response=file_get_contents("php://input");
    // file_put_contents("text.txt", $response);
    $response=json_decode($response, true);

    $message=$response['entry'][0]['messaging'][0]['message']['text'];
    $sender_id=$response['entry'][0]['messaging'][0]['sender']['id'];


    if($message=='Hi'){

        $reply_message='{ 
            "messaging_type": "RESPONSE",
            "recipient": { 
                "id": "' . $sender_id . '"
            },
            "message": { 
                "text": "Hi, Thanks for your message, You have write Hi" 
            } 
        }';

        send_reply($access_token,$reply_message);

    }



    if($message == 'Hello') {

        $reply_message='{ 
            "messaging_type": "RESPONSE",
            "recipient": { 
                "id": "' . $sender_id . '"
            },
            "message": { 
                "text": "Hello, Thanks for your message, You have write Hello" 
            } 
        }';

        send_reply($access_token,$reply_message);

    }



    function send_reply($access_token='',$reply='') 
        {
            $url= "https://graph.facebook.com/v2.6/me/messages?access_token=$access_token";
            $ch= curl_init();
            $headers= array("Content-Type: application/json");
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $reply);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // add when working on localhost
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $st=curl_exec($ch);
            $result=json_decode($st, true);
            return $result;
        }



   
   $my_verify_token = "12345678901MVT";


   $challenge=$_GET['hub_challenge'];
   $verify_token=$_GET['hub_verify_token'];

   if($my_verify_token===$verify_token){

       echo $challenge;
       exit;

   }


   $access_token='EAAVzzjQKYWoBOzyonfk86DGkIZC64BeJlTpYoOXPyL2DF3b65tx43BGoKz3q3WD3anqmMvNG7X7aZCxpvFQ7Ph8z4bSZA0ZArfxeGcXbas1JlaiTngJDvhDVn1nIhJNBVkqTdaFmRYYCwscUFz9djZA40UOgSFcnZBgTF97MmIezVSBFrf6ajzu7CxCl6JvxMW';


    $response = file_get_contents("php://input");
    $response = json_decode($response, true);


    if (isset($response['entry'][0]['messaging'][0])) {
        $message = $response['entry'][0]['messaging'][0]['message']['text'];
        error_log("Received message: " . $message); // Log received message
    
        $sender_id = $response['entry'][0]['messaging'][0]['sender']['id'];
    
        if($message == 'Hi'){
            $reply_message = '{ 
                "messaging_type": "RESPONSE",
                "recipient": { 
                    "id": "7686062908112271"
                },
                "message": { 
                    "text": "Hi, Thanks for your message, You have write Hi" 
                } 
            }';
            error_log("Sent reply: " . $reply_message); // Log sent reply
            send_reply($access_token, $reply_message);
        }
        if($message == 'Hello') {
            $reply_message = '{ 
                "messaging_type": "RESPONSE",
                "recipient": { 
                    "id": "7686062908112271"
                },
                "message": { 
                    "text": "Hello, Thanks for your message, You have write Hello" 
                } 
            }';   
            error_log("Sent reply: " . $reply_message); // Log sent reply
            send_reply($access_token, $reply_message);
        }
    }
    
    
    function send_reply($access_token='', $reply='') 
    {
        $url= "https://graph.facebook.com/v2.6/me/messages?access_token=$access_token";
        $ch= curl_init();
        $headers= array("Content-Type: application/json");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $reply);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // add when working on localhost
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $st=curl_exec($ch);
        $result=json_decode($st, true);
        return $result;
    }

?-->

<!-- ?php
// webhook.php

// Replace with your actual Page Access Token
$access_token = 'EAAVzzjQKYWoBOzyonfk86DGkIZC64BeJlTpYoOXPyL2DF3b65tx43BGoKz3q3WD3anqmMvNG7X7aZCxpvFQ7Ph8z4bSZA0ZArfxeGcXbas1JlaiTngJDvhDVn1nIhJNBVkqTdaFmRYYCwscUFz9djZA40UOgSFcnZBgTF97MmIezVSBFrf6ajzu7CxCl6JvxMW';

// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     // Handle Facebook verification
//     $challenge = $_GET['hub_challenge'];
//     $token = $_GET['hub_verify_token'];
//     if ($token === '12345678901MVT') {
//         echo $challenge;
//     }
// }
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle Facebook verification
    $challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : null;
    $token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : null;
    if ($token === '12345678901MVT' && $challenge !== null) {
        echo $challenge;
    }
}
//  else {
//     // Handle incoming messages
//     $input = json_decode(file_get_contents('php://input'), true);
//     $sender_id = $input['entry'][0]['messaging'][0]['sender']['id'];
//     $message_text = $input['entry'][0]['messaging'][0]['message']['text'];

//     // Implement your chatbot logic here
//     if (strtolower(trim($message_text)) === 'hello') {
//         send_message($sender_id, 'Hello! How can I assist you?');
//     } elseif (strtolower(trim($message_text)) === 'help') {
//         send_message($sender_id, 'Feel free to ask any questions!');
//     } else {
//         // Handle other user messages
//         // Implement custom responses based on user input
//         // Example: send a default response
//         send_message($sender_id, 'I didn\'t quite catch that. Can you please rephrase?');
//     }
// }

else {
    // Handle incoming messages
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['entry'][0]['messaging'][0])) {
        $messaging = $input['entry'][0]['messaging'][0];

        if (isset($messaging['sender']['id'], $messaging['message']['text'])) {
            $sender_id = $messaging['sender']['id'];
            $message_text = $messaging['message']['text'];

            // Implement your chatbot logic here
            if (strtolower(trim($message_text)) === 'hello') {
                send_message($sender_id, 'Hello! How can I assist you?');
            } elseif (strtolower(trim($message_text)) === 'help') {
                send_message($sender_id, 'Feel free to ask any questions!');
            } else {
                // Handle other user messages
                // Implement custom responses based on user input
                // Example: send a default response
                send_message($sender_id, 'I didn\'t quite catch that. Can you please rephrase?');
            }
        }
    }
}
function send_message($recipient_id, $message_text) {
    global $access_token;
    $url = 'https://graph.facebook.com/v13.0/me/messages?access_token=' . $access_token;
    $message_data = [
        'recipient' => ['id' => $recipient_id],
        'message' => ['text' => $message_text]
    ];

    // $options = [
    //     'http' => [
    //         'method' => 'POST',
    //         'header' => 'Content-Type: application/json',
    //         'content' => json_encode($message_data)
    //     ]
    // ];

    // $context = stream_context_create($options);
    // file_get_contents($url, false, $context);


    // Initiate the curl session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    // Indicate that we want to make a POST request
    curl_setopt($ch, CURLOPT_POST, 1);

    // Attach our encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message_data));

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute the request
    $result = curl_exec($ch);

    // Close the curl session
    curl_close($ch);

    // Return the result from the server
    return $result;
}
? -->


<?php
$access_token = getenv('FB_ACCESS_TOKEN');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle Facebook verification
    $challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : null;
    $token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : null;
    if ($token === '12345678901MVT' && $challenge !== null) {
        echo $challenge;
    }
}

else {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['entry'][0]['messaging'][0])) {
        $messaging = $input['entry'][0]['messaging'][0];

        if (isset($messaging['sender']['id'], $messaging['message']['text'])) {
            $sender_id = $messaging['sender']['id'];
            $message_text = $messaging['message']['text'];

            // Implement your chatbot logic here
            if (strtolower(trim($message_text)) === 'hello') {
                send_message($sender_id, 'Hello! How can I assist you?');
            } elseif (strtolower(trim($message_text)) === 'help') {
                send_message($sender_id, 'Feel free to ask any questions!');
            } else {
                // Handle other user messages
                // Implement custom responses based on user input
                // Example: send a default response
                send_message($sender_id, 'I didn\'t quite catch that. Can you please rephrase?');
            }
        }
    }
}

function send_message($recipient_id, $message_text) {
    global $access_token;
    $url = 'https://graph.facebook.com/v13.0/me/messages?access_token=' . $access_token;
    $message_data = [
        'recipient' => ['id' => $recipient_id],
        'message' => ['text' => $message_text]
    ];
    // Initiate the curl session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    // Indicate that we want to make a POST request
    curl_setopt($ch, CURLOPT_POST, 1);

    // Attach our encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message_data));

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Execute the request
    $result = curl_exec($ch);

    // Close the curl session
    curl_close($ch);

    // Return the result from the server
    return $result;
}
?>
