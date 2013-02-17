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
	Player: <span id='playerNumber'></span>
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
	noNextPlayers: 2,					//SHOULD BE AT LEAST 1
	
	//variables
	//startingPlayerNo:1,					//also defines the number of "previous players"
	noPlayers:null,							//number of players
	currentPlayerNo: null,					
	playerIDs: Array(),
	currentPlayer: null,
	activePlaylist: Array(),
	currentSongNumber: null,			//position of current song in activePlaylist[]
	stopped:1,
	paused:1,
	
	init: function() {
		/*
		//make an Array of the IDs of all Audio Tags
		$('#musicPlayer audio').each(function(index,element){
			MusicPlayer.playerIDs.push($(this).attr('id'));
		});*/
		this.noPlayers=this.noPreviousPlayers+this.noNextPlayers+1;
		this.currentPlayerNo=this.noPreviousPlayers;
		
		//create audio elements, give them IDs and put those in playerIDs[]
		for (i=0;i<this.noPlayers;i++) {
			$('div#musicPlayer').append('<audio>Your browser does not support the audio element.</audio>\n');
			this.playerIDs.push('player'+i);
			$('#musicPlayer audio:last').attr('id',this.playerIDs[i]);
		}
		/*
		this.currentPlayerNo=this.startingPlayerNo;
		this.noPlayers=this.playerIDs.length;
		this.noPreviousPlayers=this.startingPlayerNo;
		this.noNextPlayers=this.noPlayers-this.noPreviousPlayers-1;
		*//*
		this.loadSong("../test0.ogg",-1);
		this.loadSong("../test1.ogg",0);
		this.loadSong("../test2.ogg",+1);
		this.loadSong("../test3.ogg",+2);*/
		this.changePlayer(0);
		this.activePlaylistInput(this.activePlaylist,this.currentPlayerNo);
	},
	
	//changes currentPlayer to next one or specified one
	changePlayer: function (playerNo,absolute) {
		if (typeof playerNo=='undefined') {
			playerNo=this.currentPlayerNo+1;
		}
		else if (absolute!=true) {
			playerNo=this.currentPlayerNo+playerNo
		}		
		this.currentPlayerNo=((playerNo%this.noPlayers)+this.noPlayers)%this.noPlayers;		//double % is for negative numbers(do not remove)
		this.currentPlayer=$('#'+this.playerIDs[this.currentPlayerNo]).get(0);
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
		
	//loads a song in the current player or a specified one(relative to current)
	loadSong: function (songSrc,playerNo,autoplay) {
		if(typeof playerNo=='undefined') {
			playerNo=this.currentPlayerNo;
		}
		else /*if (absolute!='abs' &&  absolute!='absolute' && absolute!=1)*/ {
			playerNo=playerNo+this.currentPlayerNo;
			playerNo=((playerNo%this.noPlayers)+this.noPlayers)%this.noPlayers;
		}
				
		$('#'+this.playerIDs[playerNo]).attr('src',songSrc);
		if (autoplay== true){
			$('#'+this.playerIDs[playerNo]).get(0).play();
		}
		else {
			$('#'+this.playerIDs[playerNo]).get(0).load();
		}
	},
	
	//ex: switchSongs(1,3)
	switchSongs: function(playerFrom,playerTo) {
		$('#player'+playerFrom).attr('id','playerTemp');
		$('#player'+playerTo).attr('id','player'+playerFrom);
		$('#playerTemp').attr('id','player'+playerTo);
		
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
		if ($('#'+this.playerIDs[(this.currentPlayerNo+1)%this.noPlayers]).data('empty')!='empty') {
			this.changePlayer(+1);
		}
		else {
			for (i=(this.currentPlayerNo-this.noPreviousPlayers+this.noPlayers)%this.noPlayers;/* i!=this.currentPlayerNo */;i=(i+1)%this.noPlayers) {
				if ($('#'+this.playerIDs[i]).data('empty')!='empty') {
					this.changePlayer(i,true);
					break;
				}
			}		
		}
		if (this.stopped==0){
				this.play();
		}
		this.currentSongNumber=(this.currentSongNumber+1)%this.activePlaylist.length;
		
		
		this.loadSong(this.activePlaylist[(this.currentSongNumber+this.noNextPlayers)%this.activePlaylist.length],this.noNextPlayers);
	},
	
	previousSong: function () {
		this.pause();
		this.setTime(0);
		this.changePlayer(-1);
		if (this.stopped==0){
			this.play();
		}
		this.currentSongNumber=(this.currentSongNumber-1+this.activePlaylist.length)%this.activePlaylist.length;
		this.loadSong(this.activePlaylist[(this.currentSongNumber-this.noPreviousPlayers+this.activePlaylist.length)%this.activePlaylist.length],-this.noPreviousPlayers);
	},
	
	setTime: function (time,relative) {
		if (relative==true) {
			this.currentPlayer.currentTime=time*this.currentPlayer.duration;
		}
		else{
			this.currentPlayer.currentTime=time;
		}
	},

	activePlaylistInput: function(activePlaylist,currentSong) {
		this.activePlaylist=activePlaylist;
		this.currentSongNumber=currentSong;
		while (this.currentSongNumber<this.noPreviousPlayers) {
			this.activePlaylist.unshift('empty');
			this.currentSongNumber++;
		}		
		while (this.activePlaylist.length<this.noPlayers.length) {
			this.activePlaylist.push('empty');
		}		
		for (i=0;i<this.noPlayers;i++) {
			if (this.activePlaylist[this.currentSongNumber+(i-this.noPreviousPlayers)]=='empty') {
				//$(MusicPlayer.currentPlayer).attr('data-empty','empty');
				$('#'+this.playerIDs[this.currentPlayerNo+(i-this.noPreviousPlayers)]).attr('data-empty','empty');
				//alert(	$(this.currentPlayer).data('empty'))
				// alert(	$('#'+this.playerIDs[this.currentPlayerNo+i-this.noPreviousPlayers]).data('empty'))
			}
			else {
				$('#'+this.playerIDs[this.currentPlayerNo+(i-this.noPreviousPlayers)]).attr('data-empty','notEmpty');
				this.loadSong(this.activePlaylist[this.currentSongNumber+(i-this.noPreviousPlayers)],i-this.noPreviousPlayers);
			}
		}
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
			$('#playerNumber').html(MusicPlayer.currentPlayerNo);
	}
	
};


//length of playlist = minimal # audio elemtns
ActivePlaylistManager = {
	currentPlayerNo: 1,
	playerIDs: Array(),
	currentPlayer: null,				

	init: function() {
	},

};


$(document).ready(function (){	
MusicPlayer.activePlaylist=[
	//"../test0.ogg",	//previous
	'empty',
	"../test1.ogg",	//current
	//"../test2.ogg",	//next
	'empty',
	"../test3.ogg",	//second next
	];

	MusicPlayer.init();
	MusicIO.init();
	//ActivePlaylistManager.init();
	
	$('#toEnd').click(function () {
		MusicPlayer.currentPlayer.currentTime=(MusicPlayer.currentPlayer.duration)-2; 
	})
	
	
});
</script>

</body>
</html>