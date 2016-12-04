/////////////////////////////////////////////////////////////////////////
// README.TXT for AudioDisplay v1.1                                    //
// William Andrew Klier 2012                                          //
/////////////////////////////////////////////////////////////////////////

AudioDisplay is an HTML5, javascript, and PHP script base for sharing music
on the web. It's made to be dropped into any directory of MP3s to display a
browser friendly HTML5 page with <audio> tags and simple javascript controls
that play and pause the music, as well as automatically play the next song
when the first song is done. **THANKS TO GetID3( http://www.getid3.org/ )**, an
open source PHP ID3 reader and writer class, AudioDisplay gets song
information like artist, album, and length from ID3v1, ID3v2, and Quicktime
tags. **THANKS TO Shortcut.js http://www.mattytemple.com/projects/shortcut-js/
you can play/pause with the space bar and ff/rw with left and right arrow,

// REQUIREMENTS

PHP 5.0.5 (or newer) and a running webserver.

// INSTALLATION & CONFIGURATION

- Unzip package contents (likely already done if you're reading this).

- Copy "audio_display" directory, and all of it's contents into the directory on your 
web server where the MP3s, other sound files (*OGG for firefox/opera*), artwork, 
playlist or zip file are. **MP3s have to be present in the directory for the script 
to work!**

- Change into the audio_display directory, and locate the file
"mp3index.php". move the file back a directory (into the directory where the
MP3s are). Rename the file to "index.php".

ex (unix):  > cd directory_with_mp3s/
            > wget http://www.shindagger.com/audio_display.zip
            > unzip audio_display.zip
            > cd audio_display/
            > cp mp3index.php ../index.php

That's it! Loading the web directory should display a list of songs now.
**Some web servers require index pages to use ".html". If the script doesn't
work, and you're sure you have PHP5 running, try changing the name of the
"mp3index.php" file to "../index.html" instead.**

- Due to limitations of certain browsers, MP3 format is not always supported. Having 
a duplicate of each MP3 in OGG ensures this script will work in all browsers. I've 
also included two shell scripts in utilities/ which utilize command line tools for 
converting MP3 and M4A to OGG. Faad, mp3123 and oggenc will need to be installed.

/directory_with_mp3s/MP3-FILES
/directory_with_mp3s/index.php (renamed from ./audio_display/mp3index.php)
/directory_with_mp3s/audio_display/FILES

// FILES 

-rw-r--r-- LICENSE.TXT
-rw-r--r-- README.TXT
-rw-r--r-- audio_display.css
-rw-r--r-- audio_display.js
-rw-r--r-- audio_display.php
drwxr-xr-x getid3/
-rw-r--r-- getid3/getid3.lib.php
-rw-r--r-- getid3/getid3.php
-rw-r--r-- getid3/license.commercial.txt
-rw-r--r-- getid3/license.txt
-rw-r--r-- getid3/module.audio-video.quicktime.php
-rw-r--r-- getid3/module.audio.mp3.php
-rw-r--r-- getid3/module.tag.apetag.php
-rw-r--r-- getid3/module.tag.id3v1.php
-rw-r--r-- getid3/module.tag.id3v2.php
-rw-r--r-- getid3/module.tag.lyrics3.php
-rw-r--r-- getid3/module.tag.xmp.php
-rw-r--r-- getid3/readme.txt
drwxr-xr-x images/
-rw-r--r-- images/lil_ff.png
-rw-r--r-- images/lil_pause.png
-rw-r--r-- images/lil_play.png
-rw-r--r-- images/lil_rr.png
-rw-r--r-- images/missing_art.jpg
-rw-r--r-- images/1_second_silence.ogg
-rw-r--r-- mp3index.php
-rw-r--r-- shortcut.js
drwxr-xr-x utilities/
-rwxrwxr-x utilities/m4a2ogg
-rwxrwxr-x utilities/mp32ogg

// LICENSE

GNU General Public License - see LICENSE.TXT

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to:
Free Software Foundation, Inc.
59 Temple Place - Suite 330
Boston, MA  02111-1307, USA.