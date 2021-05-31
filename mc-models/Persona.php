<?php

include_once 'Config.php';
$db = Db::getInstance();

class persona {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "persona";
        $this->tableTipo = "persona_tipo";
        $this->tableUsuario = "usuario";
        $this->tableRol = "usuario_rol";
    }

    public function getOne($id) {
        global $db;
        $sql = "SELECT
                    p.*,
                    t.nombre AS tipo,
                    u.email,
                    r.nombre AS rol
                    FROM $this->table AS p
                    JOIN $this->tableTipo AS t on t.id = p.persona_tipo
                    JOIN $this->tableUsuario AS u on u.id = p.usuario_id
                    JOIN $this->tableRol AS r on r.id = u.rol_id
                WHERE p.id = $id AND r.id IN (2,3)"; //que solo muestre colaboradors (2) y usuarios (3), mas no el admin (1)
        return $db->get_row($sql);
    }

    public function getOneByUsuarioId($usuario_id) {
        global $db;
        $sql = "SELECT
                    p.*,
                    t.nombre AS tipo,
                    u.email,
                    r.nombre AS rol, 
                    r.id AS rol_id
                    FROM $this->table AS p
                    JOIN $this->tableTipo AS t on t.id = p.persona_tipo
                    JOIN $this->tableUsuario AS u on u.id = p.usuario_id
                    JOIN $this->tableRol AS r on r.id = u.rol_id
                WHERE p.usuario_id = $usuario_id AND r.id IN (2,3)"; //que solo muestre colaboradors (2) y usuarios (3), mas no el admin (1)
        return $db->get_row($sql);
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                p.*,
                t.nombre AS tipo,
                u.email,
                r.nombre AS rol
                FROM $this->table AS p
                JOIN $this->tableTipo AS t on t.id = p.persona_tipo
                JOIN $this->tableUsuario AS u on u.id = p.usuario_id
                JOIN $this->tableRol AS r on r.id = u.rol_id
                WHERE r.id IN (2,3)"; //que solo muestre colaboradors (2) y usuarios (3), mas no el admin (1)
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

    public function desactivar($usuario_id){
        global $db;

        $data = array('estatus' => 0);
        // desactivar usuario en la tabla "participante"
        $where = array('usuario_id' => $usuario_id);
        
        if( $db->update($this->table, $data, $where) ){
            // desactivar en la tabla usuario y de una vez retornar el resultado.
            $where = array('id' => $usuario_id);
            return $db->update($this->tableUsuario, $data, $where);
        }else{
            return false;
        }

    }

    public function activar($usuario_id){
        global $db;

        $data = array('estatus' => 1);
        // desactivar usuario en la tabla "participante"
        $where = array('usuario_id' => $usuario_id);
        
        if( $db->update($this->table, $data, $where) ){
            // desactivar en la tabla usuario y de una vez retornar el resultado.
            $where = array('id' => $usuario_id);
            return $db->update($this->tableUsuario, $data, $where);
        }else{
            return false;
        }

    }


    public function cambiarRol($usuario_id, $rol_id){
        global $db;

        $data = array('rol_id' => $rol_id);
        // desactivar usuario en la tabla "participante"
        $where = array('id' => $usuario_id);
        
        return $db->update($this->tableUsuario, $data, $where);
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
