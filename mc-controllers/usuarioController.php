<?php

session_start();

include "../mc-models/Usuario.php";
include_once "../mc-models/Persona.php";

$mode = $_REQUEST['mode'];

$objUsuario = new Usuario();

$response = [];

if ($mode == "insert") {
    if (!isset($_POST['email']) ||
        !isset($_POST['password'])) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $usuario = $objUsuario->getOneByEmail($email);
        if ($usuario !== null) {
            $entidad = false;
            switch (intval($usuario->rol_id)) {
                case 2: // Usuario colaborador
                    $objEntidad = new Persona();
                    $entidad = $objEntidad->getOneByUsuarioId($usuario->id);
                    break;
                case 3: // Usuario comun
                    $objEntidad = new Persona();
                    $entidad = $objEntidad->getOneByUsuarioId($usuario->id);
                    break;
            }
            if (in_array($usuario->estatus, [0, 1]) && ($usuario->rol_id == 1 || $entidad !== false)) {
                $response = ['error' => true, 'message' => "El correo $email ya está registrado"];
            } 
            
        } else {
            $id = $objUsuario->save($email, password_hash($password, PASSWORD_DEFAULT), Usuario::ROL_COLABORADOR);
            if ($id === false) {
                $response = ['error' => true, 'message' => "Ocurrió un problema al registrar el usuario"];
            } else {
                $response = ['message' => "El usuario $email fue registrado exitosamente.", "id" => $id];
            }
        }
    }
    echo json_encode($response);
}