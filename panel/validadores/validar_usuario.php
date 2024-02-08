<?php
session_start();
require_once('../../php/conexion.php');
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
if($resultado->num_rows>0)
{
    while($fila = $resultado->fetch_assoc())
    {
        $id = $fila['id'];
        $contrasena_hash = $fila['password'];

        if(password_verify($contraseña, $contrasena_hash)) {
            // La contraseña es correcta, establece la variable de sesión
            $_SESSION['id'] = $id;

            $_SESSION['rol'] = $fila['rol'];
            $_SESSION['mensaje'] = 'Sesión iniciada';
            header('Location: ../index.php');
            exit;
        }
    }

    // Si no se encontró ninguna coincidencia de contraseña
    header('Location: ../login');
    $_SESSION['mensaje'] = 'Contraseña incorrecta';
    exit;
}
else
{
     // Si no se encontró ningún usuario con ese nombre de usuario
     header('Location: ../login');
     $_SESSION['mensaje'] = 'Usuario inexistente';
     exit;
}
$stmt->close();
$conn->close();
?>
