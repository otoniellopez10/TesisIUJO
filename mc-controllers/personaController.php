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


}else if($mode == "getOne"){
    if ( !isset($_POST['id']) ){
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $id = $_POST['id'];

        $consulta = $objPersona->getOne($id);
        if ($consulta === false) {
            $response = ['error' => true, 'message' => 'Ocurrió un error al tratar de ver los detalles del usuario'];
        } else {
            $response = $consulta;
        }
    }
    echo json_encode($response);


}else if($mode == "getOneByUsuarioId"){
    if ( !isset($_POST['usuario_id']) ){
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $usuario_id = $_POST['usuario_id'];

        $consulta = $objPersona->getOneByUsuarioId($usuario_id);
        if ($consulta === false) {
            $response = ['error' => true, 'message' => 'Ocurrió un error al tratar de ver los detalles del usuario'];
        } else {
            $response = $consulta;
        }
    }
    echo json_encode($response);


}else if($mode == "desactivar"){
    if ( !isset($_POST['usuario_id']) ){
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $usuario_id = $_POST['usuario_id'];

        $consulta = $objPersona->desactivar($usuario_id);
        if ($consulta === false) {
            $response = ['error' => true, 'message' => 'Ocurrió un error al tratar de desactivar al usuario'];
        } else {
            $response = ['error' => false, 'message' => 'El usuario ha sido desactivado con éxito'];
        }
    }
    echo json_encode($response);


}else if($mode == "activar"){

    if ( !isset($_POST['usuario_id']) ){
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $usuario_id = $_POST['usuario_id'];

        $consulta = $objPersona->activar($usuario_id);
        if ($consulta === false) {
            $response = ['error' => true, 'message' => 'Ocurrió un error al tratar de activar al usuario'];
        } else {
            $response = ['error' => false, 'message' => 'El usuario ha sido activado con éxito'];
        }
    }

    echo json_encode($response);


}else if($mode = "cambiarRol"){
    if ( !isset($_POST['usuario_id']) || !isset($_POST['editarRolSelect'])){
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $usuario_id = $_POST['usuario_id'];
        $rol_id = $_POST['editarRolSelect'];

        $consulta = $objPersona->cambiarRol($usuario_id, $rol_id);
        if ($consulta === false) {
            $response = ['error' => true, 'message' => 'Ocurrió un error al tratar de actualizar el usuario'];
        } else {
            $response = ['error' => false, 'message' => 'El usuario ha sido actualizado con éxito'];
        }
    }

    echo json_encode($response);
}