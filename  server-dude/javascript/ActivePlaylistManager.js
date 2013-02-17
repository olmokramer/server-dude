ActivePlaylistManager = {
	

	/*activePlaylist: new Prototypes.playlist('activePlaylist'){
		
	},*/
	
	init: function() {
		MusicPlayer.activePlaylistInput([
			"../test0.ogg",	//previous
			"../test1.ogg",	//current
			"../test2.ogg",	//next
			"../test3.ogg",	//second next,0);
		],0);
		//a = new this.Song(Array(1,2));
		//alert(a.getData)
	},

	
};