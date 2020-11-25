<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - Login</title>

<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />

<link href="css_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
<!--
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
//-->
</script>
</head>

<body>
<div id="main">


<!-- HEADER END -->



<div id="content" class="txt_content">
 

  <?php
    if(isset($error)) printMsg($error, "error");
    if(isset($_GET["auth"])) printMsg("We're sorry... You need to login first!", "announce");
    if(isset($_GET["loggedOff"])) printMsg("Bye bye :)", "exito");
  ?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/estiloz.css">
  </head>
  <body>

<form  method="post" action = "">

<div class="login-box">
  <h1>Login</h1>
  <div class="textbox">
    <i class="fas fa-user"></i>
    <input type="text" placeholder="Correo" name = "correo">
  </div>

  <div class="textbox">
    <i class="fas fa-lock"></i>
    <input type="password" placeholder="Password" name = "contraseña">
    
  </div >
  <p> <a href="Registrar.php">No tienes cuenta</a></p>


  <button class="pulse" name ="login" onclick="location.href='NooCUPADO/asesores.html'">Iniciar Sesion </button>
 
  </form>
  <?php


  // Incluimos la conexión a la base de datos
  include("connections/conn_localhost.php");
  

  // Evaluamos si el formulario ha sido enviado
  if(isset($_POST['login'])) {

    // Armamos el query para verificar el email y el password en la base de datos
    $queryLogin = sprintf("SELECT  correo, contraseña FROM escuela.usuarios WHERE correo = '%s' AND contraseña =%s;",
        mysqli_real_escape_string($connLocalhost, trim($_POST['correo'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['contraseña']))
    );

    // Ejecutamos el query
    $resQueryLogin = mysqli_query($connLocalhost, $queryLogin) or trigger_error("El query de login de usuario falló");

    // Determinamos si el login es valido (email y password sean coincidentes)
    // Contamos el recordset (el resultado esperado para un login valido es 1)
    if(mysqli_num_rows($resQueryLogin)) {
      // Hacemos un fetch del recordset
      $userData = mysqli_fetch_assoc($resQueryLogin);

    

      // Redireccionamos al usuario al panel de control
      header('Location: index.php');

    }
    else {
      $error = "Login failed";
    }

  }
?>
</div>
  </body>
</html>