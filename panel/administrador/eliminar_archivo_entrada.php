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


$id_archivo=$_GET['id'];


$id_archivo='';
// If input is via POST
if(isset($_POST['id']))
{
    $id_archivo=$_POST['id'];
}
// If input is via GET
elseif(isset($_GET['id']))
{
    $id_archivo=$_GET['id'];
}


$registro=$conn->query("SELECT * FROM archivos WHERE id=$id_archivo");
$archivo=$registro->fetch_assoc();

if(isset($_POST['eliminar']))
{
    $id = $_POST['id'];
    $sql = "DELETE FROM archivos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $id_entrada = $_POST['id_entrada'];
    $url_archivo = $_POST['url'];
    unlink("../../$url_archivo");
    // Redirigir a la página de planes después de eliminar el plan
    header('Location: entrada.php?id='.$id_entrada);
    exit; 
}
if(isset($_POST['cancelar']))
{
    $id_entrada = $_POST['id_entrada'];
    header('Location: entrada.php?id='.$id_entrada);
}
?>

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
                <form action="eliminar_archivo_entrada.php" method="post" class="pregunta p3">
                    <h2>Deseas eliminar el Archivo</h2>
                    <?php
                        $url = $archivo['url_archivo'];

                        // Obtener la extensión del archivo
                        $extension = pathinfo($url, PATHINFO_EXTENSION);
                        
                        // Verificar si la extensión corresponde a un video o una imagen
                        if (in_array($extension, ['mp4', 'avi', 'mov', 'wmv'])) 
                        {
                            echo '<video src="../../'.$archivo['url_archivo'].'" controls></video>';
                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) 
                        {
                            echo '<img src="../../'.$archivo['url_archivo'].'" alt="">';
                        } else {
                            echo "El archivo es incompatible.";
                        }
                    ?>
                    <input type="hidden" name="url" value="<?php echo $archivo['url_archivo'] ?>">
                    <input type="hidden" name="id" value="<?php echo $archivo['id'] ?>">
                    <input type="hidden" name="id_entrada" value="<?php echo $archivo['id_entrada'] ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                    <button type="submit" name="cancelar">Cancelar</button>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>