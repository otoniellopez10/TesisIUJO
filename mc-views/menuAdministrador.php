<?php 
$acceso = array(1); //1 para administrador, 2 para colaborador y 3 para persona comun
$user = $_SESSION["user"];
$user_id = $user->rol_id;
if (!in_array($user_id, $acceso)) {
    header('Location: error.php');
    die();
}
?>

<header>
            <!-- <nav>navbar content here</nav> -->

            <ul id="slide-out" class="sidenav sidenav-fixed" >
                <li class="primero">
                    <div class="user-view">
                        <div class="background">
                            <img
                                src="../assets/images/fondos/fondo-principal.jpg"
                                class="responsive-img"
                            />
                        </div>
                        <a href="#user"
                            ><img
                                class="circle"
                                src="../assets/images/avatars/muneco-02.png"
                        /></a>
                        <a href="#name"
                            ><span class="white-text name"
                                >Administrador</span
                            ></a
                        >
                        <a href="#email"
                            ><span class="white-text email"
                                ><?php echo $user->email ?></span
                            ></a
                        >
                    </div>
                </li>
                <div class="divider grey darken-3"></div>
                <li>
                    <a href="../index.php" class="waves-effect"
                        ><i class="material-icons white-text">home</i>Página principal</a
                    >
                </li>
                <li>
                    <a
                        href="panel_admin.php"
                        class="waves-effect a_menu"
                        ><i class="material-icons white-text">dashboard</i>Panel administrativo</a
                    >
                </li>
                
                <li>
                    <a
                        href="panel_editoriales.php"
                        class="waves-effect a_menu"
                        ><i class="material-icons white-text">book</i>Editoriales</a
                    >
                </li>

                <li>
                    <a
                        href="panel_usuarios.php"
                        class="waves-effect a_menu"
                        ><i class="material-icons white-text">person_pin</i>Usuarios</a
                    >
                </li>

                <li>
                    <a
                        href="panel_reportes.php"
                        class="waves-effect a_menu"
                        ><i class="material-icons white-text">settings</i>Reportes</a
                    >
                </li>

                <li>
                    <a
                        href="panel_bitacora.php"
                        class="waves-effect a_menu"
                        ><i class="material-icons white-text">description</i>Bitacora</a
                    >
                </li>


                <!-- configuracion -->
                <!-- <li>
                    <a href="#!" class="waves-effect a_menu"
                        ><i class="material-icons white-text">settings</i
                        >Configuración</a
                    >
                </li> -->
                <li>
                    <a href="logout.php" class="waves-effect" id="btn_desconectar"
                        ><i class="material-icons white-text">exit_to_app</i>
                        Salir del sistema</a
                    >
                </li>
            </ul>

            <!-- MENU PARA DISPOSITIVOS PEQUEÑOS -->
            <div class="navbar-fixed hide-on-large-only">
                <nav class="blue-grey darken-3 z-depth-0">
                    <div class="nav-wrapper">
                        <a href="#!" class="brand-logo center">
                            <img
                                src="../assets/images/iconos/book-default.png"
                                alt=""
                                width="40px"
                                style="transform: translateY(20%)"
                            />
                            IUJO
                        </a>
                        <a
                            href="#"
                            data-target="slide-out"
                            class="sidenav-trigger"
                            ><i class="material-icons">menu</i></a
                        >
                    </div>
                </nav>
            </div>
        </header>