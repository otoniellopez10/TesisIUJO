<?php

include_once 'Config.php';
$db = Db::getInstance();

class Editorial {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "libro_editorial";
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

}
