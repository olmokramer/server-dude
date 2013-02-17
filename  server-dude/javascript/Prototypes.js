Prototypes = {

	init: function() {
		function playlist(playlistID) {
			this.playlistID = playlistID;
		};
		playlist.prototype = new Array();
		playlist.prototype.addSong = function(song) {
			this.push(song);
		};
		playlist.prototype.removeSong = function(song) {
			index=this.indexOf(song)
			this.remove(index)
		};
		playlist.prototype.moveSong = function(from,to) {
			this.move(from,to);
		};
		//sort playlist by properties in array sortValues (first is most important)
		//does not yet work with numbers, ie 10 comes before 2
		playlist.prototype.sortBy = function(sortValues) {
			while (sortValues.length>0) {
				sortValue = sortValues.pop;
				this.sort(function(a,b) {
					if (a[sortValue]<b[sortValue]) {
						return -1;
					}
					else if (a[sortValue]>b[sortValue]) {
						return 1;
					}
					else {
						return 0;
					}
				});
				if  (sortValue.charAt(0) == '-') {
					this.reverse;
				}
				
			};
		};
		
		
		
		
		var activePlaylist = new playlist();
		
		
		
		function song(songID,source) {
			this.songID = songID;
			this.source = source;
		};
		
		var song1 = new song(1,'bla.mp3');
		
		activePlaylist.addSong(song1);
	},
		
};