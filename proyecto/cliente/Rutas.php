<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Rutas {

    protected $urlBase = "http://localhost/proyecto";

    public function __construct() {
        // Constructor vacío
    }

    public function dameUrlBase() {
        return rtrim($this->urlBase, '/'); // Elimina barra final si existe
    }

    public function dameMenuInicio() {
        return '<a href="' . $this->dameUrlBase() . '/cliente/index.php">Inicio</a>';
    }

    public function dameMenuNuevo() {
        return "<a href='" . $this->dameUrlBase() . "/cliente/nuevo.php'>Nuevo</a>";
    }

    public function dameMenuModificar($ID_administrador) {
        return "<a href='" . $this->dameUrlBase() . "/cliente/modificar.php?id=" . $ID_administrador. "'>Modificar</a>";
    }

    public function dameMenuEliminar($ID_administrador) {
        return "<a href='" . $this->dameUrlBase() . "/cliente/eliminar.php?id=" . $ID_administrador . "'>Eliminar</a>";
    }
}

?>
