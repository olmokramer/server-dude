//input: MusicPlayer.activePlaylistInput([array with song sources],position of song to start with)
MusicPlayer = {
	//settings
	noPreviousPlayers: 1,
	noNextPlayers: 2,
		
	//variables
	noPlayers:null,							//number of players				
	playerIDs: [],
	currentPlayer: null,				
	activePlaylist: [],
	songsLoaded: [],					//the song on songsLoaded[i] is loaded in the player with playerIDs[i]
	currentSongNumber: null,				//position of current song in activePlaylist[]
	stopped:1,
	paused:1,
	loopPlaylist: false,
	volume: null,
	
	init: function() {
		this.noPlayers=this.noPreviousPlayers+this.noNextPlayers+1;
		//create audio elements, give them IDs and put those in playerIDs[]
		for (i=0;i<this.noPlayers;i++) {
			$('div#musicPlayer').append('<audio>Your browser does not support the audio element.</audio>\n');
			this.playerIDs.push('player'+i);
			$('#musicPlayer audio:last').attr('id',this.playerIDs[i]);
			this.songsLoaded.push('player'+i);
		}
	},

	activePlaylistInput: function(activePlaylist,currentPosition) {
		this.activePlaylist=activePlaylist;
		this.currentSongNumber=currentPosition;
		this.reloadSongs();
		if (this.stopped==1) {
			this.changePlayer();
		}
	},
	
	//loads songs from activePlaylist into players
	reloadSongs: function () {
		songsToLoad=[];
		playersToUnload=[];
		
		//fill songsToLoad from activePlaylist
		if (this.activePlaylist.length<this.noPlayers) {
			for (i=0;i<this.activePlaylist.length;i++) {
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
		for (i=0;i<this.songsLoaded.length;i++) {
			if (songsToLoad.indexOf(this.songsLoaded[i])==-1) {
				playersToUnload.push(this.songsLoaded[i]);
			}
			else {
				songsToLoad.splice(songsToLoad.indexOf(this.songsLoaded[i]),1);
			}
		}
		//load songs from songsToLoad to players from playersToUnload
		//the sources of songs in playersToUnload are replaced by the ids of the players with those songs
		for (i=0;i<playersToUnload.length;i++) {
			playersToUnload[i]=this.playerIDs[this.songsLoaded.indexOf(playersToUnload[i])]
			$('#'+playersToUnload[i]).attr('src',songsToLoad.pop());
			//alert(playersToUnload[i]+' i='+i);
			$('#'+playersToUnload[i]).get(0).load();
		}
		//update the sources, ids and this.playerIDs
		$('#musicPlayer audio').each(function(i,element){
			if (typeof ($(this).attr('src'))!='undefined') {
				newID=$(this).attr('src');
				//remove all '.', '/' and '\' from newID
				while (newID.indexOf('.')!=-1 || newID.indexOf('/')!=-1 || newID.indexOf('\\')!=-1) {
					newID=newID.replace('.','').replace('/','').replace('\\','');
				}
				$(this).attr('id',newID);
				MusicPlayer.playerIDs[i]=$(this).attr('id');
				MusicPlayer.songsLoaded[i]=$(this).attr('src');
			}
		});
	},
	
	//changes currentPlayer to the one that has this.activePlaylist[this.currentSongNumber] loaded
	changePlayer: function () {
		this.currentPlayer=$('#'+this.playerIDs[this.songsLoaded.indexOf(this.activePlaylist[this.currentSongNumber])]).get(0);
		this.currentPlayer.oncanplay=function() {
			MusicIO.updateNowPlayingInfo();
		};
		this.currentPlayer.onended=function() {
			MusicPlayer.songFinished();
		};
		$('#musicPlayer').trigger('songChange');
		/*if () {
			$('#musicPlayer').trigger('playlistEnded');
		}
		if () {
			$('#musicPlayer').trigger('endOfPlaylistLoaded');
		}*/
	},
	
	songFinished: function () {
		this.nextSong();
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
		if (this.currentSongNumber+1>=this.activePlaylist.length && this.loopPlaylist==false){
			this.stop();
		}
		else {
			this.currentSongNumber=(this.currentSongNumber+1)%this.activePlaylist.length;
			this.reloadSongs();
			this.changePlayer();
			if (this.stopped==0){
				this.play();
			}
		}
	},
	
	previousSong: function () {
		this.pause();
		this.setTime(0);
		if (this.currentSongNumber<1 && this.loopPlaylist==false) {
			this.stop();
		}
		else {
			this.currentSongNumber=(this.currentSongNumber-1+this.activePlaylist.length)%this.activePlaylist.length;
			this.reloadSongs();
			this.changePlayer();
			if (this.stopped==0){
				this.play();
			}
		}
	},
	
	//in seconds
	//relative is relative to current song length
	setTime: function (time,relative) {
		if (relative==true) {
			this.currentPlayer.currentTime=time*this.currentPlayer.duration;
		}
		else{
			this.currentPlayer.currentTime=time;
		}
	},
	
	//(0-1)
	setVolume: function(volume) {
		this.volume = volume;
		$('#musicPlayer audio').each(function(i,element){
			$(this).get(0).volume=volume;
		});
	},	
	//(
	mute: function() {
		$('#musicPlayer audio').each(function(i,element){
			if ($(this).get(0).volume==0) {
				$(this).get(0).volume=this.volume;
			} else {
				$(this).get(0).volume=0;
			}
		});
	},
	
	//set repeat: 0=no repeat, 1=repeat song, 2=repeat playlist
	setRepeat: function(repeat) {
		if (repeat==2) {
			this.loopPlaylist=true;
		}
		else {
			this.loopPlaylist=false;
		}
		if (repeat==1) {
			$('#musicPlayer audio').each(function(i,element){
				$(this).get(0).loop=true;
			});
		}
		else {
			$('#musicPlayer audio').each(function(i,element){
				$(this).get(0).loop=false;
			});
		}
	},
};