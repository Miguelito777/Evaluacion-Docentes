<?php
$servidor="localhost";
$usuario="root";
$pass="";
$db_name="evaluacion_docente2";

$conexion= @mysql_connect($servidor,$usuario,$pass);
mysql_select_db($db_name,$conexion);
?>