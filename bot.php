<?php
$access_token = 'D8p6zodWI7B3lFnlf+Ejqko3sbgRsYOfxYIszOJw2GzPR9EjCOcZVoon6ytNMd7JcC/O1YzhplEkLNr4Y/QpT0MWAC0f0YR6ID6hyRI1MfMKs/ouGeIB6S6aDs9FGbyWzABgfqhCBOTnXHkNAJU1/QdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];
            // Get replyToken
            $replyToken = $event['replyToken'];
            
             if ($event['message']['text'] == 'hi' || $event['message']['text'] == 'hello'){
                $messages = [
                    'type' => 'sticker',
                    'packageId' => 1,
                    'stickerId' => 4,
                ];
                $url = 'https://api.line.me/v2/bot/message/reply';
                $data = [
                    'replyToken' => $replyToken,
                    'messages' => [$messages],
                ];
                $post = json_encode($data);
                $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $result = curl_exec($ch);
                curl_close($ch);
                echo $result . "\r\n";
            }else if ($event['message']['text'] == 'firebase' || $event['message']['text'] == 'google'){
                
                // Constants firebase
                 $length = 15;
                $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

                // Constants
                   $FIREBASE = "https://webapp-pwa.firebaseio.com/youtube/";
                $NODE_PUT = $randomString.".json";
                $randomString2 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
                // Matching nodes updated
                $data = array(
                    "url" => $randomString2
                );
                    // JSON encoded
                $json = json_encode($data);
                // Initialize cURL
                $curl = curl_init();
            //Create
                 curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_PUT );
                 curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PUT" );
                curl_setopt( $curl, CURLOPT_POSTFIELDS, $json);
               // Get return value
                curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
                // Make request
                // Close connection
                $response = curl_exec( $curl );
                curl_close( $curl );
                // Show result
                echo $response . "\n";
            }else if(strpos($event['message']['text'], 'tp-') !== false){
                    $getDataTp = $event['message']['text'];
                    $codeTransport = substr($getDataTp, 3, 10);
                    $statusId = substr($getDataTp, 14, 1);


            

                 $post = [
                     'codeTransport' => $codeTransport,
                     'statusId'   => $statusId,
                 ];
                $ch = curl_init('http://127.0.0.1:8000/api/transport/status');
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch,CURLOPT_POST, 1);
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                // execute!
                 $response = curl_exec($ch);
              $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $err = curl_error($ch);
                 
               
                     curl_close($ch);



                 // Build message to reply back
                 $messages = [
                     'type' => 'text',
                     'text' => 'success-'.$err.'http'.$http_status
                 ];
                    
                 // Make a POST Request to Messaging API to reply to sender
                 $url = 'https://api.line.me/v2/bot/message/reply';
                 $data = [
                     'replyToken' => $replyToken,
                     'messages' => [$messages],
                 ];
                 $post = json_encode($data);
                 $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

                 $ch = curl_init($url);
                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                 $result = curl_exec($ch);
                 curl_close($ch);
                 echo $result . "\r\n";

             }

            // Build message to reply back
            $messages = [
                'type' => 'text',
                'text' => $text
            ];

            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            echo $result . "\r\n";
        }elseif ($event['type'] == 'message' && $event['message']['type'] == 'sticker'){
            // Get sticker sent
            $packageId = $event['message']['packageId'];
            $stickerId = $event['message']['stickerId'];
            // Get replyToken
            $replyToken = $event['replyToken'];

            // Build message to reply back
            $messages = [
                'type' => 'sticker',
                'packageId' => $packageId,
                'stickerId' => $stickerId,
            ];

            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            echo $result . "\r\n";
        }
    }
}
