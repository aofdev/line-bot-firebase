<?php
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('D8p6zodWI7B3lFnlf+Ejqko3sbgRsYOfxYIszOJw2GzPR9EjCOcZVoon6ytNMd7JcC/O1YzhplEkLNr4Y/QpT0MWAC0f0YR6ID6hyRI1MfMKs/ouGeIB6S6aDs9FGbyWzABgfqhCBOTnXHkNAJU1/QdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'd82b27a585108c6d25b1e40b6cc1cb0d']);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($event['message']['text']);
            $result = $bot->replyText($event['replyToken'], $textMessageBuilder);
			// Make a POST Request to Messaging API to reply to sender
            if ($result->isSucceeded()) {
                echo $result;
            }
            return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		}
	}
}
