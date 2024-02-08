<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id']))
{
    header('Location: index.php');
    exit; // Asegúrate de salir del script después de redirigir
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--CSS-->
    <link rel="stylesheet" href="../css/init.css">
    <link rel="stylesheet" href="css/estilos.css">
    <!--META-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTES EN EVOLUCION - INCIO DE SESION</title>
</head>
<body>
    
</body>
</html>