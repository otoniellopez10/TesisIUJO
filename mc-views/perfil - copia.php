<?php 
session_start();

// validar si hay sesion iniciada
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
}

$acceso = array(1,2,3); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if (!in_array($user_id, $acceso)) {
    header('Location: mc-views/error.html');
    die();
}

$usuario_id;
if( isset($_GET['usuario']) ){
    $usuario_id = $_GET['usuario'];
}else{
    $usuario_id = $_SESSION["user"]->id;
}

if($_SESSION["user"]->id != $usuario_id && $_SESSION["user"]->rol_id != 1){
    header('Location: mc-views/error.html');
    die();
}

include_once '../mc-models/Persona.php';
include_once '../mc-models/Libro.php';

$objPersona = new Persona();
$objLibro = new Libro();

$persona = $objPersona->getOneByUsuarioId($usuario_id);

// libros vistos
$libros_vistos = $objPersona->getUsuarioVistasById($usuario_id)->cantidad;
$libros_descargados = $objPersona->getUsuarioDescargasById($usuario_id)->cantidad;

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
        <link rel="stylesheet" href="../assets/css/perfil.css" />
        <!-- <link rel="stylesheet" href="../assets/css/" /> -->

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>IUJO Repositorio | <?= $persona->nombre . " " . $persona->apellido ?> </title>
    </head>

    <body>
        
        <!-- añadir menu -->
        <?php
            if($user_id == 1) include_once "menuAdministrador.php";
            if($user_id == 2) include_once "menuColaborador.php";
            if($user_id == 3) include_once "menuPersona.php";
        ?>

        <main>
            <!-- portada -->
            <div class="head"> 
                <h3><?= $persona->nombre." ".$persona->apellido ?></h3>
                <p><?= $persona->rol ?></p>
            </div>

            <!-- datos personales -->
            <div class="container section" id="cont-datos-usuario">
                <div class="row">
                    <div class="col s12" style="padding: 0;">
                        <nav class="nav-extended teal" id="nav">
                            <div class="nav-content">
                                <ul class="tabs tabs-transparent">
                                    <li class="tab"><a class="active" href="#test1">Datos personales</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <div class="col s12" id="usuario-datos">
                        <form action="">
                            <div class="row">
                                <div class="col s12 m6 input-field">
                                    <input type="text" name="u_nombre" id="u_nombre" placeholder="nombre" disabled value="<?= $persona->nombre ?>"> 
                                    <label for="u_nombre">Nombre: </label>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <input type="text" name="u_apellido" id="u_apellido" placeholder="null" disabled value="<?= $persona->apellido ?>"> 
                                    <label for="u_apellido">Apellido: </label>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <input type="text" name="u_cedula" id="u_cedula" placeholder="null" disabled value="<?= $persona->cedula ?>"> 
                                    <label for="u_cedula">Cédula: </label>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <input type="text" name="u_email" id="u_email" placeholder="null" disabled value="<?= $persona->email ?>"> 
                                    <label for="u_email">Email: </label>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <input type="text" name="u_telefono" id="u_telefono" placeholder="null" disabled value="<?= $persona->telefono ?>"> 
                                    <label for="u_telefono">Teléfono: </label>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <input type="text" name="u_rol" id="u_rol" placeholder="null" disabled value="<?= $persona->rol ?>"> 
                                    <label for="u_rol">Rol: </label>
                                </div>
                            </div>

                            <?php 
                                if($usuario_id == $_SESSION["user"]->id){
                            ?>
                            <?php
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>


            <!-- actividad del usuario en el sistema -->
            
        </main>
        
        <?php  include_once "modals/usuario/modalCalificarLibro.php" ?>
        <?php // include_once "modals/admin/modalEditarDatosLibro.php" ?>

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
