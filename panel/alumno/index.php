<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) 
{
    header('Location: ../login');
    exit;
}
if ($_SESSION['rol'] != 2) 
    {
        header('Location: ../error');
        exit;
    }
include ('../../php/conexion.php');
if(isset($_POST['cargar_usuario']))
{
    $usuario=$_POST['usuario'];
    $contraseña_sin_hash=$_POST['contraseña'];
    $rol=$_POST['rol'];
    // Generar el hash de la contraseña
    $hash_contraseña = password_hash($contraseña_sin_hash, PASSWORD_DEFAULT);
    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Enlazar los parámetros
    $stmt->bind_param("ssi", $usuario, $hash_contraseña, $rol);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: ../agente');
        exit;
    } else {
        // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
        header('Location: ../error');
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
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
    <title>PANEL AGENTE</title>
</head>
<body>
    <?php include('menu.php') ?>
    <main class="principal">
        <div class="contenido_padre">
            <div class="contenido_hijo">
            
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>