<?php
session_start();

include "../mc-models/Libro.php";
include "../mc-models/Editorial.php";
include "../mc-models/Carrera.php";
include "../mc-models/Categoria.php";
include "../mc-models/Autor.php";

$mode = $_REQUEST["mode"];

$ObjLibro = new Libro();
$ObjEditorial = new Editorial();
$ObjCarrera = new Carrera();
$ObjCategoria = new Categoria();
$ObjAutor = new Autor();


if( $mode == "insert"){
    if (
        !isset($_POST['titulo']) ||
        
        !isset($_POST['autores']) ||
        !isset($_POST['editorial']) ||
        !isset($_POST['edicion']) ||
        !isset($_POST['fecha']) ||
        !isset($_POST['carrera']) ||
        !isset($_POST['categoria']) ||
        !isset($_POST['resumen']) ||
        !isset($_FILES['pdf'])
    ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $titulo = $_POST['titulo'];
        $autores = $_POST['autores']; //crea un array de los autores
        $editorial = format($_POST['editorial']);
        $edicion = format($_POST['edicion']);
        $fecha = $_POST['fecha'];
        $carrera = format($_POST['carrera']);
        $categoria = format($_POST['categoria']);
        $resumen = $_POST['resumen'];
        $pdf = $_FILES['pdf'];

        
        $libro_id = $ObjLibro->save($titulo, $editorial, $edicion, $fecha, $carrera, $categoria, $resumen, $pdf); //insertar el libro y sus datos
        
        $id_autor = $ObjAutor->save($autores, $libro_id); //agregar los autores
    
        if($id_autor && $libro_id){
            $response = ['error' => false, 'message' => 'El libro fue registrado con éxito'];
        }else{
            $response = ['error' => true, 'message' => 'Ocurrió un error al guardar el libro'];
        }

    }

    echo json_encode($response);


}else if($mode == "update"){

    if (
        !isset($_POST['id']) ||
        !isset($_POST['modal_e_titulo']) ||
        !isset($_POST['modal_e_editorial']) ||
        !isset($_POST['modal_e_edicion']) ||
        !isset($_POST['modal_e_fecha']) ||
        !isset($_POST['modal_e_carrera']) ||
        !isset($_POST['modal_e_categoria']) ||
        !isset($_POST['modal_e_resumen'])
    ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $id = $_POST['id'];
        $titulo = $_POST['modal_e_titulo'];
        $editorial = format($_POST['modal_e_editorial']);
        $edicion = format($_POST['modal_e_edicion']);
        $fecha = $_POST['modal_e_fecha'];
        $carrera = format($_POST['modal_e_carrera']);
        $categoria = format($_POST['modal_e_categoria']);
        $resumen = $_POST['modal_e_resumen'];
        
        $libro_id = $ObjLibro->update($id, $titulo, $editorial, $edicion, $fecha, $carrera, $categoria, $resumen); //insertar el libro y sus datos
        
    
        if($libro_id){
            $response = ['error' => false, 'message' => 'El libro fue actualizado con éxito'];
        }else{
            $response = ['error' => true, 'message' => 'Ocurrió un error al actualizar el libro'];
        }
    }

    echo json_encode($response);



}else if($mode == "getOneById"){
    if( !isset( $_POST['id'] ))
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $id = $_POST['id'];
        $response = ["libro" => $ObjLibro->getOneById($id),"autores" => $ObjAutor->getByLibroId($id)];
    }
    echo json_encode($response);


}else if ($mode = "desactivarLibro"){
    if( !isset( $_POST['id'] ))
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $id = $_POST['id'];
        $request = $ObjLibro->desactivarLibro($id);
        if($request){
            $response = ['error' => false, 'message' => 'El libro se desactivó con éxito'];
        }
    }
    echo json_encode($response);
}



function format($cadena){
    $nuevo = strtolower($cadena);
    $nuevo = ucfirst($nuevo);
    return $nuevo;
}