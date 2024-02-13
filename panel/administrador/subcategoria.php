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
$id_subcategoria=$_POST['id'];
$registro_subcategoria=$conn->query("SELECT * FROM subcategorias WHERE id=$id_subcategoria");
$subcategoria=$registro_subcategoria->fetch_assoc();

if (isset($_POST['modificar_subcategoria'])) 
{
    // Obtener los datos del formulario
    $id_categoria = $_POST['categoria'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['aclaracion'];
    $color = $_POST['color'];
    $id = $_POST['id'];

    // Actualizar el plan en la base de datos
    $sql = "UPDATE subcategorias SET id_categoria = ?, subcategoria = ?, aclaracion = ?, color = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi",$id_categoria, $titulo, $subtitulo, $color, $id);
    $stmt->execute();

    // Redirigir a la página de planes después de la modificación
    header('Location: subcategorias');
    exit;
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
                    <form action="subcategoria.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Modificar Subcategorias</h2>
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
                        <input type="text" name="titulo" id="titulo" value="<?php echo $subcategoria['subcategoria'] ?>">
                        <label for="aclaracion">Aclaracion</label>
                        <input type="text" name="aclaracion" id="aclaracion" value="<?php echo $subcategoria['aclaracion'] ?>">
                        <label for="color">Color de Etiqueta</label>
                        <input type="color" name="color" id="color" value="<?php echo $subcategoria['color'] ?>">
                        <input type="hidden" name="id" value="<?php echo $subcategoria['id'] ?>">
                        <button type="submit" name="modificar_subcategoria">Modificar Subcategoria</button>
                        <a href="eliminar_subcategoria.php?id=<?php echo $subcategoria['id'] ?>">Eliminar Subcategoria</a>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>