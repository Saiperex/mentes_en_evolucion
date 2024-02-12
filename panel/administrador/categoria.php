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
$id_categoria=$_POST['id'];
$registro_categoria=$conn->query("SELECT * FROM categorias WHERE id=$id_categoria");
$categoria=$registro_categoria->fetch_assoc();

if (isset($_POST['modificar_categoria'])) 
{
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['aclaracion'];
    $color = $_POST['color'];
    $id = $_POST['id'];

    // Actualizar el plan en la base de datos
    $sql = "UPDATE categorias SET categoria = ?, aclaracion = ?, color = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $titulo, $subtitulo, $color, $id);
    $stmt->execute();

    // Redirigir a la página de planes después de la modificación
    header('Location: categorias');
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
                    <form action="categoria.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Nueva Categoria</h2>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo" value="<?php echo $categoria['categoria'] ?>">
                        <label for="aclaracion">Aclaracion</label>
                        <input type="text" name="aclaracion" id="aclaracion" value="<?php echo $categoria['aclaracion'] ?>">
                        <label for="color">Color de Etiqueta</label>
                        <input type="color" name="color" id="color" value="<?php echo $categoria['color'] ?>">
                        <input type="hidden" name="id" value="<?php echo $categoria['id'] ?>">
                        <button type="submit" name="modificar_categoria">Agregar Categoria</button>
                        <a href="eliminar_categoria.php?id=<?php echo $categoria['id'] ?>">Eliminar Categoria</a>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM subcategorias WHERE id_categoria={$categoria['id']} ");
                        if($registros->num_rows>0)
                        {
                            while($entrada=$registros->fetch_assoc())
                            {
                                echo '<form action="categoria.php"  method="post" class="plan">';
                                    echo '<h2>Subcategoria: '.$entrada['subcategoria'].'</h2>';
                                    echo '<h3>Aclaracion: '.$entrada['aclaracion'].'</h3>';
                                    echo '<h4 style="color:'.$entrada['color'].';">Color Elegido</h4>';
                                    echo '<input type="hidden" name="id" value="'.$entrada['id'].'">';
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