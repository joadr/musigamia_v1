<?php
include('classes.php');
// El criterio de busqueda es la variable por URL

$busqueda = new search();
$busqueda->search = $_REQUEST['buscar'];

// Reemplazamos los espacios con signos "+" para que sea compatible con la otra web
$busqueda->search = str_replace(" ", "-", $busqueda->search);

// Si no se especifica un numero de página, se define el número 1 (primera página)
if(!isset($_REQUEST['page'])){
    $busqueda->page = "0";
} else {
    $busqueda->page = $_REQUEST['page'];
}

// Conseguimos el contenido de la página haciendo la busqueda con la variable obtenida por URL
$busqueda->link = "http://www.goear.com/apps/iphone/search_songs_json.php?q=".$busqueda->search."&p=".$busqueda->page;
$busqueda->web[] = get_url_contents($busqueda->link);
//$busqueda->get_url_contents();

// Para la página 2
$busqueda->link = "http://www.goear.com/apps/iphone/search_songs_json.php?q=".$busqueda->search."&p=".++$busqueda->page;
$busqueda->web[] = get_url_contents($busqueda->link);
//$busqueda->get_url_contents();

$busqueda->obtenerCanciones();
?>
<div data-role="page" id="Search">
	<div data-role="header">
    	<a href="#home" data-icon="back">Back</a>
		<h1>Search for Musik</h1>
        <a data-role="button" data-icon="arrow-r" href="#Player">Player</a>
	</div><!-- /header -->
	<div data-role="content">
		<script>
		//$("#Search").bind('pageinit', function() {
                        function contar(){
                            var i = 0;
                            var lista = myPlaylist.playlist; // Se define el reproductor
                            $.each(lista, function(index, object) {
                                i=i+1;
                            });
                            return i;
                        }
			$('li[data-icon*="plus"]').click(function() {
				window.myPlaylist.add({
					title: $(this).attr("titulo"),
					artist: $(this).attr("grupo"),
					mp3:"demons.php?id="+$(this).attr("id")
				});
				$('#Added').popup("open", { history: false, positionTo: 'window'}).delay(800).queue(function(next) { $(this).popup("close"); next() });
                                if(contar() == 1){
                                    $("#jquery_jplayer_2").jPlayer("play"); 
                                }
			});
		//});
        </script>
        <div data-role="popup" id="Added" data-overlay-theme="a" data-theme="a" class="ui-content" data-position-to="origin">
            <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Cerrar</a>
            <p>Song added to actual playlist.</p>
        </div>
<?php
    $busqueda->mostrarLista();
?>
        <div style="margin: 10px auto 0 auto;">
            <a href="search.php?buscar=<?php echo $busqueda->search; ?>&page=<?php if($busqueda->page == 1){ echo "0"; } else { echo $busqueda->page-3; } ?>" id="prev" data-role="button" data-icon="arrow-l" data-inline="true">Anterior</a>
            
            <a href="search.php?buscar=<?php echo $busqueda->search; ?>&page=<?php echo ++$busqueda->page; ?>" id="next" data-role="button" data-icon="arrow-r" data-iconpos="right" data-inline="true">Siguiente</a>
        </div>
        <div id="hidden4load"></div>
    </div><!-- /content -->

	<div data-role="footer">
		<h4>MusikAddict</h4>
	</div><!-- /footer -->
</div><!-- /page -->