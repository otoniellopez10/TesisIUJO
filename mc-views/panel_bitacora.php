<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
}
$acceso = array(1); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if (!in_array($user_id, $acceso)) {
    header('Location: error.php');
    die();
}

// include_once '../mc-models/Libro.php';
// include_once '../mc-models/Carrera.php';
// include_once '../mc-models/Categoria.php';
include_once '../mc-models/Bitacora.php';

// $objLibro = new Libro();
// $objCarrera = new Carrera();
// $objCategoria = new Categoria();
$objBitacora = new Bitacora();

// $libros = $objLibro->getAll();
// $librosDesactivados = $objLibro->getAllDesactivados();
// $carreras = $objCarrera->getAll();
// $categorias = $objCategoria->getAll();

$bit_persona = $objBitacora->getBitacoraPersona();
$bit_libro = $objBitacora->getBitacoraLibro();



?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="../assets/librerias/css/material-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/librerias/css/datatables.min.css" />
        <!--Import materialize.css-->
        <link
            type="text/css"
            rel="stylesheet"
            href="../assets/librerias/css/materialize.min.css"
            media="screen,projection"
        />
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
            #modulo h5{
                margin: 10px 0px;
                padding: 10px 0;
                border-bottom: 2px solid teal;
            }
            .modulo_contenido {
                padding: 30px 20px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }
            #test1 h6, #test2 h6{
                margin-top: 40px;
                font-weight: bold;
                color: #26a69a;
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
            .btn-accion{ padding: 0 5px; }
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
                    <i class="material-icons left teal-text">description</i>Bitácora del sistema
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#test1">Bitácora de libros</a></li>
                            <li class="tab"><a class="" href="#test2">Bitácora de usuarios</a></li>
                        </ul>
                    </div>
                </nav>

                
                <!-- tabla donde se listan todos los libros -->
                <div id="test1" class="col s12 ">
                    <div class="modulo_contenido">

                        <table id="tableLibro" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Operación</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyLibro">
                                <?php
                                    foreach ($bit_libro as $index => $op) {
                                        $fecha = date("d-m-Y", strtotime($op->fecha));
                                        $hora = date("h:i A", strtotime($op->fecha));
                                ?>
                        
                                    <tr>
                                        <td><?= strval($index + 1) ?></td>
                                        <td><?= $op->nombre . " " . $op->apellido ?></td>
                                        <td><?= $op->operacion ?></td>
                                        <td><?= $fecha ?></td>
                                        <td><?= $hora ?></td>
                                    </tr>
                        
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="test2" class="col s12">
                    <div class="modulo_contenido">
                    <table id="tablePersona" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>#</th>
                                <th>Operación</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyPersona">
                                <?php
                                    foreach ($bit_persona as $index => $op) {
                                        $fecha = date("d-m-Y", strtotime($op->fecha));
                                        $hora = date("h:i A", strtotime($op->fecha));
                                ?>
                        
                                    <tr>
                                        <td><?= strval($index + 1) ?></td>
                                        <td><?= $op->operacion ?></td>
                                        <td><?= $fecha ?></td>
                                        <td><?= $hora ?></td>
                                    </tr>
                        
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </main>

        <!-- btn par agregar editorial -->
        <!-- <div class="fixed-action-btn">
            <a class="btn-floating btn-large teal pulse tooltipped" data-position="left" data-tooltip="Agregar editorial" onclick="agregarEditorial()">
                <i class="large material-icons">add</i>
            </a>
        </div> -->
        
        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/datatables.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/js/repositorio_panel_bitacora.js"></script>
        <script type="text/javascript">
            M.AutoInit();
        </script>
    </body>
</html>
