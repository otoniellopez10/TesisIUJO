<?php

Class db{
    const _NULL = 'NULL';
    const _CURRENT_DATE = 'CURRENT_DATE';
    const _CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';
    const CONSTANTS = [self::_NULL, self::_CURRENT_DATE, self::_CURRENT_TIMESTAMP];

    private $mysql;

    private static $_instance;

    /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
    private function __construct() {
        $this->connect();
    }

    /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*Realiza la conexión a la base de datos.*/
    private function connect() {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $name = 'tesis';

        error_reporting(0);

        // Conexión a MySQL
        $this->mysql = mysqli_connect($host, $user, $pass, $name);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    /*Método para ejecutar una sentencia sql genérica*/
    public function query($sql) {
        $query = mysqli_query($this->mysql, $sql);
        $error = mysqli_error($this->mysql);
        return $query;
    }

    /*Método para ejecutar un sentencia sql de tipo SELECT y retornar sus filas como un arreglo */
    public function get_results($sql) {
        $result = $this->query($sql);
        $arrayObject = [];
        while ($obj = mysqli_fetch_object($result)) {
            array_push($arrayObject, $obj);
        }
        return $arrayObject;
    }

    /*Método para ejecutar un sentencia sql de tipo SELECT y retornar solo una fila */
    public function get_row($sql) {
        $result = $this->query($sql);
        return mysqli_fetch_object($result);
    }

    /*Método para construir una sentencia INSERT sql*/
    public function insert($tabla, $arrayValores) {
        $sql = "INSERT INTO $tabla " . $this->buildInsertColumnsValues($arrayValores); 
        if ($this->query($sql)) {
            return $this->lastID();
        }
        return false;
    }

    /*Devuelve el último id autoincrementado registrado por un INSERT*/
    private function lastID() {
        $lastid = mysqli_insert_id($this->mysql);
        return $lastid;
    }

    /*Función auxiliar para generar los valores por insertar para ser concatenados*/
    private function buildInsertColumnsValues($assocArray) {
        if (!isset($assocArray) || count($assocArray) == 0) {
            throw new Exception("Arreglo de valores a insertar no está inicializado o está vacío");
        }
        $delimiter = "";
        $fields = ""; // Columnas
        $values = ""; // Valores de cada columna
        foreach ($assocArray as $key => $value) {
            $fields .= $delimiter . $key;
            if (!isset($value)) {
                $values .= $delimiter . self::_NULL;
            } elseif (is_string($value) && !in_array($value, self::CONSTANTS)) {
                $values .= $delimiter . "'$value'";
            } else {
                $values .= $delimiter . $value;
            }
            $delimiter = ", ";
        }
        return "($fields) VALUES ($values)";
    }

    /*Método para construir una sentencia UPDATE sql*/
    public function update($tabla, $arrayValores, $where) {
        $sql = "UPDATE $tabla SET " . $this->buildUpdateFields($arrayValores) . $this->buildWhere($where);
        return $this->query($sql); // Retorna TRUE si es exitoso, FALSE en caso contrario
    }

    /*Función auxiliar para generar los valores por actualizar para ser concatenados*/
    private function buildUpdateFields($assocArray) {
        if (!isset($assocArray) || count($assocArray) == 0) {
            throw new Exception("Arreglo de valores a actualizar no está inicializado o está vacío");
        }
        $str = "";
        $delimiter = "";
        foreach ($assocArray as $key => $value) {
            if (!isset($value)) {
                $str .= $delimiter . "$key = " . self::_NULL;
            } elseif (is_string($value) && !in_array($value, self::CONSTANTS)) {
                $str .= $delimiter . "$key = '$value'";
            } else {
                $str .= $delimiter . "$key = $value";
            }
            $delimiter = ", ";
        }
        return $str;
    }

    /*Función auxiliar para generar las condiciones de la consulta (WHERE) para ser concatenados*/
    // Acepta un arreglo vacío o null, en cuyo caso retorna el string ""
    private function buildWhere($assocArray) {
        if (!isset($assocArray) || count($assocArray) == 0) {
            return "";
        }
        $str = "";
        $delimiter = " WHERE ";
        foreach ($assocArray as $key => $value) {
            if (!isset($value)) {
                $str .= $delimiter . "$key IS " . self::_NULL;
            } elseif (is_string($value) && !in_array($value, self::CONSTANTS)) {
                $str .= $delimiter . "$key = '$value'";
            } else {
                $str .= $delimiter . "$key = $value";
            }
            $delimiter = " AND ";
        }
        return $str;
    }

    /*Método para construir una sentencia DELETE sql*/
    public function delete($tabla, $where) {
        $sql = "DELETE FROM $tabla" . $this->buildWhere($where);
        return $this->query($sql); // Retorna TRUE si es exitoso, FALSE en caso contrario
    }
}