<?php
  include("connections/conn_localhost.php");


  // Lo primero que haremos será validar si el formulario ha sido enviado
  if(isset($_POST['registrar'])) {

    // Validación de passwords coincidentes
    if($_POST['contraseña'] != $_POST['ConfirmarContraseña']){
      $error[] = "Los passwords no son coincidentes";
    }

    // Validación de email
    // Preparamos la consulta para determinar si el email porporcionado ya existe en la BD
    $queryCheckEmail = sprintf("SELECT id FROM usuarios WHERE correo = '%s'",
      mysqli_real_escape_string($connLocalhost, trim($_POST['correo']))
    );

    // Ejecutamos el query 
    $resQueryCheckEmail = mysqli_query($connLocalhost, $queryCheckEmail) or trigger_error("El query de validación de email falló"); // Record set o result set siempre y cuando el query sea de tipo SELECT

    // Contar el recordset para determinar si se encontró el correo en la BD
    if(mysqli_num_rows($resQueryCheckEmail)) {
      $error[] = "El correo proporcionado ya está siendo utilizado";
    }

    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if(!isset($error)) {
      // Preparamos la consulta para guardar el registro en la BD
      $queryInsertUser = sprintf("INSERT INTO escuela.usuarios (contraseña, nombre, correo, tipoUsuario) VALUES ('%s', '%s', '%s', '%s')",
          mysqli_real_escape_string($connLocalhost, trim($_POST['contraseña'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['nombre'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['correo'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['tipoUsuario']))

      );

      // Ejecutamos el query en la BD
      mysqli_query($connLocalhost, $queryInsertUser) or trigger_error("El query de inserción de usuarios falló");

      // Redireccionamos al usuario al Panel de Control
      header("Location: NooCUPADO/asesores.php?insertUser=true");
    }

  }
  else {
    
  }

?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="prueba.css">
  </head>
  <body>

<form  method="post" action = "">

<div class="login-box">
  <h1>Registrar</h1>
  <div class="textbox">
    <i class="fas fa-user"></i>
    <input type="text" placeholder="Nombre" name = "nombre">
  </div>
  <div class="textbox">
    <i class="fas fa-user"></i>
    <input type="text" placeholder="Correo" name = "correo">
  </div>
 
  <div class="textbox">
    <select name="tipoUsuario" id="tipoUsuario">
            
                <option value="Asesor">Asesor</option>
                <option value="Estudiante">Estudiante</option>

            </select>

            </div>


  <div class="textbox">
    <i class="fas fa-lock"></i>
    <input type="password" placeholder="Contraseña" name = "contraseña">
    
  </div >
  <div class="textbox">
    <i class="fas fa-lock"></i>
    <input type="password" placeholder="Confirmar Contraseña" name = "ConfirmarContraseña">
    
  </div >
 


  <button class="pulse" name ="registrar" onclick="location.href='NooCUPADO/asesores.html'">Registrarse </button>
 
  </form>
 
</div>
  </body>
</html>