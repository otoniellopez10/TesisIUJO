<?php

include_once '../mc-models/Config.php';

$db = Db::getInstance();

class Libro {

    private $table;

    public function __construct() {
        $this->table = "libro";
    }

    public function getAll() {
        global $db;
        return $db->get_results("SELECT * FROM $this->table WHERE estatus = 1 ORDER BY nombre");
    }

    public function save($titulo, $editorial_id, $edicion, $fecha, $categoria_id, $materia_id, $descripcion, $pdf){
        global $db;

        $codPDF = $this->guardarPDF($pdf);

        $data = array(
            'titulo' => $titulo,
            'editorial' => $editorial_id,
            'edicion' => $edicion,
            'fecha' => $fecha,
            'categoria' => $categoria_id,
            'materia' => $materia_id,
            'descripcion' => $descripcion,
            'pdf' => $codPDF
        );

        return  $db->insert($this->table, $data);
        
    }

    private function guardarPDF($pdf){
        global $db; 

        $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        $cad = substr( str_shuffle( $charset ), 0, 20 );

        $codPDF = $cad.$pdf["name"];
        $codPDF = basename($codPDF);
        $ruta = "../assets/pdfs";

        $sql = "SELECT * 
        FROM $this->table 
        WHERE pdf = '$codPDF'";

        if($db->get_row($sql)){
            $this->guardarPDF($pdf);
        }

        if (move_uploaded_file($pdf['tmp_name'],  "$ruta/$codPDF")){
            return $codPDF;
        }else{
            return false;
        }

        
    }

}