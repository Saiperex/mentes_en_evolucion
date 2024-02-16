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
$id_capa=$_POST['id_capa'];
$id_subcategoria=$_POST['subcategorias'];

// Preparar la consulta para insertar el nuevo plan
$sql = "INSERT INTO subcategoria_capa (id_capa, id_subcategoria) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Enlazar los parámetros
$stmt->bind_param("ii", $id_capa, $id_subcategoria);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Si se inserta correctamente, redirigir a la página de planes
    header('Location: capacitacion.php?id='.$id_capa);
    exit;
} else {
    // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
    header('Location: ../error');
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
