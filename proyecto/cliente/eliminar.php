<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Rutas.php";

$rutas = new Rutas();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $url = $rutas->dameUrlBase() . "/servidor/AdministradorAPI.php?action=administrador&id=" . $id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $resultado = ($httpCode == 200) ? "Registroadministrador eliminado exitosamente" : "No fue posible eliminar el administrador";
} else {
    $resultado = "ID inválido";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Eliminar administrador</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <p><?php echo $resultado; ?></p>
    </body>
</html>
