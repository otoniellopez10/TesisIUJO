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
    <head> </head>
    <body>
        <div class="container" id="modulo">
            <h1>USUARIOS</h1>
        </div>

        <script type="text/javascript" src="assets/js/repositorio_.js"></script>
    </body>
</html>
