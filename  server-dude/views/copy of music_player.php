<!DOCTYPE html>
<html>
<head>
	<title>Music Server</title>
	<meta charset="utf-8" /> 
	<link href="../css/screen.css" rel="stylesheet" type="text/css" media="screen, tv, projection" />
	<link href="../css/screen1024px.css" rel="stylesheet" type="text/css" media="screen, tv, projection" />
	<style type="text/css">
			
	</style>
	<!--<script type="text/javascript" src="../javascript/jquery-1.8.3.min.js"></script>-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</head>

<body>

<div id="nowPlayingInfo">
	<span id="nowPlayingFileName"></span>
	<br />
	Position of current song in playlist: <span id='songNumber'></span>
	<br />
<div id="musicControls">
	<span id="previous">PREVIOUS</span>
	<span id="playPause">PLAY/PAUSE</span>
	<span id="next">NEXT</span>
	<br />
	<span id= "stop">STOP</span>
	<span id="play">PLAY</span>
	<span id="pause">PAUSE</span>
	<br />
	<span id="toEnd">Skip To End</span>


</div>
<div id="musicPlayer">
</div>

<script type="text/javascript">
MusicPlayer = {
	//settings
	noPreviousPlayers: 1,
	noNextPlayers: 2,
	
	//variables
	//startingPlayerNo:1,					//also defines the number of "previous players"
	noPlayers:null,							//number of players				
	playerIDs: Array(),
	currentPlayer: null,				
	activePlaylist: Array(),
	currentSongNumber: null,				//position of current song in activePlaylist[]
	stopped:1,
	paused:1,
	
	init: function() {
		this.noPlayers=this.noPreviousPlayers+this.noNextPlayers+1;
		
		//create audio elements, give them IDs and put those in playerIDs[]
		for (i=0;i<this.noPlayers;i++) {
			$('div#musicPlayer').append('<audio>Your browser does not support the audio element.</audio>\n');
			this.playerIDs.push('player'+i);
			$('#musicPlayer audio:last').attr('id',this.playerIDs[i]);
		}
		this.activePlaylistInput(this.activePlaylist,0);
		this.changePlayer(this.activePlaylist[this.currentSongNumber]);
	},
	
	//changes currentPlayer to the one with the specified song
	changePlayer: function (newSong) {
		this.currentPlayer=document.getElementById(newSong);
		//this.currentPlayer=$('#'+newSong).get(0);
		this.currentPlayer.oncanplay=function() {
			MusicIO.updateNowPlayingInfo();
		};
		this.currentPlayer.onended=function() {
			MusicPlayer.songFinished();
		};
	},
	
	songFinished: function () {
		if (this.activePlaylist.length<2&&this.loopPlaylist!=true) {
			this.stop();
		}
		else {
			this.nextSong();
		}
	},
		
	//loads songs from activePlaylist into players
	reloadSongs: function () {
		songsToLoad=Array();
		playersToUnload=Array();
		songsLoaded=this.playerIDs;
			
		//fill songsToLoad from activePlaylist
		if (this.activePlaylist.length<this.noPlayers) {
			for (i in this.activePlaylist) {
				songsToLoad.push(this.activePlaylist[i]);
			}
		}
		else if (this.currentSongNumber<this.noPreviousPlayers) {
			for (i=0;i<this.noPlayers;i++) {
				songsToLoad.push(this.activePlaylist[i]);
			}
		}
		else {
			for (i=this.currentSongNumber-this.noPreviousPlayers;i<=this.currentSongNumber+this.noNextPlayers;i++) {
				songsToLoad.push(this.activePlaylist[i]);
			}
		}
		//fill playersToUnload with players that should be overwritten
		//remove already loaded songs from songsToLoad
		for (i in songsLoaded) {
			if (songsToLoad.indexOf(songsLoaded[i])==-1) {
				playersToUnload.push(songsLoaded[i]);
			}
			else {
				songsToLoad.splice(songsToLoad.indexOf(songsLoaded[i]),1);
			}
		}
		alert(songsToLoad)
		//load songs from songsToLoad to players from playersToUnload
		//the sources of songs in playersToUnload are replaced by the ids of the players with those songs
		for (i in playersToUnload) {
			document.getElementById(playersToUnload[i]).src=songsToLoad[0];
			alert(songsToLoad[0])
			document.getElementById(playersToUnload[i]).load();
			alert('')
			document.getElementById(playersToUnload[i]).id=songsToLoad.shift();
		}
		//update the sources, ids and this.playerIDs
		$('#musicPlayer audio').each(function(i,element){
			if (typeof ($(this).attr('src'))!='undefined') {
				MusicPlayer.playerIDs[i]=$(this).attr('id');
			}
		});
	},
	
	playPause: function () {
		if (this.paused){
            this.play();
		}
        else {
            this.pause();
		}
	},
	
	play: function 	() {
		 this.currentPlayer.play();
		 this.paused=0
		 this.stopped=0;
		},	
	
	pause: function () {
		 this.currentPlayer.pause();
		 this.paused=1;
	},
	
	stop: function() {
		this.pause();
		this.setTime(0);
		this.stopped=1;
	},
	
	nextSong: function () {
		this.pause();
		this.setTime(0);
		this.currentSongNumber=(this.currentSongNumber+1)%this.activePlaylist.length;
		this.reloadSongs();
		this.changePlayer(this.activePlaylist[this.currentSongNumber]);
		if (this.stopped==0){
			this.play();
		}
	},
	
	previousSong: function () {
		this.pause();
		this.setTime(0);
		this.currentSongNumber=(this.currentSongNumber-1+this.activePlaylist.length)%this.activePlaylist.length;
		this.reloadSongs();
		this.changePlayer(this.activePlaylist[this.currentSongNumber]);
		if (this.stopped==0){
			this.play();
		}
	},
	
	setTime: function (time,relative) {
		if (relative==true) {
			this.currentPlayer.currentTime=time*this.currentPlayer.duration;
		}
		else{
			this.currentPlayer.currentTime=time;
		}
	},

	activePlaylistInput: function(activePlaylist,currentPosition) {
		this.activePlaylist=activePlaylist;
		this.currentSongNumber=currentPosition;
		this.reloadSongs();
	},

};

MusicIO = {


	init: function () {
		$('#previous').click(function () {
			MusicPlayer.previousSong();
		});
		$('#next').click(function () {
			MusicPlayer.nextSong();
		});
		$('#playPause').click(function () {
			MusicPlayer.playPause();
		});
		$('#play').click(function () {
			MusicPlayer.play();
		});
		$('#pause').click(function () {
			MusicPlayer.pause();
		});
		$('#stop').click(function () {
			MusicPlayer.stop();
		});
	},

	updateNowPlayingInfo: function () {
			$('#nowPlayingFileName').html(MusicPlayer.currentPlayer.currentSrc);
			$('#songNumber').html(MusicPlayer.currentSongNumber);
	}
	
};


//length of playlist = minimal # audio elemtns
ActivePlaylistManager = {
	playerIDs: Array(),
	currentPlayer: null,

	init: function() {
	},

};


$(document).ready(function (){	
MusicPlayer.activePlaylist=[
	"../test0.ogg",	//previous
	"../test1.ogg",	//current
	"../test2.ogg",	//next
	"../test3.ogg",	//second next
	];

	MusicPlayer.init();
	MusicIO.init();
	ActivePlaylistManager.init();
	
	$('#toEnd').click(function () {
		MusicPlayer.currentPlayer.currentTime=(MusicPlayer.currentPlayer.duration)-2; 
	})
	
	
});
</script>

</body>
</html>