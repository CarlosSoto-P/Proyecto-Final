<?php
// Definimos variables con los datos necesarios para la conexión
$servidor = "db4free.net"; // Puede ser una ubicación remota
$baseDatos = "redsocial";

//$usuarioBd = "root";
//<<<<<<< Updated upstream
$usuarioBd = "teamisw";
$passwordBd = "207f1530c8";
//=======
//$usuarioBd = "root";
//$passwordBd = "iswBD2101";
//>>>>>>> Stashed changes
//$passwordBd = "";
//$passwordBd = "";
//$passwordBd = "";

// Creamos la conexión
$connLocalhost = mysqli_connect($servidor, $usuarioBd, $passwordBd) or trigger_error(mysqli_error(), E_USER_ERROR);

// Definimos el cotejamiento para la conexion (igual al cotejamiento de la BD)
mysqli_query($connLocalhost, "SET NAMES 'utf8'");

// Seleccionamos la base de datos por defecto para el proyecto
mysqli_select_db($connLocalhost, $baseDatos);

?>