<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
}
$acceso = array(1,2,3); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if (!in_array($user_id, $acceso)) {
    header('Location: mc-views/error.php');
    die();
}

$libro_id;
if( isset($_GET['libro_id']) ){
    $libro_id = $_GET['libro_id'];
}else{
    header("location: error.html");
}

include_once '../mc-models/Libro.php';
include_once '../mc-models/Autor.php';

$objLibro = new Libro();
$objAutor = new Autor();

$libro = $objLibro->getOneById($libro_id);

// autores
$consulta_autores = $objAutor->getByLibroId($libro_id);
$count = count($consulta_autores);

$autores = "Por ";
$index;

if($count > 1){
    foreach($consulta_autores as $key => $value){
        $index = $key + 1;
        $autores = $autores . $value->nombre ;
        if( ( $count - $index) > 1){
            $autores = $autores . ", ";
        }else if(( $count - $index) == 1){
            $autores = $autores . " y ";
        }
    }
}else{
    $autores = "Por " . $consulta_autores[0]->nombre;
}


//  Calificacion        
$calificacion = $objLibro->getCalificacionByLibroId($libro->id);
$x = "";

$promedio = $calificacion->cantidad;
if($promedio != null){
    for ($i=0; $i < 5; $i++) { 
        if($promedio >= 1) $x = $x . "<i class='material-icons yellow-text text-darken-1'>star</i>";

        else if($promedio > 0 && $promedio < 1) $x = $x . "<i class='material-icons yellow-text text-darken-1'>star_half</i>";

        else $x = $x . "<i class='material-icons yellow-text text-darken-1'>star_border</i>";
        $promedio = $promedio - 1;
    }
}else{
    $x = "Sin calificar";
}
// $x = $promedio;
// descargas
$descargas =  $objLibro->getDescargasByLibroId($libro->id)->cantidad;

