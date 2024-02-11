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
if (isset($_POST['cargar_entrada'])) 
{
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $contenido = $_POST['contenido'];

    // Obtener la fecha actual en formato dd/mm/yy
    $fecha_actual = date("d/m/y");

    // Insertar los datos de la entrada en la tabla 'entrada'
    $stmt = $conn->prepare("INSERT INTO entrada (fecha, titulo, subtitulo, contenido) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fecha_actual, $titulo, $subtitulo, $contenido);
    $stmt->execute();

    // Obtener el ID de la última entrada insertada
    $id_entrada = $stmt->insert_id;

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
                <div class="contenido_planes cargar_plan">
                    <form action="entradas.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Nueva Entrada</h2>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo">
                        <label for="subtitulo">subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo">
                        <label for="contenido">Contenido:</label><br>
                        <textarea id="contenido" name="contenido" rows="4" cols="50"></textarea><br><br>
                        <label for="archivos">Archivos</label>
                        <input type="file" id="archivos" name="archivos[]" accept="image/*,video/*" multiple><br><br>
                        <button type="submit" name="cargar_entrada">Agregar Entrada</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM entrada");
                        if($registros->num_rows>0)
                        {
                            while($entrada=$registros->fetch_assoc())
                            {
                                echo '<form action="entrada.php"  method="post" class="plan">';
                                    echo '<h2>'.$entrada['titulo'].'</h2>';
                                    echo '<h3>'.$entrada['subtitulo'].'</h3>';
                                    echo '<h4>'.$entrada['fecha'].'</h4>';
                                    echo '<input type="hidden" name="id" value="'.$entrada['id'].'">';
                                    echo '<button type="submit">Ver</button>';
                                echo '</form>';
                            }
                        }
                        else
                        {
                            echo '<form action="plan.php"  method="post" class="plan">';
                                    echo '<h2>No Posee entradas</h2>';
                                    
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