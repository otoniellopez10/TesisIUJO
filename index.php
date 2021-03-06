<?php 
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="assets/librerias/css/material-icons.css" rel="stylesheet" />
        <!--Import materialize.css-->
        <link
            type="text/css"
            rel="stylesheet"
            href="assets/librerias/css/materialize.min.css"
            media="screen,projection"
        />
        <link rel="stylesheet" href="assets/css/index.css" />
        <link rel="stylesheet" href="assets/librerias/css/libreria-animaciones.css">
        <!-- <link
            rel="stylesheet"
            href="assets/librerias/css/libreria-animaciones.css"
        />
 -->
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <link rel="shortcut icon" href="assets/images/logos/logo-original.png">
        <title>IUJO Repositorio</title>
    </head>

    <body class="hidden">
        <!-- PRELOADER! -->
        <div id="preloader_centrado">
            <img src="assets/images/iconos/book-default.png" alt="" class="" />
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <header id="header">
            <!-- menu para dispositivos mobiles -->
            <div class="navbar-fixed hide-on-large-only">
                <nav class="blue-grey darken-3 z-depth-0">
                    <div class="nav-wrapper">
                        <a href="#!" class="brand-logo center">
                            <img
                                src="assets/images/logos/logo-iujo3.png"
                                alt=""
                                width="40%"
                                style="transform: translateY(20%)"
                            />
                        </a>
                        <a
                            href="#"
                            data-target="menu-mobile"
                            class="sidenav-trigger show-on-medium-and-down"
                            ><i class="material-icons">menu</i></a
                        >
                    </div>
                </nav>
            </div>

            <!-- menu lateral -->
            <ul class="sidenav" id="menu-mobile">
                <div class="center blue-grey darken-3" style="height: 60px">
                    <img
                        src="assets/images/logos/logo-original.png"
                        alt=""
                        width="50px"
                        style="transform: translateY(20%)"
                    />
                </div>

                <li style="margin-top: 20px">
                    <a href="#!"><i class="material-icons">home</i> Inicio</a>
                </li>

                <li>
                    <a href="mc-views/repositorio.php"
                        ><i class="material-icons">book</i> Repositorio</a
                    >
                </li>

                <?php
                    if (!isset($_SESSION['user_name'])) {
                ?>
                    <li>
                        <a href="mc-views/login.php"
                            ><i class="material-icons">login</i> Ingresar</a
                        >
                    </li>

                    <li>
                        <a href="mc-views/login.php?mode=2"
                            ><i class="material-icons">person_add</i> Registrarse</a
                        >
                    </li>
                <?php
                    }else{ 
                        ?>
                            <li>
                                <a href="mc-views/perfil.php"
                                    ><i class="material-icons">account_circle</i> Mi Perfil</a
                                >
                            </li>
                        <?php
                            } 
                        ?>

            </ul>
        </header>

        <!-- seccion de inicion con menu y bienvendida -->
        <section id="s_inicio">
            <nav
                class="transparent z-depth-0 hide-on-med-and-down animate__animated animate__fadeInLeft animate__delay-1s"
                id="inicio_menu"
            >
                <a href="#!" class="brand-logo">
                    <img
                        src="assets/images/logos/logo-iujo3.png"
                        alt=""
                        width="25%"
                        style="transform: translateY(20%)"
                    />
                </a>

                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php
                        if (!isset($_SESSION['user_name'])) {
                    ?>
                        <li>
                            <a href="mc-views/login.php">
                                <i class="material-icons left">login</i>Iniciar Sesi??n
                            </a>
                        </li>

                        <li>
                            <a href="mc-views/login.php?mode=2">
                                <i class="material-icons left">person_add</i>Reg??strate
                            </a>
                        </li>
                    <?php
                        }else{ 
                    ?>   
                        <li>
                            <a href="mc-views/repositorio.php"
                                ><i class="material-icons left">book</i>
                                Repositorio</a
                            >
                        </li>

                        <li>
                            <a href="mc-views/logout.php"
                            ><i class="material-icons left">exit_to_app</i>
                            Cerrar Sesi??n</a>
                        </li>   
                    <?php
                        } 
                    ?>
                </ul>
            </nav>

            <h1 id="inicio_titulo">??Bienvenido!</h1>

            <div id="inicio_ola" style="height: 150px; overflow: hidden">
                <svg
                    viewBox="0 0 500 150"
                    preserveAspectRatio="none"
                    style="height: 100%; width: 100%"
                >
                    <path
                        d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                        style="stroke: none; fill: #fff"
                    ></path>
                </svg>
            </div>
        </section>

        <!-- seccion de buscar libro -->
        <section class="container section" id="s_buscador">
            <p class="center">
                Puedes consultar un libro escribiendo su nombre en el buscador.
            </p>

            <form action="mc-views/repositorio.php">
                <div class="row valign-wrapper">
                    <div class="col s12 m11 input-field">
                        <input type="text" name="i_buscador" id="i_buscador" required/>
                        <label for="i_buscador">Escribe el nombre del libro</label>
                    </div>

                    <div class="col s12 m1 center">
                        <button
                            class="btn waves waves-effect waves-light tooltiped"
                            data-tooltip="hola"
                            id="btn_buscador"
                        >
                            <i class="material-icons">search</i>
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <!-- SECCION DE CARACTERISTICAS -->
        <section class="section" id="s_caracteristicas">
            <div class="row">
                <div class="col s12 m6 l3 carta">
                    <!-- <p class="center"><i class="material-icons">book</i></p> -->
                    <p>
                        <img src="assets/images/SVG/librosTeal.svg" alt="" width="50%" />
                    </p>
                    <p class="center">Los libros que necesitas</p>
                    <p class="contenido">
                        En el sistema podr??s encontrar todos los libros que
                        necesites referente a los temas que requieras estudiar
                        en tu carrera o cualquier otra informaci??n que
                        necesites.
                    </p>
                </div>
                <div class="col s12 m6 l3 carta">
                    <p>
                        <img src="assets/images/SVG/searchTeal.svg" alt="" width="50%" />
                    </p>
                    <p class="center">Gran variedad de temas</p>
                    <p class="contenido">
                        Tenemos todos los libros que necesitas para estudiar.
                        Pero tambi??n, el sistema cuenta con novelas, cuentos,
                        fantas??a, terror, entre otras categor??as interesantes.
                    </p>
                </div>
                <div class="col s12 m6 l3 carta">
                    <p>
                        <img src="assets/images/SVG/teamTeal.svg" alt="" width="87%" />
                    </p>
                    <p class="center">Colaboraci??n con el sistema</p>
                    <p class="contenido">
                        Si eres una persona que quiere aportar a este gran
                        sistema de ayuda estudiant??l, puedes obtener un permiso
                        para cargar libros al sistema que sean de utilidad.
                    </p>
                </div>
                <div class="col s12 m6 l3 carta">
                    <p>
                        <img src="assets/images/SVG/downloadTeal.svg" alt="" width="44%" />
                    </p>
                    <p class="center">Descargar tu contenido</p>
                    <p class="contenido">
                        Si te ha gustado un libro de fantas??a, una novela, o
                        incluso un libro de alguna materia y quieres llevarlo
                        siempre contigo, tienes la opci??n de descargarlos.
                    </p>
                </div>
            </div>
        </section>

        <!-- seccion de beneficios de registrarse -->

        <section id="s_beneficios" class="section">
            <div class="row black_card valign-wrapper">
                <div class="col l6 hide-on-med-and-down center-align">
                    <img
                        src="assets/images/SVG/beneficios.svg"
                        alt=""
                        class="responsive-img"
                        width="75%"
                    />
                </div>
                <div class="col s12 l6">
                    <!-- titulo de la seccion  -->
                    <h5>??QU?? BENEFICIOS TE OFRECEMOS?</h5>

                    <div class="valign-wrapper">
                        <i class="material-icons left">book</i>
                        <p>
                            <b>Acceso completo al repositorio.</b>
                            luego de registrarte en el sistema tendr??s acceso a
                            todos los libros de nuestra base de datos.
                        </p>
                    </div>
                    <div class="valign-wrapper">
                        <i class="material-icons left">thumb_up</i>
                        <p>
                            <b>Calif??caci??n de contenido.</b>
                            Cuando quieres compartir tu opini??n sobre alg??n
                            libro de la biblioteca, puedes calificarlo sobre 5
                            estrellas y adem??s escribir tu opini??n o cr??tica
                            sobre el mismo.
                        </p>
                    </div>
                    <div class="valign-wrapper">
                        <i class="material-icons left">star</i>
                        <p>
                            <b
                                >No pierdas tus libros preferidos,
                                ??gu??rdalos!.</b
                            >
                            Al crearte tu perfil, se te concede un espacio
                            llamado "Mi espacio", donde se almacenar??n los libros
                            que agregues como favoritos.
                        </p>
                    </div>

                    <div class="valign-wrapper">
                        <i class="material-icons left">library_add</i>
                        <p>
                            <b>Aporta un libro de interes com??n al sistema.</b>
                            Si deseas colaborar con el sistema cargando libros
                            en el, comun??cate con nosotros y te daremos los
                            permisos para realizar esta acci??n.
                        </p>
                    </div>

                    <a
                        href="mc-views/repositorio.php"
                        class="btn-flat waves-effect waves-light white-text"
                    >
                        ir al repositorio
                    </a>
                </div>
            </div>
        </section>

        <section id="s_colaborador" class="section">
            <div class="row black_card valign-wrapper">
                <div class="col s12 l6 center-align">
                    <div class="container">
                        <h4 class="teal-text"><b>??C??mo ser colaborador?</b></h4>
                        <p>Para convertirse en colaborador del sistema necesita que le sean concedidos permisos espec??ficos, debe justificar su petici??n, as?? como tambi??n, indicar que tipo de contenido desea cargar al sistema.</p>
                        <button class="btn-fantasma" id="btnSolicitar">Solicitar permisos</button>
                    </div>
                </div>
                <div class="col s12 l6 center-align hide-on-med-and-down">
                    <img src="assets/images/SVG/colaboradorTeal.svg" alt="" width="80%" />
                </div>
            </div>
        </section>

        <!-- seccion de registrate -->
        <section id="s_invitacion" class="section" style="background: #004a4d;">
            <div class="row center">

                <?php
                    if (!isset($_SESSION['user_name'])) {
                ?>
                    <div class="col s12 m12 l8">
                        <p>??Mejora tu experiencia en el sistema uni??ndote!</p>
                    </div>
                    <div class="col s6 m6 l2">
                        <a
                            href="mc-views/login.php"
                            class="btn-flat waves waves-effect waves-light white-text"
                            id="btn_login"
                            ><i class="material-icons left">login</i>Ingresar</a
                        >
                    </div>
                    <div class="col s6 m6 l2">
                        <a
                            href="mc-views/login.php?mode=2"
                            class="btn-flat waves waves-effect waves-light white-text"
                            id="btn_register"
                            ><i class="material-icons left">person_add</i
                            >Registrarse</a
                        >
                    </div>
                <?php
                    }else{ 
                ?>   
                    <div class="col s12 m12 l8">
                        <p>??Disfruta del contenido disponible!</p>
                    </div>

                    <div class="col s6 m6 l2">
                        <a
                            href="mc-views/repositorio.php"
                            class="btn-flat waves waves-effect waves-light white-text"
                            ><i class="material-icons left">book</i
                            >ir al repositorio</a
                        >
                    </div>
                <?php } ?>


            </div>
        </section>

        <!-- parallax con mensaje -->
        <div class="parallax-container">
            <div class="parallax">
                <img
                    src="assets/images/fondos/matteo-maretto-i75SxrzXABg-unsplash.jpg"
                    alt=""
                    class="responsive-img"
                />
            </div>
            <div class="center">
                <i>"Carecer de libros propios es el colmo de la miseria".</i>
                <p>Benjamin Franklin.</p>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="page-footer" style="background: #004a4d;">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">??Gracias!</h5>
                        <p class="grey-text text-lighten-4">
                            Comparte el sitio con tus amigos y puedan usar el
                            nuevo repositorio del IUJO Barquisimeto.
                        </p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">Links</h5>
                        <ul>
                            <li>
                                <a
                                    class="grey-text text-lighten-3"
                                    href="#header"
                                    >Ir arriba</a
                                >
                            </li>
                            <li>
                                <a class="grey-text text-lighten-3" href="#!"
                                    >P??gina del iujo</a
                                >
                            </li>
                            <li>
                                <a class="grey-text text-lighten-3" href="#!"
                                    >Facebook</a
                                >
                            </li>
                            <li>
                                <a class="grey-text text-lighten-3" href="#!"
                                    >Instagram</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright cyan darken-4">
                <div class="container">
                    ?? <?php echo date("Y"); ?>  Copyright IujoRepositorio.com
                    <!-- <a class="grey-text text-lighten-4 right" href="#!">More Links</a> -->
                </div>
            </div>
        </footer>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="assets/librerias/js/materialize.min.js"></script>
        <script type="text/javascript" src="assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="assets/js/index.js"></script>
    </body>
</html>
