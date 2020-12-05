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
//consultar los amigos





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



    <title>Let's Teach</title>


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
                    <div class="text-center bg-info text-white h1">
                        Publicaciones de tus Grupos
                    </div>
                    <hr>

                    <!--- \\\\\\\publicaciones-->

                    <?php

                    
                        //query para sacar las publicaciones de la base de datos
                            
                    if(isset($idGrupos)){


                        $ids = implode(",",$idGrupos);
                        
                        $query_publicaciones = ("SELECT 
                        usuario.idUsuario as 'idUsuario',
                        usuario.nombres as 'nombre',
                        usuario.apellidos as 'apellido',
                        grupo.idGrupo as 'idGrupo',
                        grupo.nombre as 'grupo',
                        publicacion.titulo as 'titulo',
                        publicacion.contenido as 'contenido',
                        publicacion.megustas as 'megustas',
                        publicacion.idPublicacion as 'idPublicacion'
                        from publicacion
                        LEFT JOIN usuario as usuario ON usuario.idUsuario = publicacion.idUsuario
                        LEFT JOIN grupo as grupo ON grupo.idGrupo = publicacion.idGrupo
                        where publicacion.idGrupo  in ($ids)");

                        $resquery_publicaciones = mysqli_query($connLocalhost, $query_publicaciones);
                        $publicaciones = mysqli_fetch_assoc($resquery_publicaciones);
                        

                            do{
                            ?>

                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                        <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <div class="h5 m-0">

                                            <a href="perfil.php?idUsuario=<?php echo $publicaciones['idUsuario']?>">
                                                <span class="text-primary"> <?php echo($publicaciones['nombre'])?>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="h7 text-muted"><?php echo($publicaciones['apellido'])?></div>
                                        <a class="text-dark" href="#">><?php echo($publicaciones['grupo'])?></a>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                            <h5 class="text-info"><?php echo($publicaciones['titulo'])?></h5>

                            <p class="card-text">
                                <?php echo($publicaciones['contenido'])?>
                            </p>
                        </div>




                        <div id="publicaciones" class="card-footer">



                            <?php 
                            $query_megusta = sprintf("SELECT * FROM megustas WHERE idUsuario =%d AND idPublicacion = %d",
                            mysqli_real_escape_string($connLocalhost, trim($userData['idUsuario'])),
                            mysqli_real_escape_string($connLocalhost, trim($publicaciones['idPublicacion'])));

                            $resquery_query_megusta = mysqli_query($connLocalhost,$query_megusta) or trigger_error(" la query de megustas fallo");
                            
                            
                            if(mysqli_num_rows($resquery_query_megusta)==0){?>

                            <a class="btn btn-info "><span>
                                    <span
                                        id="cantidad_<?php echo $publicaciones['idPublicacion']?>"><?php echo $publicaciones['megustas']?></span>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-suit-heart"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 6.236l.894-1.789c.222-.443.607-1.08 1.152-1.595C10.582 2.345 11.224 2 12 2c1.676 0 3 1.326 3 2.92 0 1.211-.554 2.066-1.868 3.37-.337.334-.721.695-1.146 1.093C10.878 10.423 9.5 11.717 8 13.447c-1.5-1.73-2.878-3.024-3.986-4.064-.425-.398-.81-.76-1.146-1.093C1.554 6.986 1 6.131 1 4.92 1 3.326 2.324 2 4 2c.776 0 1.418.345 1.954.852.545.515.93 1.152 1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z" />
                                    </svg></span> <span class="like"
                                    id="<?php echo $publicaciones['idPublicacion']?>">Me gusta</span> </a>

                            <?php } else {?>
                            <a class="btn btn-info "><span>
                                    <span
                                        id="cantidad_<?php echo $publicaciones['idPublicacion']?>"><?php echo $publicaciones['megustas']?></span>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-suit-heart"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 6.236l.894-1.789c.222-.443.607-1.08 1.152-1.595C10.582 2.345 11.224 2 12 2c1.676 0 3 1.326 3 2.92 0 1.211-.554 2.066-1.868 3.37-.337.334-.721.695-1.146 1.093C10.878 10.423 9.5 11.717 8 13.447c-1.5-1.73-2.878-3.024-3.986-4.064-.425-.398-.81-.76-1.146-1.093C1.554 6.986 1 6.131 1 4.92 1 3.326 2.324 2 4 2c.776 0 1.418.345 1.954.852.545.515.93 1.152 1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z" />
                                    </svg></span> <span class="like"
                                    id="<?php echo $publicaciones['idPublicacion']?>">No me gusta</span> </a>
                            <?php } ?>



                            <!---<a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>--->
                        </div>
                    </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <?php } while ($publicaciones = mysqli_fetch_assoc($resquery_publicaciones));
                    }else{

                    ?>
                    <div class="text-center text-danger h1">
                        Registrate a un grupo primero
                    </div>
                    <div class="text-center">
                        <img src="imagenes/nohay.jpg" alt="">
                    </div>

                    <?php
                    }
                    ?>




                    <!-- Post /////-->
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