// vistas
$visualizaciones = $objLibro->getVistasByLibroId($libro->id)->cantidad;
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="../assets/librerias/css/material-icons.css" rel="stylesheet" />
        <!--Import materialize.css-->
        <link
            type="text/css"
            rel="stylesheet"
            href="../assets/librerias/css/materialize.min.css"
            media="screen,projection"
        />
        <link rel="stylesheet" href="../assets/librerias/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/estilos.css" />
        <!-- <link rel="stylesheet" href="../assets/css/" /> -->

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>IUJO Repositorio | <?= $libro->titulo ?> </title>

        <style type="text/css">
            #modulo {
                margin: 0 30px;
            }
            #modulo > h5{
                margin: 10px 0px;
                padding: 10px 0;
                border-bottom: 2px solid teal;
            }
            .col{margin: 10px 0px;}
            header ul li:not(.primero) a {
                color: #ddd;
            }
            .head{
                height: 35vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(../assets/images/fondos/rombo.jpg);
                background-size: 100% 100%;
                background-attachment: fixed;
            }
            .head h3{
                font-weight: bold;
                border-bottom: 3px solid #009688;
            }
            .head p{
                color: #555;
            }
            .modal-header{
                background: #26a69a;
                color: white;
                padding: 10px 30px 1px 30px;
                position: relative;
            }
            .modal-header .modal-close{
                position: absolute;
                top: 50%;
                right: 20px;
                transform: translateY(-25%);
            }
            #formCalificarLibro .estrellas{
                display: flex;
                justify-content: center;
            }
            #formCalificarLibro .estrellas p{
                cursor: pointer;
                padding: 0 3px;
                transition: all ease .3s;
            }
            #formCalificarLibro .estrellas p:hover{
                transform: scale(1.3);
            }

        </style>
    </head>

    <body>
        
        <!-- añadir menu -->
        <?php
            if($user_id == 1) include_once "menuAdministrador.php";
            if($user_id == 2) include_once "menuColaborador.php";
            if($user_id == 3) include_once "menuPersona.php";
        ?>

        <main>
            <!-- portada -->
            <div class="head"> 
                <h3 class="teal-text" id="l_titulo"><?= $libro->titulo ?></h3>
                <p><?= $autores ?></p>
            </div>

            <div id="modulo">
                <div class="titulo">
                    <h5>
                        <i class="material-icons left teal-text">description</i>Detalles del libro
                    </h5>
                </div>

                <!-- Datos libro -->
                <div class="row">
                    <div class="col s12 m4 center-align">
                        <img src="../assets/images/libros/libro.png" alt="" class="responsive-img">
                        <!-- <div class="center-align" style="padding-top: 15px;">
                            <p><b class="teal-text">Calificación: </b></p>
                            <i class="material-icons yellow-text text-darken-1">star</i>
                            <i class="material-icons yellow-text text-darken-1">star</i>
                            <i class="material-icons yellow-text text-darken-1">star</i>
                            <i class="material-icons yellow-text text-darken-1">star_half</i>
                            <i class="material-icons yellow-text text-darken-1">star_border</i>
                        </div> -->
                    </div>
                
                    <div class="s12 m8">
                        <h5 class="teal-text" id="l_titulo"></h5>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Calificación: </b></p>
                            <p> &nbsp; <?= $x ?></p>
                        </div>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Editorial: </b></p>
                            <p> &nbsp;  <?= $libro->editorial ?></p>
                        </div>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Edicion:</b></p>
                            <p> &nbsp; <?= $libro->edicion ?></p>
                        </div>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Fecha:</b></p>
                            <p> &nbsp; <?php
                                    echo date("d/m/Y", strtotime($libro->fecha));
                                ?>
                             </p>
                        </div>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Carrera:</b></p>
                            <p> &nbsp; <?= $libro->carrera ?></p>
                        </div>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Categoría: </b></p>
                            <p> &nbsp; <?= $libro->categoria ?></p>
                        </div>

                        <div class="">
                            <p><b class="teal-text">Resumen: </b><?= $libro->resumen ?></p>
                            <!-- <p> &nbsp; <?php // $libro->resumen ?></p> -->
                        </div>
                        
                        <div class="valign-wrapper">
                            <p><b class="teal-text">Visualizaciones: </b></p>
                            <p> &nbsp; <?= $visualizaciones ?></p>
                        </div>

                        <div class="valign-wrapper">
                            <p><b class="teal-text">Descargas: </b></p>
                            <p> &nbsp; <?= $descargas ?></p>
                        </div>

                        <br>
                    </div>
                    
                </div>
                <div class="row v">
                    <div class="col s12 m4" style="padding:2px;">
                        <button class="btn waves-effect waves-light teal lighten-2" style="width: 100%;" onclick="calificarLibro(<?= $libro->id ?>)"><i class="material-icons left">star</i> Calificar libro</button>
                    </div>
                    <?php
                        $download = str_replace(" ", "-", $libro->titulo) . ".pdf";
                    ?>
                    <div class="col s12 m4" style="padding:2px;">
                        <a href="../assets/pdfs/<?= $libro->pdf ?>" target="_blank" class="btn waves-effect waves-light" style="width: 100%;"><i class="material-icons left">visibility</i>Leer PDF</a>
                    </div>
                    <div class="col s12 m4" style="padding:2px;">
                        <a href="../assets/pdfs/<?= $libro->pdf ?>" class="btn waves-effect waves-light teal lighten-2" style="width: 100%;" download="<?= $download ?>"><i class="material-icons left">download</i> Descargar libro</a>
                    </div>
                </div>
                <br>
                <h5>
                    <i class="material-icons left teal-text small">person_pin</i>Calificación y comentarios
                </h5>

                <div class="row">
                    <h6 class="valign-wrapper teal lighten-1 white-text z-depth-2" style="padding: 10px;">Calificación de los usarios: &nbsp;
                        <?=  $x; ?>
                    </h6>
                </div>

                <!-- comentarios -->
                <div class="row section">
                    <h6 class="valign-wrapper "><i class="material-icons teal-text">comment</i>&nbsp; <b class="grey-text text-darken-3">Últimos comentarios </b></h6>
                            
                    <?php
                        $comentarios = $objLibro->getComentariosByLibroId($libro->id);
                        $dias = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
                        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                        foreach ($comentarios as $key => $comentario) {
                            $x = $comentario->calificacion;
                            
                            $fecha = strtotime($comentario->fecha);
                            $dia = date("d", $fecha);
                            $mes = intval(date("m", $fecha));
                            $year = intval(date("Y", $fecha));

                            $fecha_format = $dia . " de " . $meses[$mes-1] . " del " . $year;
                            ?>

                            <div class="comentario col s12">
                                <div class="valign-wrapper">
                                    <b class="teal-text comentario_nombre"><?= $comentario->nombre . " " . $comentario->apellido ?></b>
                                    &nbsp;
                                    <?php
                                    for ($i=0; $i < 5; $i++) { 
                                        if($x >= 1){
                                            echo "<i class='material-icons yellow-text text-darken-2 tiny'>star</i>";
                                        }else{
                                            echo "<i class='material-icons yellow-text text-darken-2 tiny'>star_border</i>";
                                        }
                                        $x -= 1;
                                    }
                                    ?> 
                                </div>
                                <p class="comentario_opinion"><?= $comentario->comentario ?> <b class="grey-text" style="font-size: 12px;"> <?= $fecha_format ?> </b></p>
                            </div>




                            <?php
                        }
                    ?>
                </div>


            </div>
        </main>
        
        <?php  include_once "modals/usuario/modalCalificarLibro.php" ?>
        <?php // include_once "modals/admin/modalEditarDatosLibro.php" ?>

        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/libro.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
