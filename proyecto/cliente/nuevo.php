<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Rutas.php";

$rutas = new Rutas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $rutas->dameUrlBase() . '/servidor/AdministradorAPI.php?action=administrador';

    $data = array(
        'nombre' => $_POST['nombre'] ?? '',
        'correo' => $_POST['correo'] ?? '',
        'contraseña' => $_POST['contraseña'] ?? ''
    );

    $postdata = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    echo "Administrador registrado correctamente.";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nuevo Administrador</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <form action="" method="post">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="correo">correo:</label><br>
            <input type="email" id="correo" name="correo" required><br>
            <label for="contraseña">contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" value="<?php echo htmlspecialchars($registro['contraseña'] ?? ''); ?>">
            <br>
            <button type="submit">Registrar</button>
        </form>
    </body>
</html>
