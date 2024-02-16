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
if(isset($_GET['id']))
{
    // Obtener el ID enviado por GET
    $id = $_GET['id'];
    $reg=$conn->query("SELECT * FROM subcategoria_capa WHERE id =$id");
    $subcategoria_capa=$reg->fetch_assoc();
    $id_capa=$subcategoria_capa['id_capa'];
    // Construir la consulta SQL de eliminación
    $sql = "DELETE FROM subcategoria_capa WHERE id = ?";
    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Enlazar parámetros
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header('Location: capacitacion.php?id='.$id_capa);
    } else {
        echo "Error al intentar eliminar el registro.";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}