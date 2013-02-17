<!DOCTYPE html>
<html>
<head>
	<title>Music Server</title>
	<meta http-equiv="content-style-type" content="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<LINK HREF="screen.css" REL="stylesheet" TYPE="text/css" media="screen, tv, projection">
	<style type="text/css">
	* {
		color:white;
	}



	ul,li {
		padding:0;
		margin:0;
	}
	ul {
		list-style:none;
	}
	body {
	min-width:1024px;	
	white-space:nowrap;
	}
	
	/* TOP */
	
	#top {
		width:100%;
		height:250px;
	}
	
	#menu_container {
		min-width:200px;
		position:absolute;
		top:0;
		left:0;
	}
	
	#top_right {
		position:absolute;
		right:0;
		top:0;
		min-width:700px;
		width:50%;
	}
	
	#logo_container {
		min-width:300px;
		position:absolute;
		left:0;
		top:0;
		}
	
	img#logo {
		border:0;
		width:300px;
		height:165px;
		position:relative;
		left:-150px;
		
	}
		
	#player_container {
		position:absolute;
		right:0;
		top:0;
		width:500px;
		}
	
	img#player {
		border:0;
		width:500px;
		height:250px;
		float:right;
	}
	

	
	/* MAIN */
	
	#main {
		clear: both;
	}
	
	#sidebar_left {
		margin-left:15px;
		float:left;
		width:25%;
		min-width:200px;
		overflow:auto;
	}
	#main_container {
		width:50%;
		min-width:400px;
		overflow:auto;
	}
	#sidebar_right{
		margin-right:15px;
		float:right;
		width:25%;
		min-width:200px;
		overflow:auto;
	}
	
		
		/* Left sidebar CSS styling:  	*/

	
	.playlist_song_info li {
		display:inline;
	}
		/* Main container */
	
	
		/* Right sidebar CSS styling:  	*/

	
	.active_playlist_song_info li {
		display:inline;
	}
	
	
	
	#active_playlists_buttons_container li {
		display:inline;
	}
	#active_playlists_buttons_container {
		position:absolute;
		bottom:15px;
	}
	
	
	
	</style>
</head>

<body>
	<!--Bar at top containing menu, logo and music player-->
	<div id="top">
		<div id="menu_container">
			<span id="user_menu">
			username
			<br />
			settings
			</span><br />
			<span id="upload_menu">
			button
			<br />
			upload
			</span>
		</div>	
		<div id="top_right">
			<div id="logo_container"><img src="./server dude.png" alt="logo" id="logo" />
			</div>
			<div id="player_container">
				<img src="./now playing/preview.png" alt="music player" id="player" />
			</div>
		</div>
	</div>

<!--Main content area containing saved playlist, main container and active playlist.-->
	<div id="main">
		<!--Left sidebar containing global and user specific playlists -->
		<div id="sidebar_left">
			<div id="playlist_types" class="">
				<span class="playlist_type_name">Smart Playlists</span>
				<!--Contains several playlist visible for all user at any time.-->
				<ul id="global_smart_playlists" class="">
					<li data-playlist-id="1" class="playlist">
						<span class="playlist_name">playlist1</span>
						<ul class="playlist_songs">
							<li id="playlist_song_1" class="playlist_song">
								<ul class="playlist_song_info">
									<li class="playlist_song_name">song1</li>
									<li class="playlist_song_artist">artist1</li>
									<li class="playlist_song_year">year1</li>
									<li class="playlist_song_album">album1</li>
									<li class="playlist_song_duration">20:23</li>
								</ul>
							</li>
							<li id="playlist_song_2" class="playlist_song">
								<ul class="playlist_song_info">
									<li class="playlist_song_name">song2</li>
									<li class="playlist_song_artist">artist2</li>
									<li class="playlist_song_year">year2</li>
									<li class="playlist_song_album">album2</li>
									<li class="playlist_song_duration">6:23</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
				<!--Contains the User's playlists.-->
				<ul id="saved_user_playlists" class="">
				<span class="playlist_type_name">Saved Playlists</span>
					<li data-playlist-id="2" class="playlist">
						<span class="playlist_name">playlist2</span>
						<ul class="playlist_songs">
							<li id="playlist_song_3" class="playlist_song">
								<ul class="playlist_song_info">
									<li class="playlist_song_name">song3</li>
									<li class="playlist_song_artist">artist3</li>
									<li class="playlist_song_year">year3</li>
									<li class="playlist_song_album">album3</li>
									<li class="playlist_song_duration">23:23</li>
								</ul>
							</li>
							<li id="playlist_song_4" class="playlist_song">
								<ul class="playlist_song_info">
									<li class="playlist_song_name">song2</li>
									<li class="playlist_song_artist">artist2</li>
									<li class="playlist_song_year">year2</li>
									<li class="playlist_song_album">album2</li>
									<li class="playlist_song_duration">6:23</li>
								</ul>
							</li>
						</ul>
					</li>
			</div>
			Text LEFTLEFTLEFT!!!!!!!!!!!			Text LEFTLEFTLEFT!!!!!!!!!!!			Text LEFTLEFTLEFT!!!!!!!!!!!
		</div>
		<!--Main container, which can contain different pages depending on clicked links.-->
		<div id="main_container">
			TEXT MIDDLE MIDDLE MIDDL!!!!!!!			TEXT MIDDLE MIDDLE MIDDL!!!!!!!
		</div>
		<!--Right sidebar containing the active playlists and several buttons.-->
		<div id="sidebar_right">
			<div id="active_playlists_container">
				<ul id="active_playlists" class="">
					<li data-active_playlist-id="1" class="active_playlist">
						<span class="active_playlist_name">active_playlist1</span>
						<ul class="active_playlist_songs">
							<li id="active_playlist_song_1" class="active_playlist_song">
								<ul class="active_playlist_song_info">
									<li class="active_playlist_song_name">song1</li>
									<li class="active_playlist_song_artist">artist1</li>
									<li class="active_playlist_song_year">year1</li>
									<li class="active_playlist_song_album">album1</li>
									<li class="active_playlist_song_duration">20:23</li>
								</ul>
							</li>
							<li id="active_playlist_song_2" class="active_playlist_song">
								<ul class="active_playlist_song_info">
									<li class="active_playlist_song_name">song2</li>
									<li class="active_playlist_song_artist">artist2</li>
									<li class="active_playlist_song_year">year2</li>
									<li class="active_playlist_song_album">album2</li>
									<li class="active_playlist_song_duration">6:23</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="active_playlists_buttons_container">
				<ul id="active_playlist_buttons" class="">
					<li id="active_playlist_edit_button" class="active_playlist_button">edit</li>
					<li id="active_playlist_save_button" class="active_playlist_button">save</li>
					<li id="active_playlist_shuffle_button" class="active_playlist_button">shuffle</li>
				</ul>
			</div>
			
			
		</div>
	</div>



</body>


</html>