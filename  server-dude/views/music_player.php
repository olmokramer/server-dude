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
	<script type="text/javascript" src="../javascript/MusicPlayer.js"></script>
	<script type="text/javascript" src="../javascript/MusicIO.js"></script>
	<script type="text/javascript" src="../javascript/ActivePlaylistManager.js"></script>
	<script type="text/javascript" src="../javascript/Methods.js"></script>
	<script type="text/javascript" src="../javascript/Prototypes.js"></script>
	<script type="text/javascript" src="../javascript/Test.js"></script>



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
	<br />
	<span id="repeat0">Repeat Off</span>
	<span id="repeat1">Repeat One</span>
	<span id="repeat2">Repeat All</span>


</div>
<div id="musicPlayer">
</div>

<script type="text/javascript">
$(document).ready(function (){	
	MusicPlayer.init();
	MusicIO.init();
	ActivePlaylistManager.init();
	Prototypes.init();
	Bla.init();
	$('#toEnd').click(function () {
		MusicPlayer.currentPlayer.currentTime=(MusicPlayer.currentPlayer.duration)-2; 
	})
});
</script>

</body>
</html>