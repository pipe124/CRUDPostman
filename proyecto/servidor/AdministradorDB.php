<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AdministradorDB {

    protected $mysqli;
    
    const LOCALHOST = '127.0.0.1'; 
    const USER = 'root';
    const PASSWORD = 'pipefelipe123';
    const DATABASE = 'tienda_canasta_familiar';

    public function __construct() {
        try {
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
            if ($this->mysqli->connect_error) {
                throw new Exception("Error de conexión: " . $this->mysqli->connect_error);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error de conexion a la base de datos: " . $e->getMessage();//mostra el error
            exit; 
        }
    }

    public function dameUnoPorId($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM administrador WHERE ID_administrador=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tarea = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $tarea;
    }

    public function dameLista() {
        $result = $this->mysqli->query('SELECT * FROM administrador');
        $tareas = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $tareas;
    }

    public function guarda($nombre, $correo, $contraseña) {
        $stmt = $this->mysqli->prepare("INSERT INTO administrador(nombre,correo,contraseña) VALUES(?, ?, ?)");
        $stmt->bind_param('sss', $nombre, $correo, $contraseña);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }

    public function elimina($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM administrador WHERE ID_administrador = ?");
        $stmt->bind_param('i', $id);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }

    public function actualiza($id, $nombre, $correo, $contraseña) {
        if ($this->verificaExistenciaPorId($id)) {
            $stmt = $this->mysqli->prepare("UPDATE administrador SET nombre=?, correo=?, contraseña=? WHERE ID_administrador = ?");
            $stmt->bind_param('sssi', $nombre, $correo, $contraseña, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        return false;
    }

    public function verificaExistenciaPorId($id) {
        $stmt = $this->mysqli->prepare("SELECT 1 FROM administrador WHERE ID_administrador=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
}
?>
