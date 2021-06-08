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
$objLibro = new Libro();
$libros = $objLibro->getAll();
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
        <link rel="stylesheet" href="../assets/css/estilos.css" />
        <link rel="stylesheet" href="../assets/css/repositorio.css" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>IUJO Repositorio | Inicio</title>
        <style type="text/css">
            #modulo {
                margin: 0 30px;
            }
            #modulo > h5{
                margin: 10px 0px;
                padding: 10px 0;
                border-bottom: 2px solid teal;
            }
            .modulo_contenido {
                padding: 30px 20px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .col{margin: 10px 0px;}
            header ul li:not(.primero) a {
                color: #ddd;
            }
            #nav{
                position: -webkit-sticky;
                position: sticky;
                top: 0px;
                z-index: 10;
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
            <div id="modulo">
                <h5>
                    <i class="material-icons left teal-text">book</i>Repositorio de libros
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav" style="margin-bottom: 20px;">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#test1">Recomendados</a></li>
                            <li class="tab"><a class="" href="#test2">Mejor calificados</a></li>
                            <li class="tab"><a class="" href="#test3">Más descargados</a></li>
                            <li class="tab"><a class="" href="#test4">Buscar</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- libros recomendados -->
                <div id="test1" class="row modulo_contenido">

                    <?php
                        foreach ($libros as $libro) {
                    ?>
                    <div class="col 12 libro">
                        <div class="row valign-wrapper">
                            <div class="col s0 m3 l2 hide-on-small-only libro_imagen">
                                <img src="../assets/images/libros/Rc6e0b8ed98e2bb70a45d24582311daec.jpg" alt="" class="responsive-img">
                            </div>

                            <div class="col s12 m9 l10 libro_datos">
                                <h6 class="titulo teal-text"><b><?= $libro->titulo ?></b></h6>
                                <div class="valign-wrapper">
                                    <b>Autores: &nbsp;</b>
                                    <p>Otoniel Lopez, Luis rivero</p>
                                </div>

                                <div class="valign-wrapper">
                                    <b>Editorial: &nbsp;</b>
                                    <p>Santillana</p>
                                </div>

                                <div class="valign-wrapper">
                                    <b>Edicion: &nbsp;</b>
                                    <p>Primera edición</p>
                                </div>

                                <div class="valign-wrapper">
                                    <b>Fecha de pubicación: &nbsp;</b>
                                    <p>21 de abril del 2021</p>
                                </div>

                                <div class="valign-wrapper">
                                    <b>Categoría: &nbsp;</b>
                                    <p>Novela</p>
                                </div>

                                <div class="valign-wrapper">
                                    <b>Carrera: &nbsp;</b>
                                    <p>Informática</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>

                <!-- libros mejor calificados -->
                <div id="test2" class="row modulo_contenido">b</div>

                <!-- Libros mas descargados -->
                <div id="test3" class="row modulo_contenido">c</div>

                <!-- Buscar -->
                <div id="test4" class="row modulo_contenido">d</div>
            </div>
        </main>
        
        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/js/repositorio.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
