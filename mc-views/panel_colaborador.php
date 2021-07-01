<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
}
$acceso = array(2); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if (!in_array($user_id, $acceso)) {
    header('Location: error.php');
    die();
}

include_once '../mc-models/Libro.php';
include_once '../mc-models/Carrera.php';
include_once '../mc-models/Categoria.php';
include_once '../mc-models/Editorial.php';

$objLibro = new Libro();
$objCarrera = new Carrera();
$objCategoria = new Categoria();
$objEditorial = new Editorial();

$libros = $objLibro->getlibrosColaborador($user_id);
$carreras = $objCarrera->getAll();
$categorias = $objCategoria->getAll();
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
                    <i class="material-icons left teal-text">dashboard</i>Panel administrativo
                    <img src="../assets/images/logos/logo-iujo4.png" class="right" alt="" width="110px">
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#test1">Mis libros</a></li>
                            <li class="tab"><a class="" href="#test2">Mis libros desactivados</a></li>
                            <li class="tab"><a class="" href="#test3">Agregar</a></li>
                        </ul>
                    </div>
                </nav>
                
                <!-- tabla donde se listan todos los libros -->
                <div id="test1" class="col s12 ">
                    <div class="modulo_contenido">
                        <table id="tableLibros" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>Título</th>
                                <th>Editorial</th>
                                <th>Edición</th>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyLibrosActivos">
                                <?php
                                    foreach ($libros as $libro) {
                                        if($libro->estatus == 1){
                                ?>
                        
                                    <tr>
                                        <td class="libro_titulo"><?= $libro->titulo ?></td>
                                        <td><?= $libro->editorial ?></td>
                                        <td><?= $libro->edicion ?></td>
                                        <td><?php 
                                                $fecha = $libro->fecha;
                                                $fecha_format = date("d/m/Y", strtotime($fecha));
                                                echo $fecha_format;
                                            ?></td>
                                        <td><?= $libro->categoria ?></td>
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <a href="libro.php?libro_id=<?= $libro->id ?>" class="btn-flat btn-accion" title="Ver detalles"  data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </a>
                        
                                            <button type="button" class="btn-flat btn-accion" title="Editar" onclick="editarLibro( <?= $libro->id ?> )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons blue-grey-text">edit</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion" title="Desactivar" onclick="desactivarLibro( <?= $libro->id ?> )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons red-text">delete</i>
                                            </button>
                                        </td>
                                    </tr>
                        
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- tabla donde se listan todos los libros -->
                <div id="test2" class="col s12 ">
                    <div class="modulo_contenido">
                        <table id="tableLibrosDesactivados" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>Título</th>
                                <th>Editorial</th>
                                <th>Edición</th>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyLibrosDesactivados">
                                <?php
                                    foreach ($libros as $libro) {
                                        if($libro->estatus == 0){

                                ?>
                        
                                    <tr>
                                        <td class="libro_titulo"><?= $libro->titulo ?></td>
                                        <td><?= $libro->editorial ?></td>
                                        <td><?= $libro->edicion ?></td>
                                        <td><?php 
                                                $fecha = $libro->fecha;
                                                $fecha_format = date("d/m/Y", strtotime($fecha));
                                                echo $fecha_format;
                                            ?></td>
                                        <td><?= $libro->categoria ?></td>
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <a href="libro.php?libro_id=<?= $libro->id ?>" class="btn-flat btn-accion" title="Ver detalles"  data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </a>
                        
                                            <button type="button" class="btn-flat btn-accion" title="Editar" onclick="editarLibro( <?= $libro->id ?> )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons blue-grey-text">edit</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion" title="Activar" onclick="activarLibro( <?= $libro->id ?> )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons green-text">done</i>
                                            </button>
                                        </td>
                                    </tr>
                        
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- form para agregar un libro -->
                <div id="test3" class="col s12 ">
                    <div class="modulo_contenido">
                        <form action="" id="form_AgregarLibro">
                            <div class="row">
                                <!-- titulo -->
                                <div class="col s12 input-field">
                                    <input
                                        type="text"
                                        id="i_titulo"
                                        name="titulo"
                                        required
                                    />
                                    <label for="i_titulo">Título:</label>
                                </div>
                        
                                <!-- autor -->
                                <div class="col s12 input-field">
                                    <div class="chips chips-placeholder" id="chips"></div>
                                </div>
                        
                                <!-- editorial -->
                                <div class="col s10 input-field">
                                    <select id="i_editorial" name="editorial" required>
                                        <option value="" disabled selected></option>
                                        <option value="0">Sin editorial</option>
                                        <?php
                                            foreach ($editoriales as $e) {
                                            if($e->id == 0) continue;
                                        ?>
                                            <option value="<?= $e->id; ?>"> <?= $e->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="i_editorial">Editorial:</label>
                                </div>

                                <!-- agregar editorial -->
                                <div class="col s2 input-field center-align">
                                    <button type="button" class="btn-small waves-effect waves-light tooltipped" data-position="top" data-tooltip="Agregar una editorial" onclick="agregarEditorial()"><i class="material-icons">add</i></button>
                                </div>

                                <!-- agregar categoria -->
                                <!-- <div class="col s2 m1 input-field">
                                    <button type="button" class="btn-small waves-effect waves-light tooltipped" data-position="top" data-tooltip="Agregar un categoría"><i class="material-icons">add</i></button>
                                </div> -->

                                <!-- categoria -->
                                <div class="col s12 input-field">
                                    <select id="i_categoria" name="categoria" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                            foreach ($categorias as $c) {
                                        ?>
                                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="i_categoria">categoría:</label>
                                </div>
                        
                                <!-- edicion -->
                                <div class="col s12 m6 l4 input-field">
                                    <select id="i_edicion" name="edicion" required>
                                        <option value="" disabled selected></option>
                                        <option value="Primera edición">Primera edición</option>
                                        <option value="Segunda edición">Segunda edición</option>
                                        <option value="Tercera edición">Tercera edición</option>
                                        <option value="Cuarta edición">Cuarta edición</option>
                                        <option value="Quinta edición">Quinta edición</option>
                                        <option value="Sexta edición">Sexta edición</option>
                                        <option value="Séptima edición">Séptima edición</option>
                                        <option value="Octava edición">Octava edición</option>
                                        <option value="Novena edición">Novena edición</option>
                                        <option value="Décima edición">Décima edición</option>
                                    </select>
                                    <label for="i_edicion">Edición:</label>
                                </div>
                        
                                <!-- fecha -->
                                <div class="col s12 m6 l4 input-field">
                                    <input
                                        type="date"
                                        id="i_fecha"
                                        name="fecha"
                                        required
                                    />
                                    <label for="i_fecha">Fecha:</label>
                                </div>
                        
                                <!-- carrera -->
                                <div class="col s12 m6 l4 input-field">
                                    <select id="i_carrera" name="carrera" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                            foreach ($carreras as $c) {
                                        ?>
                                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="i_carrera">Carrera:</label>
                                </div>
                        
                                <!-- resumen -->
                                <div class="col s12 input-field">
                                    <textarea class="materialize-textarea" name="resumen" id="i_resumen" cols="30" rows="10" data-length="255" required></textarea>
                                    <label for="i_resumen">Resumen:</label>
                                </div>
                        
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <label for="i_pdf">Selecciona el archivo PDF</label>
                                    <div class="file-field input-field">
                                        <div class="btn">
                                            <span>Browse</span>
                                            <input type="file" id="i_pdf" name="pdf" required accept=".pdf">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input type="text" class="file-path validate" placeholder="Upload file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col s12">
                                <button type="button" class="btn waves-effect waves-light grey" id="btnLimpiarCampos" onclick="limpiarCampos()">
                                    Limpiar campos
                                </button>
                                
                                <button type="submit" class="btn waves-effect waves-light disabled" id="btnAgregarLibro">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </main>

        <div id="modalAgregarEditorial" class="modal">
            <div class="modal-header">
                <h5 class="valign-wrapper"> <i class="material-icons left">add_circle</i> Agregar editorial</h5>
                <i class="material-icons modal-close">close</i>
            </div>
            <div class="modal-content">

                <form action="" id="formAgregarEditorial">
                    <div class="row">
                        <div class="col s12 input-field">
                            <input type="text" id="editorial_nombre" name="editorial_nombre" required placeholder="Nombre de la editorial"/>
                            <label for="editorial_nombre">Nombre:</label>
                        </div>

                    </div>
                </form>

            </div>

            <div class="modal-footer row">
                <div class="col s12 right-align">
                    <a class="btn-flat waves-effect waves-light modal-close">Cerrar</a>
                    <button type="submit" class="btn waves-effect waves-light" id="btnAgregarEditorial">Guardar</button>
                </div>
            </div>
        </div>
        
        <?php include_once "modals/admin/modalVerDatosLibro.php" ?>
        <?php include_once "modals/admin/modalEditarDatosLibro.php" ?>

        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/datatables.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/js/repositorio_panel_colaborador.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
