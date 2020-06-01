<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Musigamia 2.0</title>
        <!-- Jquery & Jquery mobile -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
            <!-- JPlayer -->
            <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
            <script type="text/javascript" src="js/jplayer.playlist.min.js"></script>
            <link href="style/jplayer/jplayer.light.monday.css" rel="stylesheet" type="text/css" />
            <!-- End Jplayer -->
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
        <!-- End Jquery -->

    </head>
    <script type="text/javascript">
	$(document).ready(function() {
		// The Jplayer Playlist
		window.myPlaylist = new jPlayerPlaylist({
			jPlayer: "#jquery_jplayer_2",
			cssSelectorAncestor: "#jp_container_2"
		},
		{
			playlistOptions: {
				enableRemoveControls: true
			},
			swfPath: "/js",
            solution: 'flash, html',
			supplied: "mp3"
		});
		myPlaylist.option("enableRemoveControls", true); // Set option
		$('#jquery_jplayer_2').jPlayer("volume", 1);

		// Download button
		$("#jquery_jplayer_2").bind($.jPlayer.event.play, function(event) {
			var current = myPlaylist.current;
			var playlist = myPlaylist.playlist;
			$.each(playlist, function(index, object) {
				if(index == current) {
					//$("#cancion").html(object.title + " - " + object.artist + " -- " + object.mp3);
					CancionActual = object.mp3;
					CancionId = obtenerId(CancionActual);
					$("#downloadSong").attr("href", "mp3.php?id=" + CancionId + "&titulo=" + object.title + "&artista=" + object.artist);
				}
			});
		});

		// Función para obtener el id de la canción
		function obtenerId(url){
			var exploded = url.split('=');
			var id = exploded[1];
			return id;
		}
		// Función para guardar las playlists.
		function guardarPlaylist(){
			var lista = myPlaylist.playlist; // Se define el reproductor
			var titulos = new Array(); // Se crean los arrays donde vamos a meter toda la info
			var artistas = new Array();
			var links = new Array();
			$.each(lista, function(index, object) { // Metemos toda la info en los arrays
				titulos.push(object.title);
				artistas.push(object.artist);
				links.push(object.mp3);
			});
			titles = titulos.join(";"); // Separamos los arrays en un string, para meterlos en localStorage
			artists = artistas.join(";");
			urls = links.join(";");
			if(titles != ""){
				localStorage.title = titles; // Metemos las cosas en el localStorage
				localStorage.artist = artists;
				localStorage.mp3 = urls;
				alert('Playlist saved correctly');
			} else {
				alert('There are no songs saved in current playlist');
			}
		}

		// Función para cargar las playlists guardadas
		function cargarPlaylist(){
			// Verificamos si hay algo en el localStorage
			if (localStorage['title']) {
				var titulos = localStorage.title.split(";"); // Creamos un array, con las cosas en el localStorage
				var artistas = localStorage.artist.split(";");
				var links = localStorage.mp3.split(";");
				//alert(titulos.length);
				//alert(titulos.serialize());
				for(i=0;i<=titulos.length-1; i++){ // Creamos un bucle para cargar las canciones
					myPlaylist.add({
						title: titulos[i],
						artist: artistas[i],
						mp3: links[i]
					});
				}
			} else {
				alert('No songs in saved playlist'); // Mensaje en caso de que no haya nada en localStorage
			}
		}

		// Función para borrar las playlist guardadas
		function borrarPlaylist(){
			if(localStorage["title"]){
				delete localStorage.title;
				delete localStorage.artist;
				delete localStorage.mp3;
				alert("Playlist deleted correctly");
			} else {
				alert("There is no playlist saved");
			}
		}

		$("#botonGuardar").click(function() {
			guardarPlaylist();
		});
		$("#botonCargar").click(function() {
			cargarPlaylist();
		});
		$("#botonBorrar").click(function() {
			borrarPlaylist();
		});
		var showPlaylistOptions = 0;
		$("#showHide").click(function (){
			if(showPlaylistOptions == 0){
				//$("#showHideDiv").show('slow');
				$("#showHideDiv").slideDown('fast');
				showPlaylistOptions = 1;
			} else {
				//$("#showHideDiv").hide('slow');
				$("#showHideDiv").slideUp('fast');
				showPlaylistOptions = 0;
			}
		});
	});
    </script>
    <body>
        <div id="jquery_jplayer_2" class="jp-jplayer"></div>
        <div data-role="page" id="home" data-add-back-btn="true">
            <div data-role="header">
                <h1>Musigamia Home</h1>
                <a data-role="button" data-icon="arrow-r" href="#Player">Player</a>
            </div><!-- /header -->

            <div data-role="content">
                <form id="homeSearch" action="search.php" method="GET">
                    <label for="buscar">Input your search:</label>
                    <input type="search" name="buscar" id="buscar" value="" placeholder="Search for music" />
                    <input type="submit" value="Search" />
                </form>
                <div id="resultados">
                </div>
            </div><!-- /content -->

            <div data-role="footer" data-position="fixed">
                <h4>Musigamia</h4>
            </div><!-- /footer -->
        </div><!-- /page -->


        <div data-role="page" id="Player" data-add-back-btn="true">

            <div data-role="header">
                <h1>Search for Musik</h1>
            </div><!-- /header -->

            <div data-role="content">
                <!-- JPlayer Starts -->
                <div id="jp_container_2" class="jp-audio">
                    <div class="jp-type-playlist">
                        <div class="jp-gui jp-interface" style="overflow:hidden">
                            <ul class="jp-controls">
                                <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
                                <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                            </ul>
                            <div class="jp-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar"></div>
                                </div>
                            </div>
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                            <div class="jp-time-holder">
                                <div class="jp-current-time"></div>
                                <div class="jp-duration"></div>
                            </div>
                            <ul class="jp-toggles">
                                <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
                                <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
                                <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                            </ul>
                        </div>
                        <div class="jp-playlist">
                            <ul>
                                <li></li>
                            </ul>
                        </div>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>
                <!-- JPlayer ENDS -->
            <div id="cancion"></div><br>
            <a href="" data-role="button" id="downloadSong" data-icon="arrow-d" data-theme="e" data-iconpos="right" data-ajax="false" target="_blank">Download Song</a>
            <input type="button" id="showHide" value="Playlist options" data-icon="grid" data-theme="b"/>
            <div data-role="controlgroup" data-type="vertical" style="display:none" id="showHideDiv">
                <input type="button" id="botonGuardar" value="Save Playlist" data-icon="plus"/>
                <input type="button" id="botonCargar" value="Load saved Playlist" data-icon="refresh"/>
                <input type="button" id="botonBorrar" value="Delete saved Playlist" data-icon="delete"/>
            </div>
            </div><!-- /content -->

            <div data-role="footer" data-position="fixed">
                <h4>Musigamia</h4>
            </div><!-- /footer -->
        </div><!-- /page -->
    </body>
</html>
