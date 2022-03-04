<?php
	//echo '<h3>PDO</h2>';
require_once("config.php");
$conexion= new mysqli(HOST,USER,PASSWORD,DATABASE); 
		if($conexion->connect_errno){
			die ("Error al conectarse a MySQLi: (".$conexion->connect_errno .") " . $conexion->connect_error);
		}else{

		}
?>