<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
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
        <!-- dataTables -->
        <link rel="stylesheet" href="../assets/librerias/css/jquery.dataTables.min.css" />
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
        <title>IUJO Repositorio | Reportes</title>

        <style type="text/css">
            #modulo {
                margin: 0 30px;
            }
            #modulo > h5{
                margin: 10px 0px;
                padding: 10px 0;
                border-bottom: 2px solid teal;
            }
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

            .reporte{
                border: 1px solid rgba(0,0,0,0.1);
                border-radius: 7px;
                cursor: pointer;
                margin: 10px 0;
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
                    <i class="material-icons left teal-text">settings</i>Reportes
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#test1">Reporte de libros</a></li>
                            <li class="tab"><a class="" href="#test2">Reporte de usuarios</a></li>
                            <!-- <li class="tab"><a class="" href="#test3">otros</a></li> -->
                        </ul>
                    </div>
                </nav>

                <br>
                <!-- filtrar libros -->
                <div class="row">
                    <form action="" id="formBuscarLibro">
                        <div class="col s12 m2   input-field">
                            <select name="b_limite_libro" id="select_limite">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label for="b_limite_libro">Límite de resultados: </label>
                        </div>
                    </form>
                </div>
                
                <!-- Reportes de Libros -->
                <div id="test1" class="row reportes">
                    <div id="botonesReportes">
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporte('getMasVistos', 'Visualizaciones', 'libro')">
                                <i class="material-icons medium teal-text">looks_one</i>
                                <h6>Más vistos</h6>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporte('getMasDescargados', 'Descargas', 'libro')">
                                <i class="material-icons medium teal-text">looks_two</i>
                                <h6>Más descargados</h6>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporte('getMejorCalificados', 'Calificación', 'libro')">
                                <i class="material-icons medium teal-text">looks_3</i>
                                <h6>Con mejor calificación</h6>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporteLibros()">
                                <i class="material-icons medium teal-text">looks_4</i>
                                <h6>Cantidad de libros activos / no activos</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col s12" id="libros_resultado">
                        <button class="btn-flat waves-effect waves-light tooltipped" data-position="right" data-tooltip="Volver" onclick="cerrarReportes()"><i class="material-icons teal-text left">arrow_back</i>Volver</button>
                        <table id="tableReporteLibros" class="highlight">
                            <thead class="teal-text">
                            <tr>
                                <th>top</th>
                                <th>Título</th>
                                <th>Editorial</th>
                                <th>Edición</th>
                                <th id="thResultado"></th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyLibros">
                               
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Reportes de Usuarios -->
                <div id="test2" class="row reportes">
                    <div id="botonesReportesUsuarios">
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporte('getUsuarioVistas', 'Libros leidos', 'usuario')">
                                <i class="material-icons medium teal-text">looks_one</i>
                                <h6>Más libros leidos</h6>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporte('getUsuarioDescargas', 'Libros descargados', 'usuario')">
                                <i class="material-icons medium teal-text">looks_two</i>
                                <h6>Más libros descargados</h6>
                            </div>
                        </div>
                        
                        <div class="col s12 m6 l4">
                            <div class="valign-wrapper hoverable reporte" onclick="reporteUsuarios()">
                                <i class="material-icons medium teal-text">looks_3</i>
                                <h6>Reporte de usuarios y colaboradores</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col s12" id="usuarios_resultado">
                        <button class="btn-flat waves-effect waves-light tooltipped" data-position="right" data-tooltip="Volver" onclick="cerrarReportes()"><i class="material-icons teal-text left">arrow_back</i>Volver</button>
                        <table id="tableReporteUsuarios" class="highlight">
                            <thead class="teal-text">
                            <tr>
                                <th>top</th>
                                <th>Nombre</th>
                                <th>Cédula</th>
                                <th id="thResultadoUsuario">Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody id="tbodyUsuarios">
                               
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Otros reportes -->
                <!-- <div id="test3" class="col s12 ">
                    <div class="modulo_contenido">
                        c
                    </div>
                </div> -->
                
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
        <script type="text/javascript" src="../assets/js/repositorio_panel_reportes.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
