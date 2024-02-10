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
if(isset($_POST['guardar_redes']))
{
    // Verificar si hay registros en la tabla redes
    $result = $conn->query("SELECT COUNT(*) AS count FROM redes");
    $row = $result->fetch_assoc();
    $count = $row['count'];
    
    // Obtener los datos del formulario
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $whatsapp = $_POST['whatsapp'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    
    if($count == 0) {
        // No hay registros, insertar uno nuevo
        $stmt = $conn->prepare("INSERT INTO redes (facebook, twitter, instagram, whatsapp, telefono, correo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $facebook, $twitter, $instagram, $whatsapp, $telefono, $correo);
        $stmt->execute();
        header('Location: contacto');
    } else {
        // Ya hay registros, actualizar el existente
        $stmt = $conn->prepare("UPDATE redes SET facebook=?, twitter=?, instagram=?, whatsapp=?, telefono=?, correo=?");
        $stmt->bind_param("ssssss", $facebook, $twitter, $instagram, $whatsapp, $telefono, $correo);
        $stmt->execute();
        header('Location: contacto');
    }
}
// Inicializar el array $redes
$redes = array(
    'facebook' => '',
    'twitter' => '',
    'instagram' => '',
    'whatsapp' => '',
    'telefono' => '',
    'correo' => ''
);

// Consultar los datos de las redes sociales
$resultado = $conn->query("SELECT * FROM redes");
if ($resultado->num_rows > 0) {
    // Si hay registros, obtener los datos y almacenarlos en el array $redes
    $redes = $resultado->fetch_assoc();
} else {
    // Si no hay registros, establecer valores predeterminados
    $redes = array(
        'facebook' => 'facebook',
        'twitter' => 'twitter',
        'instagram' => 'instagram',
        'whatsapp' => 'whatsapp',
        'telefono' => 'telefono',
        'correo' => 'correo'
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
            <div class="contenido_hijo ccon">
                <form method="post" action="contacto.php" class="contenedor_contacto">
                    <div class="cont_contacto">
                        <div class="contacto">
                            <i class="fa-brands fa-facebook-f"></i>
                            <input type="text" name="facebook" id="facebook" value="<?php echo $redes['facebook'] ?>">
                        </div>
                        <div class="contacto">
                            <i class="fa-brands fa-twitter"></i>
                            <input type="text" name="twitter" value="<?php echo $redes['twitter'] ?>">
                        </div>
                        <div class="contacto">
                            <i class="fa-brands fa-instagram"></i>
                            <input type="text" name="instagram" id="instagram" value="<?php echo $redes['instagram'] ?>">
                        </div>
                        <div class="contacto">
                            <i class="fa-brands fa-whatsapp"></i>
                            <input type="text" name="whatsapp" id="whatsapp" value="<?php echo $redes['whatsapp'] ?>">
                        </div>
                        <div class="contacto">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" name="telefono" id="telefono" value="<?php echo $redes['telefono'] ?>">
                        </div>
                        <div class="contacto">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="text" name="correo" id="correo" value="<?php echo $redes['correo'] ?>">
                        </div>
                    </div>
                    <button name="guardar_redes" type="submit">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>