<?php

include_once 'Config.php';
$db = Db::getInstance();

class Rol {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "usuario_rol";
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE estatus = 1 AND id IN (2,3)";
        return $db->get_results($sql);
    }

    // public function save($categoria) {
    //     global $db;
    //     $data = array('nombre' => $categoria);

    //     return  $db->insert($this->table, $data);
    // }

}