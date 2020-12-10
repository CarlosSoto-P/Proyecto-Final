<?php

include("connections/conn_localhost.php");

// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['id'])) header('Location: login.php');

// query para obtener la informacion del usuario 
$query_userData = sprintf("SELECT * FROM usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);
$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");
$userData= mysqli_fetch_assoc($resQueryUserData);

//obtenemos los mienbros del grupo
$query_miembros = "SELECT 
usuario.nombres as 'nombreMiembro',
usuario.idUsuario as 'idMiembro'
from miembros
left join usuario as usuario on usuario.idUsuario = miembros.idUsuario
where miembros.idGrupo = {$_GET['idGrupo']}";
$resQuery_Miembros = mysqli_query($connLocalhost, $query_miembros) or trigger_error("El query para obtener los detalles del grupo loggeado falló");


// Recuperamos los datos del grupo
$query_grupo = "SELECT * FROM grupo WHERE idGrupo = {$_GET['idGrupo']}";
$resQuery_Grupo = mysqli_query($connLocalhost, $query_grupo) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$grupoData= mysqli_fetch_assoc($resQuery_Grupo);

// Incluimos la conexión a la base de datos
include("connections/conn_localhost.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Grupo</title>
</head>
<body>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <main>

    

    <! -- cabecera -->
        <?php include("includes/header.php"); ?>




        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <div class="col-md-3">


                <section>
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
                </section>

                
                <section>

                    <div class="card">
                        <div class="card-body">
                            <div class="h5">
                                <h5 class="text-primary">Miembros</h5>



                            </div>
                            <div clas="h5">
                            
                                
                                    <?php 
                                        //while para mostrar todos los miembros 
                                        while($miembroData= mysqli_fetch_array($resQuery_Miembros))
                                        {?>
                                            <ul>
                                                <li>
                                                   <a href="perfil.php?idUsuario=<?php echo $miembroData['idMiembro']?>" class="text-dark"><?php echo($miembroData['nombreMiembro']);?></a> 
                                                </li>
                                            
                                            </ul>


                                            
                                        <?php } ?>
                                                 
                                             
                                    
                                    
                                
                                
                            </div>

                        </div>

                    </div>

                </section>
                </div>


                <div class="col-md-6 gedf-main">

              
                    
                    <hr>
                    <div class="text-center bg-info text-white h1">
                        Publicaciones
                    </div>
                    <hr>

                    <div class="card gedf-card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab"
                                        aria-controls="posts" aria-selected="true">Hacer una publicación</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                           <!-- Redordatorio no poner action.-->
                            <form  method="post">
                                <div class="tab-pane fade show active" id="posts" role="tabpanel"
                                
                                    aria-labelledby="posts-tab">
                                    <div class="form-group">
                                   
                                        <label class="sr-only" for="message">post</label>
                                       
                                        <input  class="form-control publicar" id = 'title' name = 'title' placeholder="Titulo" rows="3" type="text"></input>
                                        <textarea name = 'datosmsg'  class="form-control" id="datosmsg"  rows="3"
                                            placeholder="¿Cual es tu duda?"></textarea>
                                    </div>
                               
                                </div>

                            </div>


                            <div class="btn-toolbar justify-content-between">
                                <div class="btn-group">
                                
                                   <button  id="publicar" name="publicar">Publicar</button>
                                
                                   
                                </div>
                                </form>

                            </div>
                        </div>


                    </div>

                    <!--- \\\\\\\publicaciones-->

                    <?php
 
 $grupoID = "";
 $usuarioId = "";
 $boxText = "";
 $boxTitle = "";
 
 if (isset($_POST['btnPublicar'])){
 

    $grupoID = "";
    $usuarioId = "";
    $boxText = "";
    $boxTitle = "";

    if (isset($_POST['publicar'])) {
    $grupoID = $grupoData['idGrupo'];
    $usuarioId = $userData['idUsuario'];
    $boxText = $_POST['datosmsg'];
    $boxTitle = $_POST['title'];
    $mg = 0;
    $consulta = sprintf("INSERT INTO publicacion (idGrupo,idUsuario,contenido,titulo,megustas) VALUES ('%s','%s','%s','%s','%s')",
    mysqli_real_escape_string($connLocalhost, trim($grupoID)),
    mysqli_real_escape_string($connLocalhost, trim($grupoID)),
    mysqli_real_escape_string($connLocalhost, trim($boxText)),
    mysqli_real_escape_string($connLocalhost, trim($boxTitle)),
    mysqli_real_escape_string($connLocalhost, trim($mg))
   
   
);
$resQueryMessage = mysqli_query($connLocalhost, $consulta) or trigger_error("El query falló");

 }
 


                            for ($i=0; $i <100; $i++):
                            ?>

                   
                    <!--- \\\\\\\publicaciones-->

                    <?php



                        $ids = $grupoData['idGrupos'];
                        
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

                                            <a href="perfil.php">@nombreUsuarioMiembro
                                            <?php echo($i)?>
                                            </a>
                                        </div>
                                        <div class="h7 text-muted">nombreCompletoMiembro</div>
                                        <a class="text-muted" href="#">>nombreGrupo</a>
                                    </div>
                                </div>
                                <div>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>

                            <h5 class="text-primary">Lorem ipsum dolor sit amet, consectetur adip.</h5>

                            <p class="card-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem
                                eos
                                ipsa praesentium esse magnam nemo dolor
                                sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                            <!--<a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a> -->

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

                                    </div>
                                </div>
                                <div>
                                    
                                </div>
                            </div>

                        </div>
                        
                    <br>
                    <hr>
                    <br>
                    <?php endfor; ?>
                    <!-- Post /////-->
                </div>


                <!-- barra lateral -->

                <div class="col-md-3 float-right">
                    <div class="card gedf-card">
                        <div class="card-body">
                            <h3 class="card-title">
                                <?php 
                                    echo($grupoData['nombre']);
                                ?>
                            </h3>

                            <h6>
                                <?php
                                    echo($grupoData['descripcion'])
                                ?>
                            </h6>

                            <li>
                            <a href="informacionGrupo.php?idGrupo=<?php echo $grupoData['idGrupo']; ?>"   class="card-link">Informacion del Grupo</a>

                            </li>
                            
                            <li>
                            <a href="#" class="card-link">Abandonar grupo</a>
                            
                            </li>
                            
                        
                        
                        </div>
                    </div>
                   
                </div>
                

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>


    </main>
    


    
</body>
</html>