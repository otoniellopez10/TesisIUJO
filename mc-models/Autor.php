<?php

include_once 'Config.php';
$db = Db::getInstance();

class Autor {

    private $table;

    public function __construct() {
        //asignar nombre de la tabla aqui para no cambiar en cada metodo
        $this->table = "autor";
        $this->tableRelacion = "libro_autor";
        $this->tableLibro = "libro";
    }

    public function getAll() {
        global $db;
        $sql = "SELECT
                *
                FROM $this->table 
                WHERE estatus = 1";
        return $db->get_results($sql);
    }

    public function getAll2() {
        global $db;
        $sql = "SELECT
                a.id, a.nombre
                FROM $this->tableRelacion r
                JOIN $this->table a on a.id = r.autor_id
                JOIN $this->tableLibro l on l.id = r.libro_id

                WHERE a.estatus = 1 AND l.estatus = 1";

        return $db->query($sql);
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
            $nombre = ucwords(mb_strtolower($array_autores[0], "UTF-8"));
            $data = array('nombre' => $nombre);
            $return_id = $db->insert($this->table, $data); //agregar el autor a la BD (devuelve ID)
            if(!$return_id) return false;
            
            $data = array('libro_id' => $libro_id,
                          'autor_id' => $return_id);

            $query = $db->insert($this->tableRelacion, $data); //agregar datos a la tabla de relacion
            if(!$return_id) return false;

        }else if(count($array_autores) > 1){
            foreach($array_autores as $au){
                $nombre = ucwords(strtolower($au));
                $data = array('nombre' => $nombre);
                $return_id = $db->insert($this->table, $data); //agregar el autor a la BD (devuelve ID)
                if(!$return_id) return false;
                
                $data = array('libro_id' => $libro_id,
                            'autor_id' => $return_id);

                $query = $db->insert($this->tableRelacion, $data); //agregar datos a la tabla de relacion
                if(!$return_id) return false;
            }
        }

        return true;

    }

    public function deleteAutoresLibro($libro_id){
        global $db;

        $where = array(
            "libro_id" => $libro_id
        );

        return $db->delete($this->tableRelacion, $where);
    }

}