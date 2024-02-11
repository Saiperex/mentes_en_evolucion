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
$entrada_id='';
// If input is via POST
if(isset($_POST['id']))
{
    $entrada_id=$_POST['id'];
}
// If input is via GET
elseif(isset($_GET['id']))
{
    $entrada_id=$_GET['id'];
}
$registro=$conn->query("SELECT * FROM entrada WHERE id=$entrada_id");
$entrada=$registro->fetch_assoc();



if (isset($_POST['modificar_entrada'])) 
{
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $contenido = $_POST['contenido'];
    $id_entrada = $_POST['id'];
    // Obtener la fecha actual en formato dd/mm/yy
    $fecha_actual = date("d/m/y");

    // Actualizar los datos de la entrada en la tabla 'entrada'
    $stmt = $conn->prepare("UPDATE entrada SET fecha=?, titulo=?, subtitulo=?, contenido=? WHERE id=?");
    $stmt->bind_param("ssssi", $fecha_actual, $titulo, $subtitulo, $contenido, $id_entrada);
    $stmt->execute();

    // Ruta donde se guardarán los archivos de la entrada
    $ruta_entrada = "../../entradas/$id_entrada/";

    // Crear la carpeta si no existe
    if (!file_exists($ruta_entrada)) {
        mkdir($ruta_entrada, 0777, true);
    }

    // Procesar los archivos subidos
    if (!empty($_FILES['archivos']['name'][0])) {
        foreach ($_FILES['archivos']['name'] as $key => $nombre) {
            $archivo_tmp = $_FILES['archivos']['tmp_name'][$key];
            $nombre_archivo = basename($nombre);
            $ruta_archivo = "entradas/$id_entrada/$nombre_archivo";
            move_uploaded_file($archivo_tmp, "../../".$ruta_archivo);

            // Insertar la información del archivo en la tabla 'archivos'
            $stmt = $conn->prepare("INSERT INTO archivos (id_entrada, url_archivo) VALUES (?, ?)");
            $stmt->bind_param("is", $id_entrada, $ruta_archivo);
            $stmt->execute();
        }
    }
    header('Location: entrada.php?id='.$entrada_id);
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
                    <form action="entrada.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Modificar Entrada</h2>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo" value="<?php echo $entrada['titulo'] ?>">
                        <label for="subtitulo">subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" value="<?php echo $entrada['subtitulo'] ?>">
                        <label for="contenido">Contenido:</label><br>
                        <textarea id="contenido" name="contenido" rows="4" cols="50"><?php echo $entrada['contenido'] ?></textarea><br><br>
                        <input type="hidden" name="id" value="<?php echo $entrada['id'] ?>">
                        <label for="archivos">Archivos</label>
                        <input type="file" id="archivos" name="archivos[]" accept="image/*,video/*" multiple><br><br>
                        <button type="submit" name="modificar_entrada">Guardar Cambios</button>
                        <a href="eliminar_entrada.php">Eliminar</a>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros_archivos=$conn->query("SELECT * FROM archivos WHERE id_entrada=$entrada_id");
                        if($registros_archivos->num_rows>0)
                        {
                            while($archivo=$registros_archivos->fetch_assoc())
                            {
                                echo '<div class="archivo">';

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
                                    echo '<a href="eliminar_archivo_entrada.php?id='.$archivo['id'].'"><i class="fa-solid fa-trash"></i> Eliminar</a>';
                                echo '</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="archivo">';
                                    echo '<h2>No Posee Archivos</h2>';
                                    
                                echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>