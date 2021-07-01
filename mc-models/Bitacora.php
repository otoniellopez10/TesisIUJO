<?php

include_once 'Config.php';
$db = Db::getInstance();

class Bitacora {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->tableBitacoraPersona = "bitacora_persona";
        $this->tableBitacoraLibro = "bitacora_libro";
        $this->tablePersona = "persona";
    }

    // public function getAll() {
    //     global $db;
    //     $sql = "SELECT
    //             *
    //             FROM $this->table 
    //             WHERE estatus = 1 ORDER BY nombre ASC";
    //     return $db->get_results($sql);
    // }

    public function save($usuario_id, $libro_id, $operacion) {
        global $db;
        $data = array('usuario_id' => $usuario_id,
                        'libro_id' => $libro_id,
                        'operacion' => $operacion);

        return  $db->insert($this->tableBitacoraLibro, $data);
    }

    public function getBitacoraPersona() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->tableBitacoraPersona 
                ORDER BY fecha DESC";
        return $db->get_results($sql);
    }

    public function getBitacoraLibro() {
        global $db;
        $sql = "SELECT
                b.*,
                p.nombre,
                p.apellido
                FROM $this->tableBitacoraLibro b
                JOIN $this->tablePersona p on p.usuario_id = b.usuario_id
                ORDER BY fecha DESC";
        return $db->get_results($sql);
    }

}