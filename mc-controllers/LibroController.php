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


}else if ($mode == "desactivarLibro"){
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


}else if ($mode == "activarLibro"){
    if( !isset( $_POST['id'] ))
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $id = $_POST['id'];
        $request = $ObjLibro->activarLibro($id);
        if($request){
            $response = ['error' => false, 'message' => 'El libro se activó con éxito'];
        }
    }
    echo json_encode($response);



}else if($mode == "search"){
    if( !isset( $_POST['b_titulo_libro'] ) || !isset( $_POST['b_limite_libro'] ) || !isset( $_POST['estatus'] ))
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $titulo = $_POST['b_titulo_libro'];
        $limit = $_POST['b_limite_libro'];
        $estatus = $_POST['estatus'];

        $request = $ObjLibro->search($titulo, $limit, $estatus);
        $count = count($request);
        if($count > 0){
            $response = $request;
        }else if($count == 0){
            $response = ['error' => true, 'message' => 'No se encontró ningún libro con ese título.'];
        }
        else{
            $response = ['error' => true, 'message' => 'Error al filtrar los datos'];
        }
    }
    echo json_encode($response);


    
}else if($mode == "searchConFiltro"){

    if( !isset( $_POST['b_titulo'] ) || 
    !isset( $_POST['b_autor'] ) || 
    !isset( $_POST['b_editorial'] ) || 
    !isset( $_POST['b_categoria'] ) || 
    !isset( $_POST['b_carrera'] )
    )
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $titulo = $_POST['b_titulo'];
        $autor = $_POST['b_autor'];
        $editorial = $_POST['b_editorial'];
        $categoria = $_POST['b_categoria'];
        $carrera = $_POST['b_carrera'];
        $limit = 50;

        $where = "l.estatus = 1";
        $order = " ORDER BY l.titulo DESC ";

        if($titulo != "") $where = $where . " AND l.titulo LIKE '%$titulo%'";
        if($editorial != "") $where = $where . " AND l.editorial = $editorial";
        if($categoria != "") $where = $where . " AND l.categoria = $categoria";
        if($carrera != "") $where = $where . " AND l.carrera = $carrera";
        if($autor != ""){

        }

        $request = $ObjLibro->searchConFiltro($where, $order, $limit = 50);
        if($request){
            $array = array();
            foreach ($request as $key => $libro) {
                $temp_array;

                $temp_array["libro"] = $libro;

                $allAutores = $ObjAutor->getByLibroId($libro->id);
                $count = count($allAutores);
                $autores = "";

                foreach($allAutores as $key => $autor){
                    $index = $key + 1;
                    
                    $autores = $autores . $autor->nombre;
                    if( ( $count - $index) > 1){
                        $autores = $autores . ", ";
                    }else if(( $count - $index) == 1){
                        $autores = $autores . " y ";
                    }
                }
                $temp_array["autores"] = $autores;

                // clasificacion (estrellas)
                $calificacion = $ObjLibro->getCalificacionByLibroId($libro->id);
                $x = "";

                $promedio = $calificacion->cantidad;
                if($promedio != null){
                    for ($i=0; $i < 5; $i++) { 
                        if($promedio >= 1) $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star</i>";

                        else if($promedio > 0 && $promedio < 1) $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star_half</i>";

                        else $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star_border</i>";
                        $promedio = $promedio - 1;
                    }
                }else{
                    $x = "Sin calificación";
                }
                $temp_array["calificacion"] = $x;

                // añadir el libro al array con todos los datos.
                array_push($array, $temp_array);
            }
            $response = $array;
        } 
            
        else $response = ["error" => true, "message" => "No se ha encontrado ningun libro con estos filtros."];
    }


    echo json_encode($response);


}else if( $mode == "getAutores"){
    
    $autores = $ObjAutor->getAll2();
    $response = [];

    while($row = mysqli_fetch_object($autores)){
        $key = $row->nombre;
        $value = $row->id;
        $response[$key] = null;
    }

    echo json_encode($response);


}else if($mode == "getComentarioByUsuarioId"){
    if($_SESSION["user"]->rol_id == 1){
        $response = ['error' => true, 'message' => 'El administrador no puede calificar libros'];
    }else if( !isset( $_POST['libro_id'] ))
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $libro_id = $_POST['libro_id'];
        $usuario_id = $_SESSION['user']->id;

        $request = $ObjLibro->getComentarioByUsuarioId($usuario_id, $libro_id);
        if($request == null){
            $response = ['error' => false, 'estatus' => 1]; //estatus 1 para indicar que el llibro no ha sido calificado por dicho usuario
        }else{
            $response = ['error' => false, 'estatus' => 2, "comentario" => $request]; //estatus 2 para indicar que si ha sido calificado
        }
    }

    echo json_encode($response);

}else if($mode == "setComentario"){

    if( !isset( $_POST['libro_id'] ) || !isset( $_POST['numeroEstrellas']) || !isset( $_POST['modalCalificarComentario']) || !isset( $_SESSION['user']->id ))
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $libro_id = $_POST['libro_id'];
        $estrellas = $_POST['numeroEstrellas'];
        $comentario = $_POST['modalCalificarComentario'];
        $usuario_id = $_SESSION['user']->id;

        $request = $ObjLibro->setComentario($usuario_id, $libro_id, $estrellas, $comentario);
        if(!$request){
            $response = ['error' => true, 'message' => "Ocurrió un error al publicar el comentario"];
        }else{
            $response = ['error' => false, 'message' => "Su comentario ha sido publicado con éxito!"];
        }
    }

    echo json_encode($response);

}else if($mode == "deleteComentario"){
    if( !isset( $_POST['libro_id'] ) || !isset( $_SESSION['user']->id ) )
        $response = ['error' => true, 'message' => 'Faltan datos por ser suministrados'];
    else{
        $libro_id = $_POST['libro_id'];
        $usuario_id = $_SESSION['user']->id;

        $request = $ObjLibro->deleteComentario($usuario_id, $libro_id);
        if(!$request){
            $response = ['error' => true, 'message' => "Ocurrió un error al eliminar el comentario"];
        }else{
            $response = ['error' => false, 'message' => "Su comentario ha sido eliminado con éxito!"];
        }
    }

    echo json_encode($response);


// INICIO DE LOS REPORTES DE LIBROS
}else if( $mode == "getMasVistos"){
    if( !isset( $_POST['limite'] ) )
        $response = ['error' => true, 'message' => 'Indique el limite de consulta'];
    else{
        $limite = $_POST['limite'];

        $request = $ObjLibro->getMasVistos($limite);
        if(count($request) == 0){
            $response = ['error' => true, 'message' => 'Ningún libro ha sido visto'];
        }else{
            $response = $request;
        }
    }

    echo json_encode($response);

}else if( $mode == "getMasDescargados"){
    if( !isset( $_POST['limite'] ) )
        $response = ['error' => true, 'message' => 'Indique el limite de consulta'];
    else{
        $limite = $_POST['limite'];

        $request = $ObjLibro->getMasDescargados($limite);
        if(count($request) == 0){
            $response = ['error' => true, 'message' => 'Ningún libro ha sido descargado'];
        }else{
            $response = $request;
        }
    }

    echo json_encode($response);


}else if( $mode == "getMejorCalificados"){
    if( !isset( $_POST['limite'] ) )
        $response = ['error' => true, 'message' => 'Indique el limite de consulta'];
    else{
        $limite = $_POST['limite'];

        $request = $ObjLibro->getMejorCalificados($limite);
        if(count($request) == 0){
            $response = ['error' => true, 'message' => 'Ningún libro ha sido calificado'];
        }else{
            $response = $request;
        }
    }

    echo json_encode($response);

}else if( $mode == "getReporteLibros"){
    if( !isset( $_POST['limite'] ) )
        $response = ['error' => true, 'message' => 'Indique el limite de consulta'];
    else{
        $limite = $_POST['limite'];

        $response = $ObjLibro->getReporteLibros($limite);
    }

    echo json_encode($response);
}


function format($cadena){
    $nuevo = strtolower($cadena);
    $nuevo = ucfirst($nuevo);
    return $nuevo;
}