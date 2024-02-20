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
if(isset($_POST['cargar_clase'])) 
{
    $modulo = $_POST['modulo'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $curso = $_GET['id'];

    // Ruta base para la carpeta de clases
    $ruta_clases_base = '../../clases';

    // Ruta específica para el curso y el módulo
    $ruta_clases_curso_modulo = $ruta_clases_base . '/' . $curso . '/' . $modulo;

    // Verificar si la carpeta para el curso ya existe
    if (!file_exists($ruta_clases_curso_modulo)) {
        // Si no existe, la creamos recursivamente
        mkdir($ruta_clases_curso_modulo, 0777, true);
    }

    // Insertar la clase en la base de datos
    $sql = "INSERT INTO clases (id_capa, id_modulo, titulo, contenido) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Enlazar los parámetros
    $stmt->bind_param("iiss", $curso, $modulo, $titulo, $descripcion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el ID de la clase recién insertada
        $clase_id = $stmt->insert_id;

        // Crear la carpeta para la clase dentro de la carpeta del módulo
        $ruta_clase = $ruta_clases_curso_modulo . '/' . $clase_id.'/';
        mkdir($ruta_clase, 0777, true);

        // Procesar los archivos
        if(!empty($_FILES['archivos']['name'][0])) 
        {
            foreach ($_FILES['archivos']['name'] as $key => $nombre)
            {
                $archivo_tmp = $_FILES['archivos']['tmp_name'][$key];
                $nombre_archivo = basename($nombre);
                move_uploaded_file($archivo_tmp,$ruta_clase.'/'.$nombre_archivo);
            }
        }
        // Redirigir a la página de cargar clases
        header('Location: cargar_clases.php?id='.$curso);
        exit;
    } else {
        // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo según sea necesario
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
                    <form action="cargar_clases.php?id=<?php echo $_GET['id'] ?>" class="entrada" method="post" enctype="multipart/form-data">
                        <h2>Agrega clases a los modulos</h2>
                        <label for="capa">Seleccione el modulo</label>
                        <select name="modulo" id="modulo">
                            <?php
                                $registros_modulo=$conn->query("SELECT * FROM modulo WHERE id_capa={$_GET['id']} ");
                                if($registros_modulo->num_rows>0)
                                {
                                    while($modulo=$registros_modulo->fetch_assoc())
                                    {
                                        echo '<option value="'.$modulo['id'].'">'.$modulo['titulo'].'</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="-1">Sin categorias</option>';
                                }
                            ?>
                        </select>
                        <label for="titulo">Titulo de la clase</label>
                        <input type="text" name="titulo" id="titulo">
                        <label for="descripcion">Descripcion</label>
                        <br>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                        <br>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                        <label for="archivos">Archivos</label>
                        <input type="file" id="archivos" name="archivos[]" multiple><br><br>
                        <button type="submit" class="cargar_capa" name="cargar_clase">Agregar Clase</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros = $conn->query("SELECT * FROM clases WHERE id_capa = {$_GET['id']} ORDER BY id_modulo, id");
                        if($registros->num_rows>0)
                        {
                            while($clase=$registros->fetch_assoc())
                            {
                                echo '<form action="clase.php"  method="get" class="plan">';
                                    echo '<h2>'.$clase['titulo'].'</h2>';
                                    
                                    echo '<input type="hidden" name="id" value="'.$clase['id'].'">';
                                    echo '<button type="submit">ver</button>';
                                echo '</form>';
                            }
                        }
                        else
                        {
                            echo '<form action="capacitacion.php"  method="post" class="plan">';
                                    echo '<h2>Esta capacitacion no posee clases</h2>';
                                    
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