<?php
include("simplepie_1.3.1.compiled.php");

function convert_duration($sec) {
	$h = floor($sec/3600);
	$m = floor($sec/60) % 60;
	$s = $sec % 60;
	$out = "";
	if ($h>0)
		$out .= $h . "h&nbsp;";
	if ($m>0)
		$out .= $m . "m&nbsp;";
	$out .= $s . "s";
	return $out;
}

$feed = new SimplePie();
$feed->set_feed_url('http://penndorf.me/rfc/video-feed.php');
$feed->init();
$feed->handle_content_type();

$items = array();

foreach ($feed->get_items() as $feed_item){
	if ($enclosure = $feed_item->get_enclosure()) {
		$item = array();
		$item["duration"] = convert_duration($enclosure->get_duration(false));
		$item["description"] = $feed_item->get_description();
		$item["id"] = basename($enclosure->get_link(), ".mp4");
		$item["publishedAt"] = $feed_item->get_date("d.m.Y");
		$item["title"] = $feed_item->get_title();
		$item["filesize"] = $enclosure->get_size();
		$item["file"] = $enclosure->get_link();
		$items[] = $item;
	}
}

?><!DOCTYPE html>
<html>
<head>
	<title>Request for Comments</title>
	
	<meta charset="utf-8">
	
	<link rel="alternate" type="application/rss+xml" title="Video Feed" href="http://penndorf.me/rfc/video-feed.php">
	<link rel="alternate" type="application/rss+xml" title="Audio Feed" href="http://penndorf.me/rfc/feed.php">
	
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	
	<script type="text/javascript" src = "http://api.flattr.com/js/0.6/load.js?mode=auto"></script>
	<script src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div class="container-narrow">

	  <div class="masthead">
		<ul class="nav nav-pills pull-right">
		  <li class="active"><a href="index.php">Bei- und Vorträge</a></li>
		  <li><a href="imprint.htm">Kontakt/Impressum</a></li>
		</ul>
		<h3 class="muted">RFC</h3>
	  </div>

	  <hr>

	  <div class="jumbotron">
			<h1>Request for Comments</h1>
			<p class="lead">Hier spricht David Penndorf. Bei- und Vorträge, Experimente und sonstige Mitschnitte.</p>
			<a href="https://itunes.apple.com/de/podcast/hasi-talks/id689712949?mt=2"><img src="subscribe.png"></a>
			<div style="margin-top: 10px;">
				<a href="https://penndorf.me/rfc/feed.php">Audio-Feed direkt abonieren</a> <br /> <br />
				<a href="https://penndorf.me/rfc/video-feed.php">Video-Feed direkt abonieren</a> <br /> <br />
				<script id='fb3wshf'>(function(i){var f,s=document.getElementById(i);f=document.createElement('iframe');f.src='//api.flattr.com/button/view/?uid=Hybr1s&url=http%3A%2F%2Fpenndorf.me%2Frfc%2F';f.title='Flattr';f.height=62;f.width=55;f.style.borderWidth=0;s.parentNode.insertBefore(f,s);})('fb3wshf');</script>
				<br /><br />
                                <a href="https://twitter.com/hybr1s">@Hybr1s</a>
			</div>
	  </div>

	  <hr>

	<table class="table table-condensed table-striped">
		<tr>
			<th>Titel</th><th>Erschienen</th><th>Länge</th><th>Download</th><th>Watch it</th>
		</tr>
		<?php foreach ($items as $item) { ?>
		<tr id="<?=$item["id"];?>">
			<td><?=$item["title"];?></td><td><?=$item["publishedAt"];?></td><td style="text-align: right;"><?=$item["duration"];?></td><td style="text-align: center;"><a href="<?=$item["file"];?>">.mp4</a>&nbsp;<a href="data/audio/<?=$item["id"];?>.aac">.aac</a></td><td><a href="https://www.youtube.com/watch?v=<?=$item["id"];?>">YouTube</a></td>
		</tr>
		<?php } ?>

	</table>

	  <hr>

	  <div class="footer">
		<p style="text-align: center;"><a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/deed.de"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a></p>
	  </div>

	</div> <!-- /container -->

</body>
</html>
