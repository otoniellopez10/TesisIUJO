<?php

include_once 'Config.php';
$db = Db::getInstance();

class Carrera {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "libro_carrera";
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE estatus = 1";
        return $db->get_results($sql);
    }

    public function save($carrera) {
        global $db;
        $data = array('nombre' => $carrera);

        return  $db->insert($this->table, $data);
    }

}