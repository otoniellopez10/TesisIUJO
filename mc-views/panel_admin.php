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
            #modulo_contenido {
                margin: 30px 0;
                padding: 30px 20px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 10px;
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
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="" href="#test1">Lista de libros</a></li>
                            <li class="tab"><a class="active" href="#test2">Agregar</a></li>
                        </ul>
                    </div>
                </nav>
                
                <!-- tabla donde se listan todos los libros -->
                <div id="test1" class="col s12">
                    <table id="tableLibros" class="striped responsive-table">
                        <thead class="teal-text">
                        <tr>
                            <th>Name</th>
                            <th>Item Name</th>
                            <th>Item Price</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>Alvin</td>
                            <td>Eclair</td>
                            <td>$0.87</td>
                        </tr>
                        <tr>
                            <td>Alan</td>
                            <td>Jellybean</td>
                            <td>$3.76</td>
                        </tr>
                        <tr>
                            <td>Jonathan</td>
                            <td>Lollipop</td>
                            <td>$7.00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div id="modulo_contenido">
                    <!-- form para agregar un libro -->
                    <div id="test2" class="col s12">

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
                                    <input
                                        type="text"
                                        id="i_descripcion"
                                        name="descripcion"
                                        required
                                    />
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
                                <button type="submit" class="btn waves-effect waves-light disabled" id="btnAgregarLibro">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                
                </div>
            </div>
        </main>
        
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
