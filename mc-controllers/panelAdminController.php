<?php
session_start();

include "../mc-models/Libro.php";
include "../mc-models/Editorial.php";
include "../mc-models/Categoria.php";
include "../mc-models/Materia.php";
include "../mc-models/Autor.php";

$mode = $_REQUEST["mode"];

$ObjLibro = new Libro();
$ObjEditorial = new Editorial();
$ObjCategoria = new Categoria();
$ObjMateria = new Materia();
$ObjAutor = new Autor();


if( $mode == "insert"){
    if (
        !isset($_POST['titulo']) ||
        
        !isset($_POST['autores']) ||
        !isset($_POST['editorial']) ||
        !isset($_POST['edicion']) ||
        !isset($_POST['fecha']) ||
        !isset($_POST['categoria']) ||
        !isset($_POST['materia']) ||
        !isset($_POST['descripcion']) ||
        !isset($_FILES['pdf'])
    ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $titulo = $_POST['titulo'];
        $autores = $_POST['autores']; //crea un array de los autores
        $editorial = format($_POST['editorial']);
        $edicion = format($_POST['edicion']);
        $fecha = $_POST['fecha'];
        $categoria = format($_POST['categoria']);
        $materia = format($_POST['materia']);
        $descripcion = $_POST['descripcion'];
        $pdf = $_FILES['pdf'];

        $editorial_id = $ObjEditorial->save($editorial); //Insertar la editorial
        $categoria_id = $ObjCategoria->save($categoria); // insertar la categoria
        $materia_id = $ObjMateria->save($materia); // insertar la materia
        
        $libro_id = $ObjLibro->save($titulo, $editorial_id, $edicion, $fecha, $categoria_id, $materia_id, $descripcion, $pdf); //insertar el libro y sus datos
        
        $id_autor = $ObjAutor->save($autores, $libro_id); //agregar los autores
    
        if($editorial_id && $categoria_id && $materia_id && $libro_id){
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
        !isset($_POST['modal_e_categoria']) ||
        !isset($_POST['modal_e_materia']) ||
        !isset($_POST['modal_e_descripcion'])
    ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $id = $_POST['id'];
        $titulo = $_POST['modal_e_titulo'];
        $editorial = format($_POST['modal_e_editorial']);
        $edicion = format($_POST['modal_e_edicion']);
        $fecha = $_POST['modal_e_fecha'];
        $categoria = format($_POST['modal_e_categoria']);
        $materia = format($_POST['modal_e_materia']);
        $descripcion = $_POST['modal_e_descripcion'];

        $editorial_id = $ObjEditorial->save($editorial); //Insertar la editorial
        $categoria_id = $ObjCategoria->save($categoria); // insertar la categoria
        $materia_id = $ObjMateria->save($materia); // insertar la materia
        
        $libro_id = $ObjLibro->update($id, $titulo, $editorial_id, $edicion, $fecha, $categoria_id, $materia_id, $descripcion); //insertar el libro y sus datos
        
    
        if($editorial_id && $categoria_id && $materia_id && $libro_id){
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