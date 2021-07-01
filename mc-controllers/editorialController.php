<?php
session_start();

// include "../mc-models/Libro.php";
include "../mc-models/Editorial.php";
// include "../mc-models/Carrera.php";
// include "../mc-models/Categoria.php";
// include "../mc-models/Autor.php";

$mode = $_REQUEST["mode"];

// $ObjLibro = new Libro();
$ObjEditorial = new Editorial();
// $ObjCarrera = new Carrera();
// $ObjCategoria = new Categoria();
// $ObjAutor = new Autor();


if( $mode == "insert"){
    if ( !isset($_POST['editorial_nombre']) ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $editorial = $_POST['editorial_nombre'];
        
        $id_editorial = $ObjEditorial->save($editorial); //agregar editorial
    
        if($id_editorial){
            $response = ['error' => false, 'message' => 'La editorial fue registrada con éxito', "editorial_id" => $id_editorial];
        }else{
            $response = ['error' => true, 'message' => 'Ocurrió un error al registrar la editorial'];
        }

    }

    echo json_encode($response);


}else if($mode == "update"){
    if ( !isset($_POST['editar_editorial_nombre']) || !isset($_POST['editorial_id'])) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $editorial_id = $_POST['editorial_id'];
        $editorial_nombre = $_POST['editar_editorial_nombre'];
        
        $request = $ObjEditorial->update($editorial_id, $editorial_nombre); //agregar editorial
    
        if($request){
            $response = ['error' => false, 'message' => 'La editorial fue actualizada con éxito!'];
        }else{
            $response = ['error' => true, 'message' => 'Ocurrió un error al registrar la editorial'];
        }

    }

    echo json_encode($response);

}else if($mode == "delete"){
    if ( !isset($_POST['editorial_id']) ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $editorial_id = $_POST['editorial_id'];

        $count = $ObjEditorial->getLibrosByEditorial($editorial_id)->cantidad;

        if($count > 0){
            if($count == 1){
                $message = "La editorial no puede ser eliminada porque esta relacionada con ". $count. " libro";
            }else{
                $message = "La editorial no puede ser eliminada porque esta relacionada con ". $count. " libros";
            }
            $response = ['error' => true, 'message' => $message];
        }else{
            $request = $ObjEditorial->delete($editorial_id); //editar editorial
    
            if($request){
                $response = ['error' => false, 'message' => 'La editorial fue eliminada con éxito!'];
            }else{
                $response = ['error' => true, 'message' => 'Ocurrió un error al elimionar la editorial'];
            }
        }

    }

    echo json_encode($response);
}