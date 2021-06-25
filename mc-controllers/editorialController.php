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
    if ( !isset($_POST['editorial']) ) {
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    }else{
        $editorial = $_POST['editorial'];
        
        $id_editorial = $ObjEditorial->save($editorial); //agregar editorial
    
        if($id_editorial){
            $response = ['error' => false, 'message' => 'La editorial fue registrada con éxito', "editorial_id" => $id_editorial];
        }else{
            $response = ['error' => true, 'message' => 'Ocurrió un error al registrar la editorial'];
        }

    }

    echo json_encode($response);


}