<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
}
$acceso = array(2,3); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if ($user_id == 1){
    header('Location: panel_admin.php');
    die();
}else if (!in_array($user_id, $acceso)) {
    header('Location: error.php');
    die();
}

include_once '../mc-models/Libro.php';
include_once '../mc-models/Autor.php';
include_once '../mc-models/Carrera.php';
include_once '../mc-models/Categoria.php';
include_once '../mc-models/Editorial.php';

$objLibro = new Libro();
$objAutor = new Autor();
$objCarrera = new Carrera();
$objCategoria = new Categoria();
$objEditorial = new Editorial();



$librosFavoritos = $objLibro->getFavoritos($_SESSION["user"]->id);
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="../assets/librerias/css/material-icons.css" rel="stylesheet" />
        <link href="../assets/librerias/css/datatables.min.css" rel="stylesheet" />
        <!--Import materialize.css-->
        <link
            type="text/css"
            rel="stylesheet"
            href="../assets/librerias/css/materialize.min.css"
            media="screen,projection"
        />
        <link rel="stylesheet" href="../assets/css/estilos.css" />
        <link rel="stylesheet" href="../assets/css/repositorio.css" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link rel="shortcut icon" href="../assets/images/logos/logo-original.png">
        <title>IUJO Repositorio | Inicio</title>
    </head>

    <body>
        
        <!-- añadir menu -->
        <?php
            if($user_id == 1) include_once "menuAdministrador.php";
            if($user_id == 2) include_once "menuColaborador.php";
            if($user_id == 3) include_once "menuPersona.php";
        ?>

        <main>
            <div id="modulo">
                <h5>
                    <i class="material-icons left teal-text small">accessibility</i>Mi espacio
                    <img src="../assets/images/logos/logo-iujo4.png" class="right" alt="" width="110px">
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav" style="margin-bottom: 20px;">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="" href="#test1">Libros favoritos</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- libros favoritos -->
                <div id="test1" class="row modulo_contenido">
                    <?php
                        if(count($librosFavoritos) > 0){
                            render($librosFavoritos);
                        }else{
                            ?>
                            <div class="container center">
                                <div class="row">
                                    <div class="col s12">
                                        <img src="../assets/images/SVG/libros.svg" alt="" width="90%" style="max-width: 300px;" class="img-hover">
                                    </div>
                                    <div class="col s12">
                                        <h5 class="blue-grey-text text-darken-2" style="font-weight: bold;">Actualmente no cuentas con ningun libro marcado como favorito</h5>
                                    </div>
                                    <div class="col s12">
                                        <a href="repositorio.php" class="btn-fantasma">Ir al repositorio</a>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    ?>
                </div>
            </div>
        </main>
        
        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/datatables.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/js/mi_espacio.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>

<?php

function render($array){
    global $objAutor, $objLibro;
    foreach ($array as $index => $libro) {
        // fecha
        $fecha = Date("d-m-Y", strtotime($libro->fecha));
        $allAutores = $objAutor->getByLibroId($libro->id);
        $count = count($allAutores);
        $autores = "";

        foreach($allAutores as $key => $autor){
            $index = $key + 1;
            
            $autores = $autores . $autor->nombre;
            if( ( $count - $index) > 1){
                $autores = $autores . ", ";
            }else if(( $count - $index) == 1){
                $autores = $autores . " y ";
            }
        }

        // clasificacion (estrellas)
        $calificacion = $objLibro->getCalificacionByLibroId($libro->id);
        $x = "";

        $promedio = $calificacion->cantidad;
        if($promedio != null){
            for ($i=0; $i < 5; $i++) { 
                if($promedio >= 1) $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star</i>";

                else if($promedio > 0 && $promedio < 1) $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star_half</i>";

                else $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star_border</i>";
                $promedio = $promedio - 1;
            }
        }else{
            $x = "Sin calificación";
        }
?>
<div class="col s12 libro">
    <div class="row valign-wrapper">
        <div class="col s0 m3 hide-on-small-only libro_imagen">
            <img src="../assets/images/libros/libro.png" alt="" class="responsive-img" width="70%">
        </div>

        <div class="col s12 m9  libro_datos">
            <h5 class="titulo teal-text valign-wrapper"><b><?= $libro->titulo ?></b>
            </h5>
            
            <div class="valign-wrapper">
                <b>Calificación: &nbsp;</b>
                <p><?= $x ?></p>
            </div>
            
            <div class="valign-wrapper">
                <b>Autor(es): &nbsp;</b>
                <p><?=  $autores ?></p>
            </div>
            
            <div class="valign-wrapper">
                <b>Editorial: &nbsp;</b>
                <p><?= $libro->editorial ?></p>
            </div>
            
            <div class="valign-wrapper">
                <b>Edicion: &nbsp;</b>
                <p><?= $libro->edicion ?></p>
            </div>

            <div class="valign-wrapper">
                <b>Fecha de pubicación: &nbsp;</b>
                <p><?= $fecha ?></p>
            </div>

            <div class="valign-wrapper">
                <b>Categoría: &nbsp;</b>
                <p><?= $libro->categoria ?></p>
            </div>

            <div class="valign-wrapper">
                <b>Carrera: &nbsp;</b>
                <p><?= $libro->carrera ?></p>
            </div>


            <div class="botones-accion ">
                <button class="btn-small waves-effect waves-light tooltipped red" data-position="bottom" data-tooltip="Eliminar de favoritos" style="margin-right: 5px;" onclick="eliminarFavoritos(<?= $libro->id ?>)"><i class="material-icons ">star</i></button>
                <a href="<?= "libro.php?libro_id=" . $libro->id ?>" class="btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Ver detalles"><i class="material-icons">visibility</i></a>
                
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col s12 m4">
            <button class="btn waves-effect waves-light">Prueba</button>
        </div>
        <div class="col s12 m4">
            <button class="btn waves-effect waves-light">Prueba</button>
        </div>
        <div class="col s12 m4">
            <button class="btn waves-effect waves-light">Prueba</button>
        </div>
    </div> -->
    <div class="divider"></div>
</div>
<?php
    }
}

