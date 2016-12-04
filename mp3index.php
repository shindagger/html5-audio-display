<?php
require_once("audio_display/getid3/getid3.php");
include("audio_display/audio_display.php");
?>
<!DOCTYPE html>
<html lang="en">
<!-- Audio Display <?php print version(); ?> -->
<!-- William Andrew Klier -->
<!-- http://www.shindagger.com/audio_display.zip -->
<!-- http://www.shindagger.com/audio_display/ -->
<head>
	<title><?php print $playlist; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="audio_display/audio_display.css">
	<script src="audio_display/shortcut.js"></script>
	<script src="audio_display/audio_display.js"></script>
</head>
<body>
<section id="content">
<?php
if (!$mp3file) {
	print "<h1>No mp3's found</h1>";
} else {
?>
	<p><h1><?php print $playlist; ?></h1>
<?php
	if ($zip) {
		$zipref = "<a href=\"" . $zip . "\">";
		$ziprefc = "</a>";
	} else {
		$zipref = "";
		$ziprefc = "";
	}
?>
	<?php print $zipref; ?><img src="<?php print $album_art; ?>" width="<?php print $aa_width; ?>" height="<?php print $aa_height; ?>"><?php print $ziprefc; ?><br>
	<ul class="main_player">
		<li><a id="main_rr" href="javascript:{}" onclick="rr();"><img src="audio_display/images/lil_rr.png" height="11" width="15"></a></li>
		<li><a id="main_play" href="javascript:{}" onclick="main_play();" style="display: inherit;"><img src="audio_display/images/lil_play.png" height="11" width="9"></a><a id="main_pause" href="javascript:{}" onclick="main_pause();" style="display: none;"><img src="audio_display/images/lil_pause.png" height="11" width="9"></a></li>
		<li><a id="main_ff" href="javascript:{}" onclick="ff();"><img src="audio_display/images/lil_ff.png" height="11" width="15"></a></li>
		<li id="now_playing" style="font-size:.8em;"></li>
	</ul>
	<ul class="songs">
<?php
	$last_song = max(array_keys($mp3file));
	foreach ($mp3file as $i => $value) {
		$j = $i+1;
		if ($last_song == $i) {
			$onended = " onended=\"lastsong(" . $j . ");\"";
		} else {
			$onended = " onended=\"stopped(" . $j . ");\"";
		}
?>
		<li>
		<audio id="player_<?php print $j; ?>" preload="none"<?php print $onended; ?>>
<?php
		if (strlen($oggfile[$i]) > 0) {
?>
			<source src="<?php print $oggfile[$i]; ?>" type="audio/ogg">
<?php
		}
?>
			<source src="<?php print $mp3file[$i]; ?>" type="audio/mp3">
		</audio>
		<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
			<tr valign="middle">
				<td><a id="play_button_<?php print $j; ?>" href="javascript:{}" onclick="playmusic(<?php print $j; ?>);" style="padding-right: 10px; display: inherit;"><img src="audio_display/images/lil_play.png" height="11" width="9"></a><a id="pause_button_<?php print $j; ?>" href="javascript:{}" onclick="pausemusic(<?php print $j; ?>);" style="padding-right: 10px; display: none;"><img src="audio_display/images/lil_pause.png" height="10" width="9"></a></td>
				<td style="font-size:.9em; white-space:nowrap;" id="song_title_<?php print $j; ?>"><?php print $audio_title[$i]; ?> - <?php print $length[$i]; ?> &nbsp; &nbsp; <span style="font-size:.8em;"><?php print $artist[$i]; ?> - <?php print $album[$i]; ?></span></td>
			</tr>
			</tbody>
		</table>
		</li>
<?php
	}
?>
	</ul>
<?php
}
?>
	<div class="clearfooter"></div>
</section>
<footer>
	<a href="http://www.shindagger.com/audio_display/" target="_blank" style="color:#666666;">Audio Display</a> 2012 William Andrew Klier. This project made possible by: <a href="http://www.getid3.org" target="_blank" style="color:#666666;">getID3()</a>&nbsp;&nbsp;
</footer>
</body>
</html>