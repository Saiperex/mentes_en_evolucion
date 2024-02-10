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
$plan_id = $_POST['id'];
$sql = "SELECT * FROM planes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $plan_id);
$stmt->execute();
$resultado = $stmt->get_result();
$plan = $resultado->fetch_assoc();

/*MODIFICAR PLAN*/
if (isset($_POST['modificar_plan'])) 
{
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $precio = $_POST['precio'];
    $d1 = $_POST['d1'];
    $d2 = $_POST['d2'];
    $d3 = $_POST['d3'];
    $d4 = $_POST['d4'];
    $d5 = $_POST['d5'];
    $id = $_POST['id'];

    // Actualizar el plan en la base de datos
    $sql = "UPDATE planes SET titulo = ?, subtitulo = ?, precio = ?, d1 = ?, d2 = ?, d3 = ?, d4 = ?, d5 = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $titulo, $subtitulo, $precio, $d1, $d2, $d3, $d4, $d5, $id);
    $stmt->execute();

    // Redirigir a la página de planes después de la modificación
    header('Location: planes');
    exit;
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
                    <form action="plan.php" method="post">
                        <h2>cargar plan</h2>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo" value="<?php echo $plan['titulo'] ?>">
                        <label for="subtitulo">subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" value="<?php echo $plan['subtitulo'] ?>">
                        <label for="precio">Precio</label>
                        <input type="text" name="precio" id="precio" value="<?php echo $plan['precio'] ?>">

                        <label for="d1">Detalle 1</label>
                        <input type="text" name="d1" id="d1" value="<?php echo $plan['d1'] ?>">
                        <label for="d2">Detalle 2</label>
                        <input type="text" name="d2" id="d2" value="<?php echo $plan['d2'] ?>">
                        <label for="d3">Detalle 3</label>
                        <input type="text" name="d3" id="d3" value="<?php echo $plan['d3'] ?>">
                        <label for="d4">Detalle 4</label>
                        <input type="text" name="d4" id="d4" value="<?php echo $plan['d4'] ?>">
                        <label for="d5">Detalle 5</label>
                        <input type="text" name="d5" id="d5" value="<?php echo $plan['d5'] ?>">
                        <input type="hidden" name="id" value="<?php echo $plan['id'] ?>">
                        <button type="submit" name="modificar_plan">Modificar Plan</button>
                        <a href="eliminar_plan.php?id=<?php echo $plan['id'] ?>">Eliminar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>