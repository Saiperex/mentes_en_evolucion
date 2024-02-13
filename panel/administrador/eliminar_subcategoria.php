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

$subcategoria_id = $_GET['id'];
$sql = "SELECT * FROM subcategorias WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subcategoria_id);
$stmt->execute();
$resultado = $stmt->get_result();
$subcategoria = $resultado->fetch_assoc();
if(isset($_POST['eliminar']))
{
    $id = $_POST['id'];
    $sql = "DELETE FROM subcategorias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Redirigir a la página de planes después de eliminar el plan
    header('Location: subcategorias');
    exit; 
}
if(isset($_POST['cancelar']))
{
    header('Location: subcategorias');
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
                <form action="eliminar_subcategoria.php" method="post" class="pregunta">
                    <h2>Deseas eliminar la subcategoria "<?php echo $subcategoria['subcategoria'] ?>"</h2>
                    <input type="hidden" name="id" value="<?php echo $subcategoria['id'] ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                    <button type="submit" name="cancelar">Cancelar</button>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>