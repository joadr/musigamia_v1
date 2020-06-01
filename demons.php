<?php
/*set_time_limit(0);
include('classes.php');

$id = new url();
$id->id = $_GET['id'];
$link = "http://www.goear.com/action/sound/get/".$_GET['id'];
$id->link = $link;
//$id->set_link();
//$id->get_url_contents();
//$id->get_mp3();
$headers = get_headers($id->link, 1);

header('Location: ' .$headers['location']);
exit();*/
set_time_limit(0);
include('classes.php');

$cancion = new cancion();
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
readfile($headers['location']);
?>