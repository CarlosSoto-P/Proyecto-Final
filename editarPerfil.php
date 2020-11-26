<?php
  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
    

  if(!isset($_SESSION['id'])) header('Location: login.php');
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
        include("includes/barraLateral.php")
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
                        <form id="registerform" class="form-horizontal" role="form">

                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="nombre" type="text" class="form-control" name="username" value=""
                                    placeholder="Nombre completo.">
                            </div>

                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="apellidos" type="text" class="form-control" name="username" value=""
                                    placeholder="Apellidos.">
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="telefono" type="text" class="form-control" name="username" value=""
                                    placeholder="Telefono.">
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="correo" type="text" class="form-control" name="username" value=""
                                    placeholder="Correo.">
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="contraseña" type="password" class="form-control" name="username" value=""
                                    placeholder="contraseña">
                            </div>

                            <div style="margin-bottom: 15px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="contraseñaR" type="password" class="form-control" name="username" value=""
                                    placeholder="Repita su contraseña">
                            </div>
                            <div class="col-md-4">
                                <label for="inputState">Rol</label>
                                <select id="inputState" class="form-control">
                                    <option selected>Alumno</option>
                                    <option>Asesor</option>
                                </select>
                            </div>


                            <div style="margin-top:20px" class="form-group float-right">
                                <!-- Button -->
                                <div class="col-sm-12 controls">
                                    <a id="btn-editar" href="#" class="btn btn-info">Guardar </a>
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