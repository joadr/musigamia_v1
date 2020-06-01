<?php
set_time_limit(0);
include('classes.php');

$cancion = new cancion();
$cancion->titulo = $_REQUEST['titulo'];
$cancion->artista = $_REQUEST['artista'];
$cancion->id = $_REQUEST['id'];

$id = new url();
$id->id = $_GET['id'];
$id->link = "http://www.goear.com/action/sound/get/".$cancion->id;


$headers = get_headers($id->link, 1);
$headers2 = get_headers($headers['location']);
//var_dump($headers2);
foreach($headers2 as $cabecera){
	header($cabecera);
}
header('Content-Disposition: attachment; filename="'.$cancion->titulo." - ".$cancion->artista.".mp3");
readfile($headers['location']);
/*
header('Content-Length: ' . $headers2['Content-Length'][1]);
header('Accept-Ranges: bytes');
header('Connection: close');
header("Content-Type: application/force-download");
header('Content-Description: File Transfer');
//$nombre = basename($headers['location']);
header('Content-Disposition: attachment; filename="'.$cancion->titulo." - ".$cancion->artista.".mp3");
readfile($headers['location']);*/

?>