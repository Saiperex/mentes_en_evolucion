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
$resultado_video = $conn->query("SELECT * FROM video_inicio");
$video = $resultado_video->fetch_assoc();
if(isset($_POST['cambiar']))
{
    // Guardar el archivo nuevo en la carpeta img/recursos/
    $file_name = $_FILES['video']['name'];
    $file_tmp = $_FILES['video']['tmp_name'];
    $file_destination = '../../img/recursos/' . $file_name;
    move_uploaded_file($file_tmp, $file_destination);

    // Eliminar el archivo existente
    unlink('../../' . $video['video_url']);

    // Actualizar la columna video_url de la tabla video_inicio con la nueva URL
    $new_video_url = 'img/recursos/' . $file_name;
    $conn->query("UPDATE video_inicio SET video_url = '$new_video_url'");
    
    // Redirigir a alguna página de confirmación o a la misma página
    header('Location: video_inicio');
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
                <form action="video_inicio.php" method="post"  class="pregunta p2 p3" enctype="multipart/form-data">
                    <h2>Quieres cambiar el video actual??</h2>
                    <video src="../../<?php echo $video['video_url'] ?>" controls></video>
                    <label for="video">cambiar</label>
                    <input type="file" name="video" id="video">
                    <button type="submit" name="cambiar">Cambiar</button>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>