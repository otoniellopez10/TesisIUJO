<?php

include_once '../mc-models/Config.php';
$db = Db::getInstance();

class Usuario{
    public $table, $tableRol;
    
    const ROL_ADMINISTRADOR = 1;
	const ROL_COLABORADOR = 2;
	const ROL_USUARIO = 3;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "usuario";
        $this->tableRol = "usuario_rol";
    }

    public function save($email, $password, $rol_id) {
        global $db;

        $data = array('email' => $email,
            'password' => $password,
            'rol_id' => $rol_id
        );

        return $db->insert($this->table, $data);
    }

    public function getOne($id) {
        global $db;
        return $db->get_row("SELECT * from $this->table  WHERE id='$id'");
    }

    public function getOneByEmail($email) {
        global $db;
        $sql = "SELECT
                u.id,
                u.email,
                u.rol_id,
                u.estatus
				FROM $this->table AS u
				WHERE u.email='$email'";
        return $db->get_row($sql);
    }

    public function getOneByEmail2($email) {
        global $db;
        $sql = "SELECT
                u.id,
                u.email,
                u.rol_id,
                u.estatus
                FROM $this->table AS u
				WHERE u.email='$email' and estatus = 1";
        return $db->get_row($sql);
    }

    public function updatePassword($id, $password) {
        global $db;

        $data = array(
            'password' => $password
        );
        $where = array('id' => $id);

        return $db->update($this->table, $data, $where);
    }

    public function update($id, $email, $password) {
        global $db;

        $data = array(
            'email' => $email,
            'password' => $password
            );
        $where = array('id' => $id);

        return $db->update($this->table, $data, $where);
    }

    public function delete($id) {
        global $db;

        $data = array(
            'estatus' => 0,
        );
        $where = array('id' => $id);

        return $db->update($this->table, $data, $where);
    }

    public function getOneRolwithId($rol_id) {
        global $db;
        $sql = "SELECT * FROM
				$this->tableRol
				WHERE id = $rol_id";
        return $db->get_row($sql);
    }

    public function formatEntidadNoParticipante($result) {
        $auxResult = $result;

        $arreglo = [];

        if (!is_array($result)) {
            $auxResult = [$result];
        }

        foreach ($auxResult as $fila) {
            $objEntidad = [
                'id' => $fila->id,
                'cedula' => $fila->cedula,
                'nombre' => $fila->nombre,
                'apellido' => $fila->apellido,
                'telefono' => $fila->telefono,
                'persona_tipo' => $fila->persona_tipo,
                'estatus' => $fila->estatus,
            ];
            array_push($arreglo, $objEntidad);
        }

        if (!is_array($result)) {
            return $arreglo[0];
        }
        return $arreglo;
    }
}