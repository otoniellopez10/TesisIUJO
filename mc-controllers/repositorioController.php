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

if( $mode == "getAutores"){
    
    $autores = $ObjAutor->getAll2();
    $response = [];

    while($row = mysqli_fetch_object($autores)){
        $key = $row->nombre;
        $value = $row->id;
        $response[$key] = null;
    }

    echo json_encode($response);


}