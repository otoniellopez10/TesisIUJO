<?php

include_once 'Config.php';
$db = Db::getInstance();

class Editorial {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "libro_editorial";
        $this->tableLibro = "libro";
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE estatus = 1 ORDER BY nombre ASC";
        return $db->get_results($sql);
    }

    public function save($editorial) {
        global $db;
        $data = array('nombre' => $editorial);

        return  $db->insert($this->table, $data);
    }

    public function update($editorial_id, $editorial_nombre){
        global $db;
        $data = array('nombre' => $editorial_nombre);
        $where = array("id" => $editorial_id);
        return  $db->update($this->table, $data, $where);
    }

    public function getLibrosByEditorial($editorial_id){
        global $db;
        $sql = "SELECT
                COUNT(editorial) as cantidad
                FROM $this->tableLibro
                WHERE editorial = $editorial_id";
        return $db->get_row($sql);
    }

    public function delete($editorial_id){
        global $db;
        $where = array("id" => $editorial_id);
        return  $db->delete($this->table, $where);
    }

}
