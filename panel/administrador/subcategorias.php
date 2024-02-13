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

if(isset($_POST['cargar_subcategoria']))
{
    // Validar y limpiar los datos del formulario
    $id_categoria=$_POST['categoria'];
    $titulo = $_POST['titulo'];
    $aclaracion = $_POST['aclaracion'];
    $color = $_POST['color'];

    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO subcategorias (id_categoria, subcategoria, aclaracion, color) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Enlazar los parámetros
    $stmt->bind_param("isss",$id_categoria, $titulo, $aclaracion, $color);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: subcategorias');
        exit;
    } else {
        // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
        header('Location: ../error');
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
$registros=$conn->query("SELECT * FROM categorias");

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
                    <form action="subcategorias.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Nueva Subcategorias</h2>
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria">
                            <?php
                                if($registros->num_rows>0)
                                {
                                    while($categorias=$registros->fetch_assoc())
                                    {
                                         echo '<option style="color:'.$categorias['color'].';" value="'.$categorias['id'].'">'.$categorias['categoria'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo">
                        <label for="aclaracion">Aclaracion</label>
                        <input type="text" name="aclaracion" id="aclaracion">
                        <label for="color">Color de Etiqueta</label>
                        <input type="color" name="color" id="color">
                        <button type="submit" name="cargar_subcategoria">Agregar Subcategoria</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM subcategorias");
                        if($registros->num_rows>0)
                        {
                            while($entrada=$registros->fetch_assoc())
                            {
                                echo '<form action="subcategoria.php"  method="post" class="plan">';
                                    echo '<h2>Subcategoria: '.$entrada['subcategoria'].'</h2>';
                                    $registro_categoria=$conn->query("SELECT * FROM categorias WHERE id={$entrada['id_categoria']}");
                                    if($registro_categoria->num_rows>0) 
                                    {
                                        $categoria=$registro_categoria->fetch_assoc();
                                        echo '<h3>Categoria: '.$categoria['categoria'].'</h3>';
                                    }
                                    else
                                    {
                                        echo '<h3>Sin Categoria</h3>';
                                    }
                                    echo '<h3>Aclaracion: '.$entrada['aclaracion'].'</h3>';
                                    echo '<h4 style="color:'.$entrada['color'].';">Color Elegido</h4>';
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