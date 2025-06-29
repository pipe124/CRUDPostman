<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "AdministradorDB.php";

class AdministradorAPI {

    public function API() {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];
        
        switch ($method) {
            case 'GET':
                $this->procesaListar();
                break;
            case 'POST':
                $this->procesaGuardar();
                break;
            case 'PUT':
                $this->procesaActualizar();
                break;
            case 'DELETE':
                $this->procesaEliminar();
                break;
            default:
                $this->response(405, "error", "Método no permitido");
                break;
        }
    }

    function response($code, $status, $message) {
        http_response_code($code);
        echo json_encode(["status" => $status, "message" => $message], JSON_PRETTY_PRINT);
    }

    function procesaListar() {
        if ($_GET['action'] == 'administrador') {
            $adminDB = new AdministradorDB();
            if (isset($_GET['id'])) {
                $response = $adminDB->dameUnoPorId($_GET['id']);
                echo json_encode($response, JSON_PRETTY_PRINT);
            } else {
                $response = $adminDB->dameLista();
                echo json_encode($response, JSON_PRETTY_PRINT);
            }
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }

    function procesaGuardar() {
        if ($_GET['action'] == 'administrador') {
            $obj = json_decode(file_get_contents('php://input'));
            if (!$obj || !isset($obj->nombre)) {
                $this->response(422, "error", "Datos incorrectos o incompletos");
                return;
            }
            $adminDB = new  AdministradorDB();
            $adminDB->guarda($obj->nombre, $obj->correo, $obj->contraseña);
            $this->response(201, "success", "Registro agregado");
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }

    function procesaActualizar() {
        if ($_GET['action'] == 'administrador' && isset($_GET['id'])) {
            $obj = json_decode(file_get_contents('php://input'));
            if (!$obj || !isset($obj->nombre)) {
                $this->response(422, "error", "Datos incorrectos o incompletos");
                return;
            }
            $adminDB = new AdministradorDB();
            $adminDB->actualiza($_GET['id'], $obj->nombre, $obj->correo, $obj->contraseña);
            $this->response(200, "success", "Registro actualizado");
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }

    function procesaEliminar() {
        if ($_GET['action'] == 'administrador' && isset($_GET['id'])) {
            $adminDB = new AdministradorDB();
            $adminDB->elimina($_GET['id']);
            $this->response(200, "success", "Registro eliminado");
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }
}

$api = new AdministradorAPI();
$api->API();
