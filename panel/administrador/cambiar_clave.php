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

if(isset($_POST['cambiar']))
{
    $id = $_POST['id'];
    $contraseña = $_POST['contraseña'];
    $contrasenaHasheada = password_hash($contraseña, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET password=? WHERE id=?");
    $stmt->bind_param("si", $contrasenaHasheada, $_SESSION['id']);
    $stmt->execute();
    header('Location: datos');
}
if(isset($_POST['cancelar']))
{
    header('Location: datos');
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
                <form action="cambiar_clave.php" method="post" class="pregunta p2">
                    <h2>Deseas cambiar tu clave?</h2>
                    <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
                    <input type="text" name="contraseña" id="contraseña">
                    <button type="submit" name="cambiar">Cambiar</button>
                    <button type="submit" name="cancelar">Cancelar</button>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>