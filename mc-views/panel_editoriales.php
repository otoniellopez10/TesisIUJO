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
include_once '../mc-models/Editorial.php';

// $objLibro = new Libro();
// $objCarrera = new Carrera();
// $objCategoria = new Categoria();
$objEditorial = new Editorial();

// $libros = $objLibro->getAll();
// $librosDesactivados = $objLibro->getAllDesactivados();
// $carreras = $objCarrera->getAll();
// $categorias = $objCategoria->getAll();

$editoriales = $objEditorial->getAll();



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
        <link rel="shortcut icon" href="../assets/images/logos/logo-original.png">
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
                    <i class="material-icons left teal-text">dashboard</i>Gestionar editoriales
                    <img src="../assets/images/logos/logo-iujo4.png" class="right" alt="" width="110px">
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#test1">Lista de editoriales</a></li>
                        </ul>
                    </div>
                </nav>

                
                <!-- tabla donde se listan todos los libros -->
                <div id="test1" class="col s12 ">
                    <div class="modulo_contenido">

                        <table id="tableEditoriales" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyEditoriales">
                                <?php
                                    foreach ($editoriales as $index => $editorial) {
                                ?>
                        
                                    <tr>
                                        <td><?= strval($index + 1) ?></td>
                                        <td><?= $editorial->nombre ?></td>
                                        <td class="td-actions  text-right">
                        
                                            <button type="button" class="btn-flat btn-accion" title="Editar" onclick="editarEditorial( <?= $editorial->id ?>, '<?= $editorial->nombre ?>' )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons blue-grey-text">edit</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion" title="Eliminar" onclick="eliminarEditorial( <?= $editorial->id ?> )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons red-text">close</i>
                                            </button>
                                        </td>
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
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large teal pulse tooltipped" data-position="left" data-tooltip="Agregar editorial" onclick="agregarEditorial()">
                <i class="large material-icons">add</i>
            </a>
        </div>

        <div id="modalAgregarEditorial" class="modal">
            <div class="modal-header">
                <h5 class="valign-wrapper"> <i class="material-icons left">add_circle</i> Agregar editorial</h5>
                <i class="material-icons modal-close">close</i>
            </div>
            <form action="" id="formAgregarEditorial">
                <div class="modal-content">

                    <div class="row">
                        <div class="col s12 input-field">
                            <input type="text" id="editorial_nombre" name="editorial_nombre" required placeholder="Nombre de la editorial"/>
                            <label for="editorial_nombre">Nombre:</label>
                        </div>

                    </div>

                </div>

                <div class="modal-footer row">
                    <div class="col s12 right-align">
                        <a class="btn-flat waves-effect waves-light modal-close">Cerrar</a>
                        <button type="submit" class="btn waves-effect waves-light" id="btnAgregarEditorial">Guardar</button>
                    </div>
                </div>
            </form> 
        </div>

        <div id="modalEditarEditorial" class="modal">
            <div class="modal-header">
                <h5 class="valign-wrapper"> <i class="material-icons left">add_circle</i> Editar editorial</h5>
                <i class="material-icons modal-close">close</i>
            </div>
            <form action="" id="formEditarEditorial">
                <div class="modal-content">

                    <div class="row">
                        <div class="col s12 input-field">
                            <input type="text" id="editar_editorial_nombre" name="editar_editorial_nombre" required placeholder="Nombre de la editorial"/>
                            <label for="editar_editorial_nombre">Nombre:</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer row">
                    <div class="col s12 right-align">
                        <a class="btn-flat waves-effect waves-light modal-close">Cerrar</a>
                        <button type="submit" class="btn waves-effect waves-light" id="btnEditarEditorial">Guardar</button>
                    </div>
                </div>
            </form> 
        </div>
        
        <?php include_once "modals/admin/modalEditarDatosLibro.php" ?>

        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/datatables.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/js/repositorio_panel_editoriales.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
