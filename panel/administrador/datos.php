<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) 
{
    header('Location: ../login');
    exit;
}
if ($_SESSION['rol'] != 0) 
    {
        header('Location: ../error');
        exit;
    }
include ('../../php/conexion.php');
if(isset($_POST['guardar']))
{
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $whatsapp = $_POST['whatsapp'];
    // Verificar si hay registros en la tabla redes
    $result = $conn->query("SELECT COUNT(*) AS count FROM user_data WHERE id_user={$_SESSION['id']}");
    $row = $result->fetch_assoc();
    $count = $row['count'];
    if($count == 0)
    {
        // No hay registros, insertar uno nuevo
        $stmt = $conn->prepare("INSERT INTO user_data (nombre, correo, whatsapp, id_user) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $correo, $whatsapp, $_SESSION['id']);
        $stmt->execute();
        header('Location: datos');
    }
    else 
    {
        // Ya hay registros, actualizar el existente
        $stmt = $conn->prepare("UPDATE user_data SET nombre=?, correo=?, whatsapp=? WHERE id_user=?");
        $stmt->bind_param("sssi", $nombre, $correo, $whatsapp,$_SESSION['id']);
        $stmt->execute();
        header('Location: datos');
    }
}

$datos = array(
    'nombre' => '',
    'correo' => '',
    'whatsapp' => ''
);

// Consultar los datos 
$resultado = $conn->query("SELECT * FROM user_data WHERE id_user={$_SESSION['id']}");
if ($resultado->num_rows > 0) {
    // Si hay registros, obtener los datos y almacenarlos en el array $redes
    $datos = $resultado->fetch_assoc();
} else {
    // Si no hay registros, establecer valores predeterminados
    $datos = array
    (
        'nombre' => 'tu nombre',
        'correo' => 'tu correo',
        'whatsapp' => 'tu whatsapp'
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Open+Sans:wght@300&family=Raleway:wght@300&family=Roboto:wght@300&display=swap">
    <!--CSS-->
    <link rel="stylesheet" href="../../css/init.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <!--META-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANEL ADMINISTRADOR</title>
</head>
<body>
    <?php include('menu.php') ?>
    <main class="principal">
        <div class="contenido_padre">
            <div class="contenido_hijo">
            <div class="contenido_planes cargar_plan">
                    <form action="datos.php" method="post">
                        <h2>Ingresa tus datos</h2>
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?php echo $datos['nombre'] ?>">
                        <label for="correo">Correo Electronico</label>
                        <input type="text" name="correo" id="correo" value="<?php echo $datos['correo'] ?>">
                        <label for="whatsapp">Whatsapp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="<?php echo $datos['whatsapp'] ?>">
                        <button type="submit" name="guardar">Guardar Cambios</button>
                        <a href="cambiar_clave">Cambiar Clave</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>