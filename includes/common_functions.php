<?php

include("connections/conn_localhost.php");

  function printMsg($msg,$msg_type){
    echo '<div class="'.$msg_type.'">';
    if(is_array($msg)){
      echo "<ul>";
      foreach($msg as $caca) {
        echo "<li>$caca</li>";
      }
      echo "</ul>";
    }
    else {
      echo $msg;
    }
    echo '</div>';
  }
function formatfecha($fecha){

   return date('g:i a',strtotime($fecha));
}

function megusta($idUsuario,$idPublicacion){
 $queryMegusta = "INSERT INTO megustas (idUsuario,idPublicacion) VALUES ($idUsuario,$idPublicacion)";
 $res_queryMegusta = mysqli_query($connLocalhost, $queryMegusta) or trigger_error("El query de dar me gusta");
}

function NOmegusta($idUsuario,$idPublicacion){
  $queryNOmegusta = sprintf("delete from megustas where idUsuario = %d and idPublicacion =%d",
  mysqli_real_escape_string($connLocalhost,$idUsuario),
  mysqli_real_escape_string($connLocalhost,$idPublicacion));
  $res_queryNOmegusta = mysqli_query($connLocalhost,$queryNOmegusta);
}
function prueba(){

  echo("Esto es una prueba");
}




  
?>