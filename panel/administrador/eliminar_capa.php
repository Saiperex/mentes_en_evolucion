<?php
// Obtener el ID de la capacitación desde la URL
$id = $_GET['id'];

// Incluir el archivo de conexión a la base de datos
include ('../../php/conexion.php');

// Eliminar registros de la tabla capacitaciones
$sql_capacitaciones = "DELETE FROM capacitaciones WHERE id = ?";
$stmt_capacitaciones = $conn->prepare($sql_capacitaciones);
$stmt_capacitaciones->bind_param("i", $id);
$stmt_capacitaciones->execute();

// Eliminar registros de la tabla modulos
$sql_modulos = "DELETE FROM modulo WHERE id_capa = ?";
$stmt_modulos = $conn->prepare($sql_modulos);
$stmt_modulos->bind_param("i", $id);
$stmt_modulos->execute();

// Eliminar registros de la tabla clases
$sql_clases = "DELETE FROM clases WHERE id_capa = ?";
$stmt_clases = $conn->prepare($sql_clases);
$stmt_clases->bind_param("i", $id);
$stmt_clases->execute();

// Eliminar la carpeta de clases
$carpeta_clases = "../../clases/$id";
if (is_dir($carpeta_clases)) {
    eliminarDirectorio($carpeta_clases);
}

// Función para eliminar un directorio y su contenido
function eliminarDirectorio($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? eliminarDirectorio("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

// Redirigir a alguna página o mostrar un mensaje de éxito
header('Location: cargar_curso');
exit;
?>