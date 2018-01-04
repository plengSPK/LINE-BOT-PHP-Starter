<?php
$access_token = 'Eqd+DHouXqXO0SeRpTNRhDVCb1ibCVn+Yhf1EcqDS9+wu/Lck42VR4fnvqUlsmPvW/6P8pQQHuRGxGe/b00M5i2zlBcFdDmIYF6Y+kICN2SFtbF4JoUeezM2/Zj11hPb6GAl6214m9I5Oh3kwljB4wdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message') {
			if ($event['message']['type'] == 'text') {
				// Get text sent
				$text = $event['message']['text'];
				
				if (strpos($text, 'where') !== false) {
					$location = str_replace('where', '', $text);
					$maps_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $location;
					$maps_json = file_get_contents($maps_url);
					$maps_array = json_decode($maps_json, true);
					
					$address = $maps_array['results'][0]['formatted_address'];
					$lat = $maps_array['results'][0]['geometry']['location']['lat'];
					$lng = $maps_array['results'][0]['geometry']['location']['lng'];
					
					// Get replyToken
					$replyToken = $event['replyToken'];

					// Build message to reply back
					$messages = [
						'type' => 'location',
						'title' => $location,			
						'address' => $address,
						'latitude' => $lat,
						'longitude' => $lng
					];
				}
				else {				
					// Get replyToken
					$replyToken = $event['replyToken'];

					// Build message to reply back
					$messages = [
						'type' => 'text',
						'text' => $text
					];
				}
			}
			if ($event['message']['type'] == 'sticker') {
				$packageId = $event['message']['packageId'];
				$stickerId = $event['message']['stickerId'];
				// Get replyToken
				$replyToken = $event['replyToken'];

				// Build message to reply back
				$messages = [
					'type' => 'sticker',
					'packageId' => $packageId,
					'stickerId' => $stickerId
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
