<?php

include_once 'Config.php';
$db = Db::getInstance();

class Login {
	private $table;
	private $tableRol;
	private $tableRolFuncion;
	private $tableFuncion;

    public function __construct() {
		$this->table = "usuario";
		$this->tableRol = "usuario_rol";
		$this->tableRolFuncion = "rol_funcion";
		$this->tableFuncion = "funcion";
    }
	
	public function getOne($usuario_id) {
		global $db;
		$sql = "SELECT
				u.*,
				r.nombre AS rol_nombre
				FROM $this->table AS u
		 		JOIN $this->tableRol AS r ON u.rol_id = r.id
		 		WHERE u.id = $usuario_id";
        return $db->get_row($sql);
	}

	public function getOneEmail($email) {
		global $db;
		$sql = "SELECT
				u.*,
				r.nombre AS rol_nombre
				FROM $this->table AS u
		 		JOIN $this->tableRol AS r ON u.rol_id = r.id
		 		WHERE u.email = '$email'";
        return $db->get_row($sql);
	}

}

?>
