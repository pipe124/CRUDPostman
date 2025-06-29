<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Rutas.php";

$rutas = new Rutas();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$registro = [];

if ($id > 0) {
    $url = $rutas->dameUrlBase() . '/servidor/AdministradorAPI.php?action=administrador&id=' . $id;
    $response = file_get_contents($url);
    if ($response !== false) {
        $registro = json_decode($response, true);
        $resgistro = $registro[0] ?? [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $rutas->dameUrlBase() . '/servidor/AdministradorAPI.php?action=administrador&id=' . $id;
    $data = array(
        'nombre' => $_POST['nombre'] ?? '',
        'correo' => $_POST['correo'] ?? '',
        'contraseña' => $_POST['contraseña'] ?? ''
    );
    $postdata = json_encode($data);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    
    $registro = $data;
    echo "Registro modificado correctamente.";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modificar Administrador</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <form action="" method="post">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro['nombre'] ?? ''); ?>"><br>
            <label for="correo">correo:</label><br>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($registro['correo'] ?? ''); ?>"><br>
            <label for="contraseña">contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" value="<?php echo htmlspecialchars($registro['contraseña'] ?? ''); ?>">
            <br>
            <button type="submit">Guardar</button>
        </form>
    </body>
</html>
