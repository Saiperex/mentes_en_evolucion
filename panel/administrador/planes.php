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
if (isset($_POST['cargar_plan'])) {
    // Validar y limpiar los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $precio = $_POST['precio'];
    // Aquí también deberías validar y limpiar los demás detalles del plan

    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO planes (titulo, subtitulo, precio, d1, d2, d3, d4, d5) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Enlazar los parámetros
    $stmt->bind_param("ssssssss", $titulo, $subtitulo, $precio, $_POST['d1'], $_POST['d2'], $_POST['d3'], $_POST['d4'], $_POST['d5']);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: planes');
        exit;
    } else {
        // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
        header('Location: ../error');
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
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
                <div class="contenido_planes cargar_plan">
                    <form action="planes.php" method="post">
                        <h2>cargar plan</h2>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo">
                        <label for="subtitulo">subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo">
                        <label for="precio">Precio</label>
                        <input type="text" name="precio" id="precio">

                        <label for="d1">Detalle 1</label>
                        <input type="text" name="d1" id="d1">
                        <label for="d2">Detalle 2</label>
                        <input type="text" name="d2" id="d2">
                        <label for="d3">Detalle 3</label>
                        <input type="text" name="d3" id="d3">
                        <label for="d4">Detalle 4</label>
                        <input type="text" name="d4" id="d4">
                        <label for="d5">Detalle 5</label>
                        <input type="text" name="d5" id="d5">
                        <button type="submit" name="cargar_plan">Agregar Plan</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM planes");
                        if($registros->num_rows>0)
                        {
                            while($plan=$registros->fetch_assoc())
                            {
                                echo '<form action="plan.php"  method="post" class="plan">';
                                    echo '<h2>'.$plan['titulo'].'</h2>';
                                    echo '<h3>'.$plan['subtitulo'].'</h3>';
                                    echo '<h4>'.$plan['precio'].'</h4>';
                                    echo '<input type="hidden" name="id" value="'.$plan['id'].'">';
                                    echo '<button type="submit">Ver</button>';
                                echo '</form>';
                            }
                        }
                        else
                        {
                            echo '<form action="plan.php"  method="post" class="plan">';
                                    echo '<h2>No Posee Planes</h2>';
                                    
                                echo '</form>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>