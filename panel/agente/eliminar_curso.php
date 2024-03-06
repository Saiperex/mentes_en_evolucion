<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) 
{
    header('Location: ../login');
    exit;
}
if ($_SESSION['rol'] != 1) 
    {
        header('Location: ../error');
        exit;
    }
include ('../../php/conexion.php');

// Obtener el id del curso a eliminar
$id_curso = $_POST['id_curso'];

// Preparar la consulta para eliminar el curso asignado
$sql = "DELETE FROM cursos_asignados WHERE id_curso = ?";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt) {
    // Enlazar el parámetro
    $stmt->bind_param("i", $id_curso);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se ejecuta correctamente, redirigir a la página de éxito o hacer cualquier otra acción necesaria
        header('Location: asignar_curso.php');
        exit;
    } else {
        // Si hay un error en la ejecución, redirigir a la página de error o mostrar un mensaje de error
        header('Location: ../error.php');
        exit;
    }
} else {
    // Si hay un error en la preparación de la consulta, redirigir a la página de error o mostrar un mensaje de error
    header('Location: ../error.php');
    exit;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
