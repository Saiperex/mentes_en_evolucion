<?php
// Incluye el archivo de conexión a la base de datos
require_once('../php/conexion.php');

// Verifica si hay al menos un registro en la tabla usuarios
$sql = "SELECT COUNT(*) as total FROM usuarios";
$resultado = $conn->query($sql);

if($resultado) {
    $fila = $resultado->fetch_assoc();
    $totalRegistros = $fila['total'];
    
    // Si no hay registros, inserta uno nuevo
    if($totalRegistros == 0) {
        // Hashea la contraseña "admin"
        $contrasenaHasheada = password_hash('admin', PASSWORD_DEFAULT);

        // Inserta el nuevo usuario admin en la tabla usuarios
        $sqlInsert = "INSERT INTO usuarios (usuario, password, rol) VALUES ('admin', '$contrasenaHasheada', 0)";
        if($conn->query($sqlInsert) === TRUE) {
        } else {
        }
    } else {
    }
} else {
}
$conn->close();
?>