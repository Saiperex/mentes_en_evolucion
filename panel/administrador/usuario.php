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
if(isset($_POST['modificar_usuario']))
{
    $usuario=$_POST['usuario'];
    $contraseña_sin_hash=$_POST['contraseña'];
    $rol=$_POST['rol'];
    $id=$_POST['id'];
    // Generar el hash de la contraseña
    $hash_contraseña = password_hash($contraseña_sin_hash, PASSWORD_DEFAULT);
    
    // Actualizar el plan en la base de datos
    $sql = "UPDATE usuarios SET usuario = ?, password = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $usuario, $hash_contraseña, $rol, $id);
    $stmt->execute();

    // Redirigir a la página de planes después de la modificación
    header('Location: ../administrador');
    exit;
}
$registro=$conn->query("SELECT * FROM usuarios WHERE id={$_POST['id']} ");
$datos=$registro->fetch_assoc();
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
                    <form action="usuario.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Modificar Usuario</h2>
                        <label for="usuario">Usuario</label>
                        <input type="text" name="usuario" id="usuario" value="<?php echo $datos['usuario'] ?>">
                        <label for="contraseña">Contraseña</label>
                        <input type="text" name="contraseña" id="contraseña">
                        <label for="rol">Rol</label>
                        <select name="rol" id="rol">
                            <option value="0">Administrador</option>
                            <option value="1">Agente</option>
                            <option value="2">Alumno</option>
                        </select>
                        <input type="hidden" name="id" value="<?php echo $datos['id']?>">
                        <button type="submit" name="modificar_usuario">Modificar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>