
<?php

include("connections/conn_localhost.php");

// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['id'])) header('Location: login.php');


// obtenemos la informacion del usuario 
$query_userData = sprintf("SELECT * FROM usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);
$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");
$userData= mysqli_fetch_assoc($resQueryUserData);

// Recuperamos los datos del grupo
$query_grupo = "SELECT * FROM grupo WHERE idGrupo = {$_GET['idGrupo']}";
$resQuery_Grupo = mysqli_query($connLocalhost, $query_grupo) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$grupoData= mysqli_fetch_assoc($resQuery_Grupo);

//query para el numero de integrantes 
$query_numeroDeIntegrantes = "SELECT count(*) as total from miembros
where idGrupo={$_GET['idGrupo']};";
$resQuery_NumeroMiembros = mysqli_query($connLocalhost, $query_numeroDeIntegrantes) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$numero = mysqli_fetch_assoc($resQuery_NumeroMiembros);

//obtenemos la informacion del asesor 
$query_Asesor = "SELECT 
usuario.nombres as 'nombreAsesor',
usuario.idUsuario as 'idAsesor',
usuario.rol as 'rol',
usuario.apellidos as 'apellidos',
usuario.descripcion as 'descripcion',
usuario.telefono as 'telefono',
usuario.correo as 'correo'
from grupo
left join usuario as usuario on usuario.idUsuario = grupo.idAsesor
where grupo.idGrupo = {$_GET['idGrupo']}";
$resQuery_Asesor = mysqli_query($connLocalhost, $query_Asesor) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$asesorData = mysqli_fetch_assoc($resQuery_Asesor);


//obtenemos los mienbros del grupo
$query_miembros = "SELECT 
usuario.nombres as 'nombreMiembro',
usuario.idUsuario as 'idMiembro'
from miembros
left join usuario as usuario on usuario.idUsuario = miembros.idUsuario
where miembros.idGrupo = {$_GET['idGrupo']}";
$resQuery_Miembros = mysqli_query($connLocalhost, $query_miembros) or trigger_error("El query para obtener los detalles del grupo loggeado falló");

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



 
    <?php include("includes/header.php"); ?>
    <div class="container">
            <div class="main-body">

                
                <!--nombre y descripcion-->
                <div class="row gutters-sm">
                    <div class="col-md-3 mb-3">
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <h5>
                                        Asesor
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>
                                            <?php 
                                                echo($asesorData['nombreAsesor']." ".$asesorData['apellidos'])
                                            ?>
                                        </h4>
                                        <p class="text-secondary mb-1">
                                            <?php 
                                                echo($asesorData['descripcion'])
                                            ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Informacion-->                          
                    <div class="col-md-6">
                        <hr>
                        <div class="card mb-3">
                            
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nombre Del Grupo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($grupoData['nombre'])
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Descripcion</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($grupoData['descripcion'])
                                        ?>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Numero de integrantes</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($numero['total']);
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Asesor</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($asesorData['nombreAsesor']." ".$asesorData['apellidos'])
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Telefono de contacto</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                             echo($asesorData['telefono'])
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Correo de contacto</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($asesorData['correo'])
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <!-- barra lateral -->
                <div class="col-md-3 float-right">
                    <hr>
                    <div class="card gedf-card">
                        
                        <div class="card-body">
                            <h3 class="card-title">
                                    Opciones de grupo
                            </h3>
                            <hr>
                            <li>
                            <a href="grupo.php?idGrupo=<?php echo $grupoData['idGrupo']; ?>"   class="card-link">Unirse al Grupo</a>
                            </li>
                            
                            <li>
                            <a href="index.php" class="card-link">Abandonar grupo</a>                            
                            </li>
                                                
                        </div>
                    </div>
                   
                </div>
                    
                </div>
       
           


    
    
</body>
</html>