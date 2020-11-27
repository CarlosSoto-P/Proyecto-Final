
<?php

include("connections/conn_localhost.php");

// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['id'])) header('Location: login.php');

$query_userData = sprintf("SELECT * FROM usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);

$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$userData= mysqli_fetch_assoc($resQueryUserData);

// Incluimos la conexión a la base de datos
include("connections/conn_localhost.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Informacion del grupo</title>
</head>
<body>

    <main>

        <section id="cabecera">
            <header>
                <?php include("includes/header.php"); ?>
            </header>
        </section>
           

        <section id = >
        
        </section>

    </main>
    
</body>
</html>