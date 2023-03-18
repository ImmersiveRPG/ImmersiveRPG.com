<?php

// Show all errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function setup() {
	$ids = [];

	// Get the RSS feed for this Youtube channel
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/feeds/videos.xml?channel_id=UCfRXKGrGO9h6O0lAsSjbsCw');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	$data = curl_exec($ch);
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($http_status !== 200) {
		return $ids;
	}

	// Parse the feed as XML
	$feed = simplexml_load_string($data);
	if ($feed === false) {
		return $ids;
	}

	// Get the ids for all the videos
	foreach ($feed->children() as $child) {
		if ($child->getName() == "entry") {
			foreach($child->children() as $sub_child) {
				if ($sub_child->getName() == "id") {
					$id = preg_replace('/^yt:video:/', '', $sub_child);
					$ids[] = $id;
				}
			}
		}
	}

	return $ids;
}

$ids = setup();
header('Content-Type: application/json');
echo json_encode($ids);

?>
