<?php

include_once '../mc-models/Config.php';

$db = Db::getInstance();

class Libro {

    private $table;

    public function __construct() {
        $this->table = "libro";
        $this->tableEditorial = "libro_editorial";
        $this->tableCarrera = "libro_carrera";
        $this->tableCategoria = "libro_categoria";
    }

    public function getAll() {
        global $db;
        $sql = "SELECT 
                    l.id,
                    l.titulo,
                    l.edicion,
                    l.fecha,
                    l.resumen,
                    l.pdf,
                    e.nombre AS editorial,
                    c.nombre AS carrera,
                    t.nombre AS categoria
                FROM $this->table l
                JOIN $this->tableEditorial e on e.id = l.editorial
                JOIN $this->tableCarrera c on c.id = l.carrera
                JOIN $this->tableCategoria t on t.id = l.categoria
                WHERE l.estatus = 1";
        return $db->get_results($sql);
    }

    public function getAll2() {
        global $db;
        $sql = "SELECT 
                    l.id,
                    l.titulo,
                    l.edicion,
                    l.fecha,
                    l.resumen,
                    l.pdf,
                    e.nombre AS editorial,
                    c.nombre AS carrera,
                    t.nombre AS categoria
                FROM $this->table l
                JOIN $this->tableEditorial e on e.id = l.editorial
                JOIN $this->tableCarrera c on c.id = l.carrera
                JOIN $this->tableCategoria t on t.id = l.categoria";
        return $db->get_results($sql);
    }

    public function getAllDesactivados() {
        global $db;
        $sql = "SELECT 
                    l.id,
                    l.titulo,
                    l.edicion,
                    l.fecha,
                    l.resumen,
                    l.pdf,
                    e.nombre AS editorial,
                    c.nombre AS carrera,
                    t.nombre AS categoria
                FROM $this->table l
                JOIN $this->tableEditorial e on e.id = l.editorial
                JOIN $this->tableCarrera c on c.id = l.carrera
                JOIN $this->tableCategoria t on t.id = l.categoria
                WHERE l.estatus = 0";
        return $db->get_results($sql);
    }

    public function getOneById($id) {
        global $db;
        $sql = "SELECT 
                    l.id,
                    l.titulo,
                    l.edicion,
                    l.fecha,
                    l.resumen,
                    l.pdf,
                    e.nombre AS editorial,
                    c.nombre AS carrera,
                    t.nombre AS categoria
                FROM $this->table l
                JOIN $this->tableEditorial e on e.id = l.editorial
                JOIN $this->tableCarrera c on c.id = l.carrera
                JOIN $this->tableCategoria t on t.id = l.categoria
                WHERE l.estatus = 1 AND l.id = $id";
        return $db->get_row($sql);
    }

    public function save($titulo, $editorial_id, $edicion, $fecha, $carrera_id, $categoria_id, $resumen, $pdf){
        global $db;

        $codPDF = $this->guardarPDF($pdf);

        $data = array(
            'titulo' => $titulo,
            'editorial' => $editorial_id,
            'edicion' => $edicion,
            'fecha' => $fecha,
            'carrera' => $carrera_id,
            'categoria' => $categoria_id,
            'resumen' => $resumen,
            'pdf' => $codPDF
        );

        return  $db->insert($this->table, $data);
        
    }


    public function update($id, $titulo, $editorial_id, $edicion, $fecha, $carrera_id, $categoria_id, $resumen){
        global $db;
        
        $data = array(
            'titulo' => $titulo,
            'editorial' => $editorial_id,
            'edicion' => $edicion,
            'fecha' => $fecha,
            'carrera' => $carrera_id,
            'categoria' => $categoria_id,
            'resumen' => $resumen
        );
        $where = array("id" => $id);

        return  $db->update($this->table, $data, $where);
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

    public function desactivarLibro($id){
        global $db;

        $data = array(
            'estatus' => 0
        );

        $where = array("id" => $id);
        return  $db->update($this->table, $data, $where);
    }

    public function activarLibro($id){
        global $db;

        $data = array(
            'estatus' => 1
        );

        $where = array("id" => $id);
        return  $db->update($this->table, $data, $where);
    }

}