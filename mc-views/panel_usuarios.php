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

include_once '../mc-models/Persona.php';
$objPersona = new Persona();
$personas = $objPersona->getAll();
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- dataTables -->
        <link rel="stylesheet" href="../assets/librerias/DataTables/datatables.min.css" />
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../assets/librerias/css/materialize.min.css" media="screen,projection" />
        <!--Import Google Icon Font-->
        <link href="../assets/librerias/css/material-icons.css" rel="stylesheet" />
        <!-- estilos personalizados -->
        <link rel="stylesheet" href="../assets/css/estilos.css" />

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
                    <i class="material-icons left teal-text">person_pin</i>Usuarios registrados
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#tap1">Todos</a></li>
                            <li class="tab"><a class="" href="#tap2">Colaboradores</a></li>
                            <li class="tab"><a class="" href="#tap3">usuarios</a></li>
                            <li class="tab"><a class="" href="#tap4">Desactivados</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- <div class="row " style="margin-top: 20px;">
                    <form action="" id="formBuscarUsuario">
                        <div class="col s12 m6 l4 input-field">
                            <input type="text" id="b_usuario_cedula" name="b_usuario_cedula" placeholder="Buscar usuario por cédula" required>
                            <label for="b_usuario_cedula">Cédula: </label>
                        </div>
                        <div class="col s12 m1 l1 input-field">
                            <button type="submit" class="btn waves-effect waves-light tooltipped"  data-position="top" data-tooltip="Buscar">
                            <i class="material-icons">search</i></button>
                        </div>
                    </form>
                </div> -->
                
                <!-- tabla donde se listan todos los usuarios -->
                <div id="tap1" class="col s12 ">
                    <div class="modulo_contenido">
                        <table id="tableTodos" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre y apellido</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>rol</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody>
                                <?php
                                    foreach ($personas as $persona) {
                                        if($persona->estatus == 1){
                                ?>
                        
                                    <tr>
                                        <td><?= $persona->cedula ?></td>
                                        <td><?= $persona->nombre . " " . $persona->apellido ?></td>
                                        <td><?= $persona->email ?></td>
                                        <td><?= $persona->tipo ?></td>
                                        <td><?= $persona->rol ?></td>
                                        
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Ver detalles" onclick="verPersona( <?= $persona->id ?> )">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </button>

                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="bttom" data-tooltip="Editar" onclick="editarPersona( <?= $persona->usuario_id ?> )">
                                            <i class="material-icons grey-text">edit</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Desactivar" onclick="desactivarPersona( <?= $persona->usuario_id ?> )">
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

                <!--  table donde se listan los usuarios de tipo "Colaborador" -->
                <div id="tap2" class="col s12 ">
                    <div class="modulo_contenido">
                    <table id="tableColaboradores" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre y apellido</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>rol</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody>
                                <?php
                                    foreach ($personas as $persona) {
                                        if($persona->rol === "Colaborador" && $persona->estatus == 1){
                                ?>
                        
                                    <tr>
                                        <td><?= $persona->cedula ?></td>
                                        <td><?= $persona->nombre . " " . $persona->apellido ?></td>
                                        <td><?= $persona->email ?></td>
                                        <td><?= $persona->tipo ?></td>
                                        <td><?= $persona->rol ?></td>
                                        
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Ver detalles" onclick="verPersona( <?= $persona->id ?> )">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </button>

                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="bttom" data-tooltip="Editar" onclick="editarPersona( <?= $persona->usuario_id ?> )">
                                            <i class="material-icons grey-text">edit</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Desactivar" onclick="desactivarPersona( <?= $persona->usuario_id ?> )">
                                            <i class="material-icons red-text">delete</i>
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
                
                <!-- tabla donde se listan los usuarios comunes -->
                <div id="tap3" class="col s12 ">
                    <div class="modulo_contenido">
                    <table id="tableUsuarios" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre y apellido</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>rol</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody>
                                <?php
                                    foreach ($personas as $persona) {
                                        if($persona->rol === "Usuario" && $persona->estatus == 1){
                                ?>
                        
                                    <tr>
                                        <td><?= $persona->cedula ?></td>
                                        <td><?= $persona->nombre . " " . $persona->apellido ?></td>
                                        <td><?= $persona->email ?></td>
                                        <td><?= $persona->tipo ?></td>
                                        <td><?= $persona->rol ?></td>
                                        
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Ver detalles" onclick="verPersona( <?= $persona->id ?> )">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </button>

                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="bttom" data-tooltip="Editar" onclick="editarPersona( <?= $persona->usuario_id ?> )">
                                            <i class="material-icons grey-text">edit</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Desactivar" onclick="desactivarPersona( <?= $persona->usuario_id ?> )">
                                            <i class="material-icons red-text">delete</i>
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

                <!-- tabla donde se listan los usuarios desactivados -->
                <div id="tap4" class="col s12 ">
                    <div class="modulo_contenido">
                    <table id="tableDesactivados" class="highlight" style="width: 100%;">
                            <thead class="teal-text">
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre y apellido</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>rol</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        
                            <tbody>
                                <?php
                                    foreach ($personas as $persona) {
                                        if($persona->estatus == 0){
                                ?>
                        
                                    <tr>
                                        <td><?= $persona->cedula ?></td>
                                        <td><?= $persona->nombre . " " . $persona->apellido ?></td>
                                        <td><?= $persona->email ?></td>
                                        <td><?= $persona->tipo ?></td>
                                        <td><?= $persona->rol ?></td>
                                        
                        
                        
                                        <td class="td-actions  text-right">
                                            
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Ver detalles" onclick="verPersona( <?= $persona->id ?> )">
                                            <i class="material-icons cyan-text">visibility</i>
                                            </button>
                        
                                            <button type="button" class="btn-flat btn-accion tooltipped" data-position="top" data-tooltip="Activar" onclick="activarPersona( <?= $persona->usuario_id ?> )">
                                            <i class="material-icons green-text">done</i>
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
                
            </div>
        </main>
        
        <?php include_once "modals/admin/modalVerDatosPersona.php" ?>
        <?php include_once "modals/admin/modalEditarUsuario.php" ?>

        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <!-- jquery -->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" src="../assets/librerias/DataTables/datatables.min.js"></script>
        <!-- materialize -->
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>

        <!-- SweetAlert2 alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>

        <script type="text/javascript" src="../assets/js/repositorio_panel_usuarios.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
