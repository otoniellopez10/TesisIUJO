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

// include_once '../mc-models/Libro.php';
// include_once '../mc-models/Carrera.php';
// include_once '../mc-models/Categoria.php';
// include_once '../mc-models/Editorial.php';

// $objLibro = new Libro();
// $objCarrera = new Carrera();
// $objCategoria = new Categoria();
// $objEditorial = new Editorial();

// $libros = $objLibro->getAll();
// $librosDesactivados = $objLibro->getAllDesactivados();
// $carreras = $objCarrera->getAll();
// $categorias = $objCategoria->getAll();
// $editoriales = $objEditorial->getAll();



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
        <title>IUJO Repositorio | Repositorio</title>

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
                    <i class="material-icons left teal-text">dashboard</i>Panel administrativo
                </h5>
                <!-- portada -->
                <div class="row">
                    <div class="col s12 m4 center-align">
                        <img src="../assets/images/libros/libro.png" alt="" class="responsive-img">
                    </div>
                
                    <div class="s12 m8">
                        <h5 class="teal-text" id="l_titulo">El caballero de la armadura oxidada</h5>
                        <div class="valign-wrapper">
                            <p><b>Titulo</b></p>
                            <p id=l_titulo">Titulo del</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <?php // include_once "modals/admin/modalVerDatosLibro.php" ?>
        <?php include_once "modals/admin/modalEditarDatosLibro.php" ?>

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
