<?php 
session_start();
if (isset($_SESSION['user_name'])) {
    header('Location: repositorio.php');   
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link
            href="../assets/librerias/css/material-icons.css"
            rel="stylesheet"
        />
        <!--Import materialize.css-->
        <link
            type="text/css"
            rel="stylesheet"
            href="../assets/librerias/css/materialize.min.css"
            media="screen,projection"
        />
        <link
            rel="stylesheet"
            href="../assets/librerias/css/libreria-animaciones.css"
        />
        <link rel="stylesheet" href="../assets/css/estilos.css" />
        <link rel="stylesheet" href="../assets/css/login-registro.css" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link rel="shortcut icon" href="../assets/images/logos/logo-original.png">
        <title>IUJO Repositorio | LOGIN - REGISTRO</title>
    </head>

    <body>
        <div id="preloader_centrado">
            <img
                src="../assets/images/iconos/book-default.png"
                alt=""
                class=""
                width="150px"
            />
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <section id="cont_form" class="row">
            <!-- cont_ilustracion -->
            <div class="col m6 hide-on-med-and-down">
                <h6 class="center white-text">
                    IUJO Barquisimeto - Biblioteca virtual
                </h6>
                <br />
                <img
                    src="../assets/images/SVG/undraw_secure_login_pdn4.svg"
                    alt=""
                    class="responsive-img"
                    width="90%"
                />
            </div>

            <!-- cont_formularios -->
            <div class="col s12 l6" style="background: #eee">
                <!-- formulario de login -->
                <form action="#" class="active" id="form_login">
                    <div class="valign-wrapper teal-text">
                        <i class="material-icons small">login</i>
                        <span>&nbsp;<b>Iniciar Sesi??n</b></span>
                    </div>

                    <div class="row">
                        <!-- correo -->
                        <div class="col s12 input-field">
                            <i class="material-icons prefix">person</i>
                            <input
                                type="email"
                                id="i_login_correo"
                                name="email"
                            />
                            <label for="i_login_correo"
                                >Correo electr??nico:</label
                            >
                        </div>
                        <!-- clave -->
                        <div class="col s12 input-field">
                            <i class="material-icons prefix">vpn_key</i>
                            <input
                                type="password"
                                id="i_login_clave"
                                name="password"
                            />
                            <label for="i_login_clave">Contrase??a:</label>
                        </div>

                        <div class="col s12 center">
                            <button
                                class="btn waves-effect waves-light"
                                id="btn_login"
                            >
                                ??Ingresar!
                            </button>
                        </div>
                        <!-- olvido su contrase??a? -->
                        <div
                            class="col s12 center"
                            style="margin-top: 30px; font-size: 14px"
                        >
                            <p class="grey-text text-darken-">
                                ??No recuerda su contrase??a?
                                <b
                                    ><a
                                        href="#!"
                                        onclick="alert('Funcion en desarrollo')"
                                        class="teal-text"
                                        >Click Aqui</a
                                    ></b
                                >
                            </p>
                        </div>
                    </div>
                </form>

                <!-- formluario de registro -->
                <form action="#" class="" id="form_registro">
                    <div class="valign-wrapper teal-text">
                        <i class="material-icons small">login</i>
                        <h6>&nbsp;<b>Crear Cuenta</b></h6>
                    </div>

                    <div class="row">
                        <!-- cedula -->
                        <div class="col s12 input-field">
                            <input type="text" id="i_cedula" name="cedula" onpaste="return false;"/>
                            <label for="i_cedula">C??dula:</label>
                        </div>
                        <!-- nombre -->
                        <div class="col s12 m6 input-field">
                            <input type="text" id="i_nombre" name="nombre" onpaste="return false;"/>
                            <label for="i_nombre">Nombre:</label>
                        </div>
                        <!-- apellido -->
                        <div class="col s12 m6 input-field">
                            <input
                                type="text"
                                id="i_apellido"
                                name="apellido"
                                onpaste="return false;"
                            />
                            <label for="i_apellido">Apellido:</label>
                        </div>
                        <!-- correo -->
                        <div class="col s12 input-field">
                            <input
                                type="email"
                                id="i_correo"
                                name="email"
                                name="email"
                                onpaste="return false;"
                            />
                            <label for="i_correo">correo:</label>
                        </div>

                        <!-- clave -->
                        <div class="col s12 m6 input-field">
                            <input
                                type="password"
                                id="i_clavenueva"
                                name="password"
                                onpaste="return false;"
                            />
                            <label for="i_clavenueva">Contrase??a:</label>
                        </div>
                        <!-- clave2 -->
                        <div class="col s12 m6 input-field">
                            <input type="password" id="i_clavenueva2" onpaste="return false;" />
                            <label for="i_clavenueva2"
                                >Repite la contrase??a:</label
                            >
                        </div>

                        <!-- telefono -->
                        <div class="col s12 m6 input-field">
                            <input
                                type="text"
                                id="i_telefono"
                                name="telefono"
                                onpaste="return false;"
                            />
                            <label for="i_telefono">Tel??fono:</label>
                        </div>

                        <!-- persona_tipo -->
                        <div class="col s12 m6 input-field">
                            <select id="i_persona_tipo" name="persona_tipo">
                                <option value="" disabled selected></option>
                                <option value="1">Estudiante</option>
                                <option value="2">Docente</option>
                                <option value="3">Coordinador</option>
                                <option value="4">Directivo</option>
                                <option value="5">Administraci??n</option>
                                <option value="6">Obrero</option>
                                <option value="7">Otro</option>
                            </select>
                            <label>??Cu??l es su rol?</label>
                        </div>

                        <div class="col s12 center">
                            <button
                                class="btn waves-effect waves-light"
                                id="btn_registro"
                            >
                                crear cuenta
                            </button>
                        </div>
                    </div>
                </form>

                <!-- seccion de abajo (en la parte blanca) -->
                <div id="btn_home">
                    <a
                        href="../index.php"
                        class="btn-floating pulse tooltipped"
                        data-position="left"
                        data-tooltip="Ir al inicio"
                    >
                        <i class="material-icons">home</i></a
                    >
                </div>
            </div>

            <!-- botones de registro y login -->
            <div id="cont_botones" class="">
                <button id="btn_cont_login" class="active">Ingresa</button>

                <button id="btn_cont_registro" class="">Reg??strate</button>
                <span id="linea_btn"></span>
            </div>
        </section>

        <!--JavaScript at end of body for optimized loading-->
        <script
            type="text/javascript"
            src="../assets/librerias/js/jquery-3.6.0.min.js"
        ></script>
        <script
            type="text/javascript"
            src="../assets/librerias/js/materialize.min.js"
        ></script>
        <script src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script
            type="text/javascript"
            src="../assets/js/login_registro.js"
        ></script>
    </body>
</html>
