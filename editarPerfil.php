<?php

include("connections/conn_localhost.php");

  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
    

  if(!isset($_SESSION['id'])) header('Location: login.php');

  $query_userData = sprintf("SELECT * FROM usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);

$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$userData= mysqli_fetch_assoc($resQueryUserData);

if(isset($_POST['update_sent'])) {
    // Vamos a validar que no existan cajas vacias
    foreach($_POST as $calzon => $caca) {
      if($caca == '' && $calzon != "telefono") $error[] = "La caja $calzon es requerida";
    }

    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if(!isset($error)) {
      // Preparamos la consulta para guardar el registro en la BD
      $queryUpdateUser = sprintf("UPDATE usuario SET nombres = '%s', apellidos = '%s', contraseña= '%s', telefono = '%s', rol = '%s' WHERE id = %d",
        mysqli_real_escape_string($connLocalhost, trim($_POST['nombres'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['apellidos'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['contraseña'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['telefono'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['rol'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['userId']))
      );

      // Ejecutamos el query
      $resQueryUserUpdate = mysqli_query($connLocalhost, $queryUpdateUser) or trigger_error("El query de actualización de usuario falló");

      // Evaluamos el resultado de la ejecución del query
      if($resQueryUserUpdate) {
        header("Location: userUpdateAdmin.php?userId=".$_POST['userId']."&updatedProfile=true");
      }
    }

  }
  else {
    
  }


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>


    <! -- cabecera -->
        <?php include("includes/header.php"); 
        include("includes/common_functions.php");
        include("includes/barraLateral.php");
        ?>


        <!------ Include the above in your HEAD tag ---------->
        
        <div class="container">
            <div id="loginbox" style="margin-top:50px;"
                class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h2>Edita Tu Perfil</h2>
                        </div>
                        <hr>
                    </div>
                    <div style="padding-top:30px" class="panel-body">

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="editarUsuario" method='post' class="form-horizontal" role="form">

                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="nombre" type="text" class="form-control" name="nombres" value=""
                                    placeholder="Nombre completo.">
                            </div>

                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="apellidos" type="text" class="form-control" name="apellidos" value=""
                                    placeholder="Apellidos.">
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="telefono" type="text" class="form-control" name="telefono" value=""
                                    placeholder="Telefono.">
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="correo" type="text" class="form-control" name="correo" value=""
                                    placeholder="Correo.">
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="contraseña" type="password" class="form-control" name="contraseña" value=""
                                    placeholder="contraseña">
                            </div>

                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="contraseñaR" type="password" class="form-control" name="contraseña2" value=""
                                    placeholder="Repita su contraseña">
                            </div>
                            <div class="col-md-4">
                                <label for="inputState">Rol</label>
                                <select id="rol" name="rol" class="form-control">
                                    <option value="Asesor"
                                        <?php echo ($userData['rol'] == "Asesor") ? "selected" : ""; ?>>Asesor</option>

                                    <option value="Alumno"
                                        <?php echo ($userData['rol'] == "Alumno") ? "selected" : ""; ?>>Alumno</option>



                                </select>
                            </div>


                            <div style="margin-top:20px" class="form-group float-right">
                                <!-- Button -->
                                <div class="col-sm-12 controls">

                                    <button id="btn-editar" name="update_sent" class="btn btn-info">
                                        Guardar
                                    </button>
                                </div>

                            </div>

                          

                        </form>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous">
            </script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
                integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
                crossorigin="anonymous">
            </script>
</body>

</html>