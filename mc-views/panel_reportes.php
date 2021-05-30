<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
}
$acceso = array(1); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if (!in_array($user_id, $acceso)) {
    header('Location: mc-views/error.php');
    die();
}
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
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#test1">Lista de libros</a></li>
                            <li class="tab"><a class="" href="#test2">Agregar</a></li>
                        </ul>
                    </div>
                </nav>
                
                <!-- tabla donde se listan todos los libros -->
                <div id="test1" class="col s12 ">
                    <div class="modulo_contenido">
                        <table id="tableLibros" class="striped responsive-table">
                            <thead class="teal-text">
                            <tr>
                                <th>Título</th>
                                <th>Editorial</th>
                                <th>Edición</th>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Materia</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody>
                                <?php
                                    include_once '../mc-models/Libro.php';
                                    $objLibro = new Libro();
                                    $libros = $objLibro->getAll();
                        
                                    foreach ($libros as $libro) {
                                ?>
                        
                                    <tr>
                                        <td><?= $libro->titulo ?></td>
                                        <td><?= $libro->editorial ?></td>
                                        <td><?= $libro->edicion ?></td>
                                        <td><?php 
                                                $fecha = $libro->fecha;
                                                $fecha_format = date("d/m/Y", strtotime($fecha));
                                                echo $fecha_format;
                                            ?></td>
                                        <td><?= $libro->categoria ?></td>
                                        <td><?= $libro->materia ?></td>
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <button type="button" class="btn-flat btn-accion" title="Ver detalles" onclick="verDatosLibro( <?= $libro->id ?> )" data-toggle="tooltip" data-placement="top">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </button>
                        
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
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- form para agregar un libro -->
                <div id="test2" class="col s12 ">
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
                                    <label for="i_titulo">titulo:</label>
                                </div>
                        
                                <!-- autor -->
                                <div class="col s12 input-field">
                                    <div class="chips chips-placeholder" id="chips"></div>
                                </div>
                        
                                <!-- editorial -->
                                <div class="col s12 m6 input-field">
                                    <input
                                        type="text"
                                        id="i_editorial"
                                        name="editorial"
                                        required
                                    />
                                    <label for="i_editorial">Editorial:</label>
                                </div>
                        
                                <!-- edicion -->
                                <div class="col s12 m6 input-field">
                                    <input
                                        type="text"
                                        id="i_edicion"
                                        name="edicion"
                                        required
                                    />
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
                        
                                <!-- categoria -->
                                <div class="col s12 m6 l4 input-field">
                                    <input
                                        type="text"
                                        id="i_categoria"
                                        name="categoria"
                                        required
                                    />
                                    <label for="i_categoria">Categoría:</label>
                                </div>
                        
                                <!-- materia -->
                                <div class="col s12 m6 l4 input-field">
                                    <input
                                        type="text"
                                        id="i_materia"
                                        name="materia"
                                        required
                                    />
                                    <label for="i_materia">Materia:</label>
                                </div>
                        
                                <!-- descripcion -->
                                <div class="col s12 input-field">
                                    <textarea class="materialize-textarea" name="descripcion" id="i_descripcion" cols="30" rows="10" data-length="255" required></textarea>
                                    <label for="i_descripcion">Descripción:</label>
                                </div>
                        
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <label for="i_pdf">Selecciona el archivo PDF</label>
                                    <div class="file-field input-field">
                                        <div class="btn">
                                            <span>Browse</span>
                                            <input type="file" id="i_pdf" name="pdf" required>
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
        
        <?php //include_once "modals/admin/modalVerDatosLibro.php" ?>
        <?php //include_once "modals/admin/modalEditarDatosLibro.php" ?>

        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/repositorio_panel_admin.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
