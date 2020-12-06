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
  

  //consusltar grupos en los que este el usuario

  $query_ingrupo = sprintf("SELECT
  grupo.idGrupo AS 'idGrupo',
  grupo.nombre AS 'nombreGrupo'
  FROM miembros 
  LEFT JOIN grupo AS grupo ON  grupo.idGrupo = miembros.idGrupo
  LEFT JOIN usuario AS usuario on usuario.idUsuario = miembros.idUsuario
  WHERE miembros.idUsuario = %d",
mysqli_real_escape_string($connLocalhost, trim($userData['idUsuario']))
);

$resquery_ingrupo = mysqli_query($connLocalhost, $query_ingrupo) or trigger_error("El query para obtener los detalles del usuario loggeado falló");


$resquery_ingrupo2 = mysqli_query($connLocalhost, $query_ingrupo) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$inGrupo = mysqli_fetch_assoc($resquery_ingrupo);




//buscar resultados
$buscar = "'%".$_GET['buscar']."%'";
$query_buscar =("SELECT * FROM grupo WHERE nombre LIKE  $buscar OR descripcion LIKE $buscar");

$resquery_bucar = mysqli_query($connLocalhost, $query_buscar) or trigger_error("fallo buscar");
$resultados = mysqli_fetch_assoc($resquery_bucar);



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="js/likes.js"></script>



    <title>Resultados</title>


</head>

<body>







    <! -- cabecera -->
        <?php include("includes/header.php"); ?>




        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">

                        <div class="card-body">
                            <div class="h5">
                                <a href="miPerfil.php">
                                    <?php 
                                echo($userData['nombres'])
                                ?>
                                </a>

                            </div>
                            <div class="h7">


                                <?php 
                            echo($userData['descripcion'])
                            ?>
                            </div>
                        </div>

                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="h5">
                                <h5 class="text-primary">Estas en estos grupos</h5>



                            </div>
                            <div clas="h5">




                                <?php

                                if(isset($inGrupo)){

                            do{
                            ?>
                                <ul>
                                    <li>
                                        <a href="grupo.php?idGrupo=<?php echo $inGrupo['idGrupo']; ?>"
                                            class="text-dark">

                                            <?php 
                                        echo($inGrupo['nombreGrupo']);
                                        ?>
                                        </a>
                                    </li>
                                </ul>

                                <?php 
                                //lleno por cada fecth el id de los grupos
                                $idGrupos []= $inGrupo['idGrupo']; 
                                
                            } while ($inGrupo = mysqli_fetch_assoc($resquery_ingrupo));
                           
                        }else{
                            
                        
                                ?>

                                <div class="text-center text-danger h5">

                                    upss!! aun no estas en un grupo

                                </div>
                                <?php

                        }
                                ?>


                            </div>
                        </div>
                    </div>


                    <?php
                    //consultar grupos

                    $query_grupos =("SELECT * FROM grupo LIMIT 10");
                    $resquery_grupos = mysqli_query($connLocalhost, $query_grupos);
                    $grupos = mysqli_fetch_assoc($resquery_grupos);


                    ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="h5">
                                <h5 class="text-primary">Algunos Grupos</h5>
                            </div>
                            <div clas="h5">
                                <ul>

                                    <?php
                                    do {
                                ?>

                                    <li>
                                        <a href="grupo.php?idGrupo=<?php echo $grupos['idGrupo']; ?>" class="text-dark">
                                            <?php
                                                echo($grupos['nombre'])

                                            ?>


                                        </a>
                                    </li>

                                    <?php
                                    }while ($grupos =mysqli_fetch_assoc($resquery_grupos));
                                    
                                    ?>




                                </ul>
                            </div>
                        </div>
                    </div>


                </div>



                <div class="col-md-6 gedf-main">


                    <hr>
                    <div class=" text-center bg-info text-white h1">
                        Resultados para '<?php echo $_GET['buscar']?>'
                    </div>
                    <hr>

                    <!--- \\\\\\\resultados-->

                    <?php 

                    if(isset($resultados)){



                        do{
                    ?>

                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="ml-2">
                                        <div class="h5 m-0">

                                            <a href="grupo.php"><?php echo $resultados['nombre']?>
                                            </a>
                                        </div>
                                        <div class="h7 text-black"><?php echo $resultados['descripcion']?></div>
                                    </div>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                         } while ($resultados = mysqli_fetch_assoc($resquery_bucar));

                        }else{

                            
                        
                    ?>

                    <div class="text-center text-danger h1">
                        aprende a escribir we
                    </div>
                    <div class="text-center">
                        <img src="imagenes/nohay.jpg" alt="">
                    </div>

                        <?php }?>



                    <!-- resultados /////-->
                </div>
                <!-- barra lateral -->
                <?php include("includes/barraLateral.php"); ?>

            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
        </script>


</body>

</html>