<?php
$servidor="localhost";
$usuario="root";
$pass="Jesus8";
$db_name="Evaluacion_Docente2";

$conexion= @mysql_connect($servidor,$usuario,$pass);
mysql_select_db($db_name,$conexion);
?>
