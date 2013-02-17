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
		$('#repeat0').click(function () {
			MusicPlayer.setRepeat(0);
		})
		$('#repeat1').click(function () {
			MusicPlayer.setRepeat(1);
		})
		$('#repeat2').click(function () {
			MusicPlayer.setRepeat(2);
		})		
	},

	updateNowPlayingInfo: function () {
			$('#nowPlayingFileName').html(MusicPlayer.currentPlayer.currentSrc);
			$('#songNumber').html(MusicPlayer.currentSongNumber);
	}
	
};