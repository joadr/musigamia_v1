<?php
// Obtener contenido de un URL con CURL
function get_url_contents($link){
    $crl = curl_init();
    $timeout = 25;
    curl_setopt ($crl, CURLOPT_URL, $link);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($crl, CURLOPT_HTTPHEADER, array('User-Agent: Goear 1.3 (iPod touch; iPhone OS 5.1.1;)'));
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}

class cancion {
    public $titulo;
    public $artista;
    public $id;

    function guardar(){
        $verificar = sprintf('SELECT id FROM canciones WHERE id = %s', mysql_real_escape_string($this->id));
        $verificacion = mysql_query($verificar) or die(mysql_error());
        $existencia = mysql_num_rows($verificacion);
        if($existencia == 0){
            $guardar = sprintf('INSERT INTO canciones (id, titulo, artista) VALUES (NULL, %s, %s)',
                                    mysql_real_escape_string($this->titulo),
                                    mysql_real_escape_string($this->artista));
            $guardando = mysql_query($guardar) or die(mysql_error());
        }
    }
}

class url {
    public $id;
    public $link;
    public $web;
    public $mp3;
    public $datos;

    // Creamos una función para obtener el link del mp3
    public function get_mp3() {
        $xml = simplexml_load_string($this->web);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        $mp3 = $array["song"]["@attributes"]['path'];
        $this->mp3 = $mp3;
    }

    public function obtener_datos() {
        $xml = simplexml_load_string($this->web);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        $artista = $array["song"]["@attributes"]['artist'];
        $titulo = $array["song"]["@attributes"]['title'];
        $datos = $titulo . " - " . $artista;
        $this->datos = $datos;
    }
}

class user {
    public $username;
    public $password;
    public $id;
    public $email;

    function CreateLoginForm(){
        echo '
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="usuario">
                <input type="text" name="password" placeholder="contraseña">
                <input type="submit"/>
            </form>
        ';
    }

    function login() {
        if(!isset($_SESSION['Username'])){
            $select = sprintf('SELECT name, password
                                FROM users WHERE name like %s AND password = %s',
                                    mysql_real_escape_string($this->username),
                                    mysql_real_escape_string($this->password));
            $query = mysql_query($select) or die(mysql_error());
            $existe = mysql_num_rows($query);
            if ($existe == 1){
                $usuario = mysql_fetch_assoc($query);
                $_SESSION['Username'] = $usuario['name'];
                $_SESSION['UserId'] = $usuario['uid'];
            } else {
                echo 'Usuario y/o contraseña inválidos';
            }
        } else {
            echo 'Ya ha iniciado sesión';
        }
    }

    function logout() {
        if(isset($_SESSION['Username']) && isset($_SESSION['UserId'])){
            unset($_SESSION['Username']);
            unset($_SESSION['UserId']);
            echo 'Ha cerrado sesión exitosamente';
        } else {
            echo 'Ya ha cerrado sesión con anterioridad.';
        }
    }

    function register(){
        // tampoco
    }

}

class search {
    public $link;
    public $link2;
    public $page;
    public $search;
    public $web = array();
    public $canciones;

    function obtenerCanciones(){
        $songs = json_decode($this->web[0], true);
        $songs2 = json_decode($this->web[1], true);
        $fullsongs = array_merge($songs, $songs2);
        $this->canciones = $fullsongs;
    }

    function mostrarLista(){
        echo '<ul data-role="listview">';
        foreach($this->canciones as $cancion){
            echo '<li class="lishow" data-icon="plus" id="'.$cancion["id"].'" titulo="'.$cancion["title"].'" grupo="'.$cancion["artist"].'" >
                    <a href="javascript:;" data-rel="dialog"><span class="cancion">'.$cancion["title"].' - '.$cancion["artist"].'</a>
                  </li>';
        }
        echo '</ul>';
    }

}
?>