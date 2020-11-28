<?php
include "connections/conn_localhost.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
       
    <link rel="stylesheet" href="css/stylemssg.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">

<link href="https://fonts.googleapis.com/css2?family=Mukta+Vaani:wght@200&display=swap" rel="stylesheet">
<script type="text/javascript">
    function ajax() {
    var req = new XMLHttpRequest();
    req.onreadystatechange =  function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById('chat').innerHTML = req.responseText;
        }
        
    }
    req.open('GET','chat.php');
    req.send();    
}
//refrescar la pagina cada segundo
setInterval(function(){ajax();},1000);
</script>


</head>
<body onLoad= "ajax();">
<div id= "container">
    <div id="box-chat">
        <div id="chat"> </div>
    </div>
    <form action="mensajes.php" method="post">
    

    <input type="text" name = "nombre" placeholder = "Ingresa tu nombre">
    <textarea name="mensaje"placeholder = "Ingresa tu mensaje"></textarea>
    <input type="submit" name ="send" value = "Enviar">
    </form>
    <?php
    
    if (isset($_POST['send'])) {
        $nombre = $_POST['nombre'];
        $mensaje = $_POST['mensaje'];

         $consulta = sprintf("INSERT INTO message (nombre, mensaje) VALUES ('%s','%s')",
         mysqli_real_escape_string($connLocalhost, trim($_POST['nombre'])),
         mysqli_real_escape_string($connLocalhost, trim($_POST['mensaje']))

        
     );
     $resQueryMessage = mysqli_query($connLocalhost, $consulta) or trigger_error("El query falló");
    }
    ?>
</div>
    
</body>
</html>