var current_player = 0;
var is_playing = 0;
function playmusic(id) {
	if (current_player) {
		if (!document.getElementById('player_' + current_player).paused) {
			document.getElementById('player_' + current_player).pause();
			document.getElementById('player_' + current_player).currentTime=0;
			document.getElementById('pause_button_' + current_player).style.display='none';
			document.getElementById('play_button_' + current_player).style.display='inherit';
		}
	}
	current_player = id;
	get_title(id);
	document.getElementById('player_' + id).play();
	is_playing = 1;
	document.getElementById('play_button_' + id).style.display='none';
	document.getElementById('pause_button_' + id).style.display='inherit';
	document.getElementById('main_play').style.display='none';
	document.getElementById('main_pause').style.display='inherit';
}
function pausemusic(id) {
	document.getElementById('player_' + id).pause();
	is_playing = 0;
	document.getElementById('pause_button_' + id).style.display='none';
	document.getElementById('play_button_' + id).style.display='inherit';
	document.getElementById('main_play').style.display='inherit';
	document.getElementById('main_pause').style.display='none';
	document.getElementById('now_playing').innerHTML="";
}
function stopped(id) {
	document.getElementById('pause_button_' + id).style.display='none';
	document.getElementById('play_button_' + id).style.display='inherit';
	nextid = id + 1;
	current_player = nextid;
	get_title(nextid);
	document.getElementById('player_' + nextid).play();
	is_playing = 1;
	document.getElementById('play_button_' + nextid).style.display='none';
	document.getElementById('pause_button_' + nextid).style.display='inherit';
        document.getElementById('main_play').style.display='none';
        document.getElementById('main_pause').style.display='inherit';
}
function main_play() {
	if (current_player == 0) {
		id = 1;
	} else {
		id = current_player;
	}
	playmusic(id);
	document.getElementById('main_play').style.display='none';
	document.getElementById('main_pause').style.display='inherit';
}
function main_pause() {
	id = current_player;
	pausemusic(id);
	document.getElementById('main_play').style.display='inherit';
	document.getElementById('main_pause').style.display='none';
}
function rr() {
	if (current_player) {
		current_time = document.getElementById('player_' + current_player).currentTime;
		if (current_time > 1) {
			document.getElementById('player_' + current_player).currentTime = 0;
		} else {
			if (current_player > 1) {
				id = current_player - 1;
				playmusic(id);
			} else {
				document.getElementById('player_' + current_player).currentTime = 0;
			}
		}
	}
}
function ff() {
	if (current_player) {
		end_time = document.getElementById('player_' + current_player).duration;
		document.getElementById('player_' + current_player).currentTime = end_time;
	}
}
function lastsong(id) {
	document.getElementById('main_play').style.display='inherit';
        document.getElementById('main_pause').style.display='none';
        document.getElementById('pause_button_' + id).style.display='none';
        document.getElementById('play_button_' + id).style.display='inherit';
	current_player = 0;
}
function get_title(id) {
	my_td = document.getElementById('song_title_' + id).innerHTML;
	hyph_pos = my_td.indexOf(" -");
	my_td = my_td.substr(0, hyph_pos);
	document.getElementById('now_playing').innerHTML = "<strong>Now Playing:</strong> "+my_td;
}
shortcut.add("Space",function() {
	if (is_playing == 1) {
		main_pause();
	} else {
		main_play();
	}	
},{
	'type':'keydown',
	'propagate':true,
	'target':document
});
shortcut.add("Right",function() {
	ff();
},{
        'type':'keydown',
        'propagate':true,
        'target':document
});
shortcut.add("Left",function() {
        rr();
},{
        'type':'keydown',
        'propagate':true,
        'target':document
});

