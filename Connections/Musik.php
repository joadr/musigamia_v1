<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Musik = "localhost";
$database_Musik = "musik";
$username_Musik = "root";
$password_Musik = "runescape";
$Musik = mysql_pconnect($hostname_Musik, $username_Musik, $password_Musik) or trigger_error(mysql_error(),E_USER_ERROR); 
?>