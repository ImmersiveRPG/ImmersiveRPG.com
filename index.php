<!DOCTYPE html>

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
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Immersive RPG</title>

	</head>
	<body>
		<style>
			*, *::before, *::after {
				box-sizing: border-box;
			}

			* {
				font-family: Helvetica, Arial, sans-serif;
			}

			a {
				font-size: 4rem;
			}

			a:link {
				color: yellow;
			}

			a:visited {
				color: yellow;
			}

			a:focus {
				color: orange;
			}

			a:hover {
				color: orange;
			}

			a:active {
				color: red;
			}

			html {
				box-sizing: border-box;
				min-height: 100%;
				height: 100%;
				color: white;
				background-color: black;
			}

			body {
				box-sizing: border-box;
				margin: 50px;
				padding: 0;
				min-height: 100%;
			}

			h1 {
				text-align: center;
				margin-bottom: 3.0rem;
				font-size: 5rem;
			}

			.links {
				//background: #d9d7d5;
				display: flex;
				flex-wrap: wrap;
				justify-content: space-between;
			}

			.links div {
				//background: #767775;
				text-align: center;
				flex-basis: 100%;
				height: 100px;
				margin-bottom: 0.5rem;
			}

			footer {
				text-align: center;
				font-size: 1rem;
			}

			footer a {
				font-size: 1rem;
			}

			.video div {
				text-align: center;
				width: 100%;
				height: 100%;
			}

			.video {
				width: 100%;
				height: 100%;
			}

			@media (min-width: 526px) {
				.video div iframe {
					width: 426px;
					height: 240px;
				}
			}

			@media (min-width: 740px) {
				.video div iframe {
					width: 640px;
					height: 360px;
				}
			}

			@media (min-width: 954px) {
				.video div iframe {
					width: 854px;
					height: 480px;
				}
			}

			@media (min-width: 1380px) {
				.video div iframe {
					width: 1280px;
					height: 720px;
				}
			}

			@media (min-width: 2020px) {
				.video div iframe {
					width: 1920px;
					height: 1080px;
				}
			}

			@media (min-width: 900px) {
				.links {
					flex-wrap: nowrap;
				}

				.links div {
					flex-basis: 50%;
				}
			}
		</style>
		<header>
			<h1>Let's make an Immersive RPG in Godot</h1>
		</header>

		<segment class="video">
			<div>
				<? if (count($ids) > 0) { ?>
				<iframe id="youtube_video" src="https://www.youtube.com/embed/<?= $ids[0] ?>" frameborder="0" allowfullscreen></iframe>
				<? } else { ?>
				<iframe src="https://www.youtube.com/embed/?list=PLlnj-W0EhsbtCTalstIUDmV2ZKgFbNkth" frameborder="0" allowfullscreen></iframe>
				<? } ?>
			</div>
		</segment>
		<segment class="links">
			<div><a href="https://godotengine.org/asset-library/asset?user=ImmersiveRPG">Plugins</a></div>
			<div><a href="https://github.com/ImmersiveRPG">Github</a></div>
			<div><a href="https://www.patreon.com/ImmersiveRPG">Patreon</a></div>
		</segment>
		<segment class="links">
			<div><a href="https://www.youtube.com/channel/UCfRXKGrGO9h6O0lAsSjbsCw">Youtube</a></div>
			<div><a href="https://bitchute.com/ImmersiveRPG">BitChute</a></div>
			<div><a href="https://rumble.com/user/ImmersiveRPG">Rumble</a></div>
		</segment>
		<segment class="links">
			<div><a href="https://twitter.com/ImmersiveRPG">Twitter</a></div>
			<div><a href="https://minds.com/ImmersiveRPG">Minds</a></div>
            <div><a href="https://reddit.com/u/ImmersiveRPG">Reddit</a></div>
		</segment>

		<footer>
			<p>Copyright &copy; 2022 Matthew Brennan Jones</p>
			<p>Licensed under the MIT License</p>
			<p>Source code: <a href="https://github.com/ImmersiveRPG/ImmersiveRPG.com">https://github.com/ImmersiveRPG/ImmersiveRPG.com</a></p>
		</footer>
	</body>
</html>
