<?php

include_once "../mc-models/Login.php";
include_once "../mc-models/Persona.php";
include_once "../mc-models/usuario.php";

session_start();

$mode = $_REQUEST['mode'];
$objLogin = new Login();
$objUsuario = new Usuario();

if ($mode == "loadOne") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $objLogin->getOneEmail($email);
    $dataJson = ["usuario" => false, "mensaje" => "Error"];
    if ($result === false) {
        $dataJson = ["usuario" => null, "mensaje" => "Email no registrado"];
    } else {
        if (password_verify($password, $result->password)) {
            $dataJson = ["usuario" => true, "mensaje" => "Iniciando sesión"];
            unset($result->password);
            $_SESSION['user'] = $result;
            if (intval($result->rol_id) == 1) {
                $_SESSION['user']->menu = "menuAdministrador.php";
            }elseif(intval($result->rol_id) == 2){
                $_SESSION['user']->menu = "menuColaborador.php";
            }elseif(intval($result->rol_id) == 3){
                $_SESSION['user']->menu = "menuPersona.php";
            } 

            $objEntidad = new Persona();
            $entidad = $objEntidad->getOneByUsuarioId($result->id);
            $_SESSION['user']->persona = $objUsuario->formatEntidadNoParticipante($entidad);
            $_SESSION['user_name'] = $email;

        } else {
            $dataJson = ["usuario" => false, "mensaje" => "Usuario o contraseña incorrectos"];
        }
    }
    echo json_encode($dataJson);
}
elseif ($mode == "logout") {
    session_destroy();
}