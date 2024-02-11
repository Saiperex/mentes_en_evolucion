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



$id_entrada='';
// If input is via POST
if(isset($_POST['id']))
{
    $id_entrada=$_POST['id'];
}
// If input is via GET
elseif(isset($_GET['id']))
{
    $id_entrada=$_GET['id'];
}


$registro=$conn->query("SELECT * FROM entrada WHERE id=$id_entrada");
$entrada=$registro->fetch_assoc();


if(isset($_POST['eliminar']))
{
    $id = $_POST['id'];
    $sql = "DELETE FROM entrada WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $sql = "DELETE FROM archivos WHERE id_entrada = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    function eliminarDirectorio($carpeta) {
        // Verificar si la carpeta existe
        if (is_dir($carpeta)) {
            // Escanear el contenido de la carpeta
            $archivos = glob($carpeta . "/*");
            
            // Eliminar recursivamente los archivos y subdirectorios
            foreach ($archivos as $archivo) {
                if (is_dir($archivo)) {
                    eliminarDirectorio($archivo);
                } else {
                    unlink($archivo);
                }
            }
            
            // Eliminar el directorio
            rmdir($carpeta);
        }
    }
    eliminarDirectorio("../../entradas/$id/");
    // Redirigir a la página de planes después de eliminar el plan
    header('Location: entradas');
    exit; 
}
if(isset($_POST['cancelar']))
{
    header('Location: entradas');
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
                <form action="eliminar_entrada.php" method="post" class="pregunta">
                    <h2>Deseas eliminar la entrada "<?php echo $entrada['titulo'] ?>"</h2>
                    <input type="hidden" name="id" value="<?php echo $entrada['id'] ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                    <button type="submit" name="cancelar">Cancelar</button>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>