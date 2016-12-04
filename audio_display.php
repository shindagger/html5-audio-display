<?php
$dir = "./"; /* current directory. set to directory with all album files. */

////////////////////////////
// http://www.getid3.org/
////////////////////////////
$getID3 = new getID3;

///////////////////////////////////////////////////////////////
// Open a known directory, and proceed to diplay a list of audio files.:
//
// This is the business of the script. If you want this script 
// to work in FIREFOX or OPERA you'll need to include OGG filess 
// too. OGG files will need to have the same filename as the mp3.
// This script does not support WAV!!
// 
// If you have more than one image file for album artwork the 
// script will use the last image alphabetically. Same for the 
// m3u file. The script will use the last one alphabetically. 
// Currently we only support one of each.
// 
// The script does not require a playlist file or a ZIP file.
// If a playlist file (M3U) exists, it will set the HTML page 
// title to the name of the playlist.
// If a ZIP file exists, the album artwork will link to the 
// ZIP file.
//////////////////////////////////////////////////////////////

$number_of_files = 0;
if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
                $files = scandir($dir, 0);
                foreach($files as $file){
                        if (filetype($dir . $file) != "dir") {
                                if (stristr($file, ".mp3") || stristr($file, ".m4a")) {
// file is MP3 or M4A
                                        $mp3file[] = $file;
                                        $ogg = substr($file, 0, -4) . ".ogg";
                                        if (file_exists($ogg)) {
                                                $oggfile[] = substr($file, 0, -4) . ".ogg";
                                        } else {
						$is_ogg = glob("*.ogg");
						if (strlen($is_ogg[0]) > 0) {
							$oggfile[] = "audio_display/images/1_second_silence.ogg";
						}
                                        }
                                        $ThisFileInfo = $getID3->analyze($file); // get id3 info
					if (strlen($ThisFileInfo['tags']['id3v2']['title'][0]) > 0) {
	                                        $audio_title[] = $ThisFileInfo['tags']['id3v2']['title'][0]; // song title array
					} else if (strlen($ThisFileInfo['tags']['id3v1']['title'][0]) > 0) {
						$audio_title[] = $ThisFileInfo['tags']['id3v1']['title'][0];
                                        } else if (strlen($ThisFileInfo['tags']['quicktime']['title'][0]) > 0) {
                                                $audio_title[] = $ThisFileInfo['tags']['quicktime']['title'][0];
                                        } else {
						$audio_title[] = str_replace(".mp3", "", $file);
					}
                                        $track_info[] = $ThisFileInfo['id3v2']['comments']['track_number'][0]; // track_number/total_tracks array
                                        $tracks = explode("/", $ThisFileInfo['id3v2']['comments']['track_number'][0]);
                                        $track_number[] = $tracks[0]; // track number array
                                        if (strlen($ThisFileInfo['tags']['id3v2']['artist'][0]) > 0) {
                                                $artist[] = $ThisFileInfo['tags']['id3v2']['artist'][0]; //artist array
                                        } else if (strlen($ThisFileInfo['tags']['id3v1']['artist'][0]) > 0) {
                                                $artist[] = $ThisFileInfo['tags']['id3v1']['artist'][0];
                                        } else if (strlen($ThisFileInfo['tags']['quicktime']['artist'][0]) > 0) {
                                                $artist[] = $ThisFileInfo['tags']['quicktime']['artist'][0];
                                        } else {
                                                $artist[] = "";
                                        }
                                        if (strlen($ThisFileInfo['tags']['id3v2']['album'][0]) > 0) {
                                                $album[] = $ThisFileInfo['tags']['id3v2']['album'][0]; // album array
                                        } else if (strlen($ThisFileInfo['tags']['id3v1']['album'][0]) > 0) {
                                                $album[] = $ThisFileInfo['tags']['id3v1']['album'][0];
                                        } else if (strlen($ThisFileInfo['tags']['quicktime']['album'][0]) > 0) {
                                                $album[] = $ThisFileInfo['tags']['quicktime']['album'][0];
                                        } else {
                                                $album[] = "";
                                        }
                                        $length[] = $ThisFileInfo['playtime_string']; // song length array
					$seconds[] = $ThisFileInfo['playtime_seconds']; // playtime seconds
                                } else if (stristr($file, ".m3u")) {
// playlist file
                                        $playlist = str_replace(".m3u", "", $file); // set page title and h1 to playlist name
					$playlist_file = $file;
				} else if (stristr($file, ".zip")) {
// ZIP file
					$zip = $file;
                                } else if (stristr($file, ".jpg") || stristr($file, ".gif") || stristr($file, ".png")) {
// image file
					$album_art = $file;
					if (strlen($album_art) == 0) {
						$album_art = "audio_display/images/missing_art.jpg";
					}
					$imagesize = getimagesize($album_art);
					$aa_width = $imagesize[0];
					$aa_height = $imagesize[1];
					while ($aa_width > 400) {
						$aa_width = $aa_width / 2;
						$aa_height = $aa_height / 2;
					}
					while ($aa_height > 400) {
                                                $aa_width = $aa_width / 2;
                                                $aa_height = $aa_height / 2;
                                        }
				}
				$number_of_files++;
                        }
                }
                closedir($dh);
        }
}
if (strlen($album_art) == 0) {
	$album_art = "audio_display/images/missing_art.jpg";
	$aa_width = 250;
	$aa_height = 250;
}
if (strlen($playlist) == 0) {
// if no $playlist is set we check if every song is from the 
// same album or artist and if so we set the title to the that name. 
// otherwise, we set the title to "Random directory of MP3s"
	$y = 1;
	$str = $album[0];
	$different_albums = 7;
	while ($y < $number_of_files) {
		if (strlen($album[$y]) > 0) {
			if ($str != $album[$y]) {
				$different_albums = 666;
			}
		}
		$str = $album[$y];
		$y++;
	}
	$z = 1;
	$str = $artist[0];
	$different_artist = 7;
        while ($z < $number_of_files) {
                if (strlen($artist[$z]) > 0) {
                        if ($str != $artist[$z]) {
                                $different_artist = 666;
                        }
                }
                $str = $artist[$z];
                $z++;
        }
	if ($different_albums == 666 && $different_artist == 666) {
	        $playlist = "Random directory of MP3s";
	} else {
		if ($different_albums == 7) {
			$playlist = $album[0];
		} else {
			$playlist = $artist[0];
		}
	}
} else {
//////////////////////
// Playlist exists. read through the file and get filenames.
// destroy oggfile and mp3file and recreate all data.
//////////////////////

	$getID3_2 = new getID3;

	$fh = fopen($playlist_file, 'r');
	$theData = fread($fh, 3000000);
	fclose($fh);
	$theArray = explode("#EXT", $theData);
	$x = 200;
	$y = 0;
	$w = 0;
	while ($y < $x) {
		if (!strstr($theArray[$y], "M3U")) {
			$str = nl2br($theArray[$y]);
			$str_arr = explode("<br />", $str);
			$fn_line = $str_arr[1];	
			if (strlen($fn_line) > 0) {
				# thank fucking god for basename() i suck at regexp
				$file = basename($fn_line);
				$file = trim($file);
				if (file_exists($file)) {
					if ($w == 0) {
					        $d = 0;
					        while ($d < $number_of_files) {
					                unset($mp3file[$d]);
					                unset($oggfile[$d]);
							unset($audio_title[$d]);
							unset($track_info[$d]);
							unset($track_number[$d]);
							unset($artist[$d]);
							unset($album[$d]);
							unset($length[$d]);
					                $d++;
					        }
						$mp3file = array();
						$oggfile = array();
						$audio_title = array();
						$track_info = array();
						$track_number = array();
						$artist = array();
						$album = array();
						$length = array();
					}
					$mp3file[] = $file;
					$ogg = substr($file, 0, -4) . ".ogg";
					if (file_exists($ogg)) {
						$oggfile[] = substr($file, 0, -4) . ".ogg";
					} else {
                                                $is_ogg = glob("*.ogg");  
                                                if (strlen($is_ogg[0]) > 0) {
							$oggfile[] = "audio_display/images/1_second_silence.ogg";
						}
					}
					$ThisFileInfo = $getID3_2->analyze($file); // get id3 info
					if (strlen($ThisFileInfo['tags']['id3v2']['title'][0]) > 0) {
						$audio_title[] = $ThisFileInfo['tags']['id3v2']['title'][0]; // song title array
					} else if (strlen($ThisFileInfo['tags']['id3v1']['title'][0]) > 0) {
						$audio_title[] = $ThisFileInfo['tags']['id3v1']['title'][0];
					} else if (strlen($ThisFileInfo['tags']['quicktime']['title'][0]) > 0) {
	                                        $audio_title[] = $ThisFileInfo['tags']['quicktime']['title'][0];
					} else {
						$audio_title[] = str_replace(".mp3", "", $file);
					}
					$track_info[] = $ThisFileInfo['id3v2']['comments']['track_number'][0]; // track_number/total_tracks array
					$tracks = explode("/", $ThisFileInfo['id3v2']['comments']['track_number'][0]);
					$track_number[] = $tracks[0]; // track number array
					if (strlen($ThisFileInfo['tags']['id3v2']['artist'][0]) > 0) {
						$artist[] = $ThisFileInfo['tags']['id3v2']['artist'][0]; //artist array
					} else if (strlen($ThisFileInfo['tags']['id3v1']['artist'][0]) > 0) {
						$artist[] = $ThisFileInfo['tags']['id3v1']['artist'][0];
					} else if (strlen($ThisFileInfo['tags']['quicktime']['artist'][0]) > 0) { 
	                                        $artist[] = $ThisFileInfo['tags']['quicktime']['artist'][0];
					} else {
						$artist[] = "";	
					}
					if (strlen($ThisFileInfo['tags']['id3v2']['album'][0]) > 0) {
						$album[] = $ThisFileInfo['tags']['id3v2']['album'][0]; // album array
					} else if (strlen($ThisFileInfo['tags']['id3v1']['album'][0]) > 0) {
						$album[] = $ThisFileInfo['tags']['id3v1']['album'][0];
					} else if (strlen($ThisFileInfo['tags']['quicktime']['album'][0]) > 0) {
	                                        $album[] = $ThisFileInfo['tags']['quicktime']['album'][0];
					} else {
						$album[] = "";
					}
					$length[] = $ThisFileInfo['playtime_string']; // song length array
					$seconds[] = $ThisFileInfo['playtime_seconds']; // playtime seconds
					$w++;
				}					
			}
		}
		$y++;
	}
	if ($w == 0) {
                $playlist = "Random directory of MP3s";
	}
}
function version() {
$lines = file('audio_display/README.TXT');
$l_count = count($lines);
        for($x = 0; $x< $l_count; $x++) {
        }
        $line = $lines[1];
        $line = str_replace("                                    //", "", $line);
        $line = rtrim($line);
        $line = substr($line, -4);
        return $line;
}
?>