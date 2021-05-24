<?php

include_once 'Config.php';
$db = Db::getInstance();

class Autor {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "autor";
        $this->tableRelacion = "libro_autor";
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE estatus = 1";
        return $db->get_results($sql);
    }

    public function getByLibroId($id){
        global $db;

        $sql = "SELECT 
                    a.* 
                FROM $this->tableRelacion r
                JOIN $this->table as a on a.id =  r.autor_id
                WHERE a.estatus = 1 AND r.libro_id = $id
                ";
        return $db->get_results($sql);
    }

    public function save($autores, $libro_id) {
        global $db;
        $array_autores = explode(",",$autores);

        if(count($array_autores) == 1){
            $data = array('nombre' => $array_autores[0]);
            $return_id = $db->insert($this->table, $data); //agregar el autor a la BD (devuelve ID)
            if(!$return_id) return false;
            
            $data = array('libro_id' => $libro_id,
                          'autor_id' => $return_id);

            $query = $db->insert($this->tableRelacion, $data); //agregar datos a la tabla de relacion
            if(!$return_id) return false;

        }else if(count($array_autores) > 1){
            foreach($array_autores as $au){
                $data = array('nombre' => $au);
                $return_id = $db->insert($this->table, $data); //agregar el autor a la BD (devuelve ID)
                if(!$return_id) return false;
                
                $data = array('libro_id' => $libro_id,
                            'autor_id' => $return_id);

                $query = $db->insert($this->tableRelacion, $data); //agregar datos a la tabla de relacion
                if(!$return_id) return false;
            }
        }

        

    }

}