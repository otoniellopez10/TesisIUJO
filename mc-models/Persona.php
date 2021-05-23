<?php

include_once 'Config.php';
$db = Db::getInstance();

class persona {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "persona";
    }

    public function getOne($id) {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table
                WHERE id = $id";
        return $db->get_row($sql);
    }

    public function getOneByUsuarioId($usuario_id) {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE usuario_id = $usuario_id";
        return $db->get_row($sql);
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE estatus = 1";
        return $db->get_results($sql);
    }

    public function save($cedula, $nombre, $apellido, $telefono, $persona_tipo, $usuario_id) {
        global $db;
        $data = array('cedula' => $cedula,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'persona_tipo' => $persona_tipo,
            'usuario_id' => $usuario_id
        );
        return $db->insert($this->table, $data);
    }

    // public function update($id, $nombre, $direccion, $ciudad, $codigo_postal, $plan_id) {
    //     global $db;

    //     $data = array(
    //         'nombre' => $nombre,
    //         'direccion' => $direccion,
    //         'ciudad' => $ciudad,
    //         'codigo_postal' => $codigo_postal,
    //         'plan_id' => $plan_id,
    //     );
    //     $where = array('id' => $id);

    //     return $db->update($this->table, $data, $where);
    // }

}
