<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'HWo5n9a0MDh5XLLNjHjpvI5qgG0/bCO2wUx92DagXo1TqCiMchGXbuTP0bLwd4NslAq9bxUUn3RLvQJ585KHwHDOIIUaFMRjSh8VPBP2pEfQGO7KTsAjpPRVwvofZbvCPUUwvPSUhz9CNYUm773HigdB04t89/1O/w1cDnyilFU=';

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
					
					// Get replyToken
					$replyToken = $event['replyToken'];
					// Get text sent
					$text = $event['message']['text'];
					$userid = $event['source']['userId'];
					if($text == "Yes"){
						$messages = [
						'type' => 'text',
						'text' => $userid
						];
					}else if($text == "No"){
						$messages = [
						'type' => 'text',
						'text' => 'ขอบคุณที่ใช้บริการ'
						];
					}else{
						$messages = [
						'type' => 'text',
						'text' => 'สวัสดี หากท่านต้องการ User ID พิมพ์ Yes'
						];
					}
							
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
		echo "OK";
