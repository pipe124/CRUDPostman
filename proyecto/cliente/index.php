<?php
// Configuración de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Rutas.php";

$rutas = new Rutas();
$url = $rutas->dameUrlBase() . "/servidor/AdministradorAPI.php?action=administrador";

$response = file_get_contents($url);
if ($response === false) {
    die("Error al obtener datos de la API");
}

$registros = json_decode($response, true);
if ($registros === null) {
    die("Error al decodificar JSON");
}

// Asegurar que $registros es array (lista)
if (!is_array($registros)) {
    $registros = [$registros];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de administrador</title>
</head>
<body>
    <?= $rutas->dameMenuInicio() ?> &nbsp;&nbsp;&nbsp;&nbsp; <?= $rutas->dameMenuNuevo() ?>
    <br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>CONTRASEÑA</th> <!-- Cuidado con mostrar contraseñas -->
                <th>OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $registro): ?>
                <tr>
                    <td><?= htmlspecialchars($registro['ID_administrador']) ?></td>
                    <td><?= htmlspecialchars($registro['nombre']) ?></td>
                    <td><?= htmlspecialchars($registro['correo']) ?></td>
                    <td><?= '********' /* No mostrar contraseña real */ ?></td>
                    <td>
                        <?= $rutas->dameMenuModificar($registro['ID_administrador']) ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?= $rutas->dameMenuEliminar($registro['ID_administrador']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <pre><?php var_dump($registros); ?></pre>
</body>
</html>
