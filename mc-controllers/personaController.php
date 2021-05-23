<?php

session_start();

include_once '../mc-models/Persona.php';
// include_once '../mc-models/Usuario.php';

$mode = $_REQUEST['mode'];
$objPersona = new Persona();
// $objUsuario = new Usuario();

$response = [];

$user = $_SESSION['user'] ?? null;

if($mode == "insert"){
    if (!isset($_POST['cedula']) ||
        !isset($_POST['nombre']) ||
        !isset($_POST['apellido']) ||
        !isset($_POST['telefono']) ||
        !isset($_POST['persona_tipo']) ||
        !isset($_POST['usuario_id'])) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'] ?? Db::getInstance()::_NULL;
        $persona_tipo = $_POST['persona_tipo'];
        $usuario_id = $_POST['usuario_id'];

        $id = $objPersona->save($cedula, $nombre, $apellido, $telefono, $persona_tipo, $usuario_id);
        if ($id === false) {
            $response = ['error' => true, 'message' => 'Ocurrió un problema al tratar de registrar la persona'];
        } else {
            $response = ['message' => "El Usuario $nombre $apellido fue registrado exitosamente", 'id' => $id];
        }
    }

    echo json_encode($response);
}