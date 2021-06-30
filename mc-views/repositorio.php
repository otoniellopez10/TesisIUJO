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


$libros = $objLibro->getAll(25);
$librosRecomendados = $objLibro->getRecomendados(25);
$librosMejorCalificados = $objLibro->getMejorCalificados(25);
$librosMasDescargados = $objLibro->getMasDescargados(25);
$librosMasVistos = $objLibro->getMasVistos(25);


$carreras = $objCarrera->getAll();
$categorias = $objCategoria->getAll();
$editoriales = $objEditorial->getAll();
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
                    <i class="material-icons left teal-text">book</i>Repositorio de libros
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav" style="margin-bottom: 20px;">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="" href="#test1">Recomendados</a></li>
                            <li class="tab"><a class="" href="#test2">Mejor calificados</a></li>
                            <li class="tab"><a class="" href="#test3">Más descargados</a></li>
                            <li class="tab"><a class="" href="#test4">Más vistos</a></li>
                            <li class="tab"><a class="" href="#test5" id="tap_buscar">Buscar</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- libros recomendados -->
                <div id="test1" class="row modulo_contenido">
                    <?php
                        render($librosRecomendados);
                    ?>
                </div>

                <!-- libros mejor calificados -->
                <div id="test2" class="row modulo_contenido">
                    <?php
                        render($librosMejorCalificados);
                    ?>
                </div>

                <!-- Libros mas descargados -->
                <div id="test3" class="row modulo_contenido">
                    <?php
                        render($librosMasDescargados);
                    ?>
                </div>

                <div id="test4" class="row modulo_contenido">
                    <?php
                        render($librosMasVistos);
                    ?>
                </div>

                <!-- Buscar -->
                <div id="test5" class="row">

                    <!-- buscar libro -->
                    <div class="col s12 modulo_contenido" id="c_form_buscador">
                        <p class="section teal-text">* Filtrar libros</p>
                        <form action="" id="form_buscar_libro">
                            <div class="row">

                                <div class="col s12 m6 input-field">
                                    <input type="text" id="b_titulo" name="b_titulo"/>
                                    <label for="b_titulo">Buscar por título:</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <input type="text" id="b_autor" name="b_autor" class="autocomplete">
                                    <label for="b_autor">Buscar por autor</label>
                                </div>

                                <!-- editorial -->
                                <div class="col s12 m6 l4 input-field">
                                    <select id="b_editorial" name="b_editorial" >
                                        <option value="" selected>Todas</option>
                                        <?php
                                            foreach ($editoriales as $e) {
                                        ?>
                                            <option value="<?= $e->id; ?>"> <?= $e->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="b_editorial">Buscar por editorial:</label>
                                </div>

                                <!-- categoria -->
                                <div class="col s12 m6 l4 input-field">
                                    <select id="b_categoria" name="b_categoria" >
                                        <option value="" selected>Todas</option>
                                        <?php
                                            foreach ($categorias as $c) {
                                        ?>
                                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="b_categoria">Buscar por categoría:</label>
                                </div>

                                <!-- carrera -->
                                <div class="col s12 m12 l4 input-field">
                                    <select id="b_carrera" name="b_carrera" >
                                        <option value="" selected>General</option>
                                        <?php
                                            foreach ($carreras as $c) {
                                                if($c->nombre == "General") continue;
                                        ?>
                                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="b_carrera">Buscar por carrera:</label>
                                </div>

                                <div class="col s12 right-align">
                                    <button type="button" class="btn-flat waves-effect waves-light" id="btnLimpiarCampos" onclick="limpiarCampos()">Limpiar campos</button>
                                    
                                    <button type="submit" class="btn waves-effect waves-light" id="btnBuscar">Buscar</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <button class="btn-flat waves-effect waves-light tooltipped" data-position="right" data-tooltip="Volver" onclick="cerrarResultados()" id="btnCerrarResultados"><i class="material-icons teal-text left">arrow_back</i>Volver</button>

                    <div class="col s12 modulo_contenido" id="contResultados">
                        <table id="tableResultados" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                                <th>#</th>
                                <th>Título</th>
                                <th>Editorial</th>
                                <th>Edición</th>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody id="tbodyResultados">
                                
                            </tbody>
                        </table>
                    </div>
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
        <script type="text/javascript" src="../assets/js/repositorio.js"></script>
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
                <button class="btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Agregar a favoritos" style="margin-right: 5px;" onclick="agregarFavoritos(<?= $libro->id ?>)"><i class="material-icons ">star</i></button>
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

