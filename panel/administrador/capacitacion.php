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
$id=$_GET['id'];
$registro=$conn->query("SELECT * FROM capacitaciones WHERE id=$id");
$capacitacion=$registro->fetch_assoc();

$registros_categorias=$conn->query("SELECT * FROM categorias");


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
                    <form action="cargar_curso.php" class="entrada" method="post">
                        <h2>Agregar curso o capa</h2>
                        <label for="pregunta">Quieres modificar el tipo?</label>
                        <label class="curso" for="curso">Curso</label>
                        <label class="capacitacion" for="capacitacion">Capacitacion</label>
                        <input class="tipo" class="tipo" type="hidden" name="tipo" value="<?php echo $capacitacion['tipo'] ?>">
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo" value="<?php echo $capacitacion['titulo'] ?>">
                        <label for="subtitulo">Subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo"  value="<?php echo $capacitacion['subtitulo'] ?>">
                        <label for="descripcion">Descripcion</label>
                        <br>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10"><?php echo $capacitacion['descripcion'] ?></textarea>
                        <br>
                        <label for="categoria">Seleccione categoria</label>
                        <select name="categoria" id="categoria">
                            <?php
                                if($registros_categorias->num_rows>0)
                                {
                                    while($categoria=$registros_categorias->fetch_assoc())
                                    {
                                        echo '<option value="'.$categoria['id'].'">'.$categoria['categoria'].'</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="-1">Sin categorias</option>';
                                }
                            ?>
                        </select>
                        <button type="submit" class="cargar_capa" name="cargar_capa">Modificar Capa</button>
                        <a href="eliminar_capa.php?id=<?php echo $capacitacion['id']?>">Eliminar</a>
                    </form>
                </div>
                <div class="contenido_planes cargar_plan contenedor_subcategorias_capa">
                    <form action="cargar_subcategorias.php" class="entrada" method="post">
                        <h2>Selecciona las subcategorias para "<?php echo $capacitacion['titulo'] ?>"</h2>
                        <label for="subcategorias">Subcategorias</label>
                        <select name="subcategorias" id="subcategorias">
                            <?php
                                $obtener_subcategorias=$conn->query("SELECT * FROM subcategorias WHERE id_categoria={$capacitacion['id_categoria']} ");
                                if($obtener_subcategorias->num_rows>0)
                                {
                                    while($subcategoria=$obtener_subcategorias->fetch_assoc())
                                    {
                                        echo '<option value="'.$subcategoria['id'].'">'.$subcategoria['subcategoria'].'</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="-1">Esta categoria esta vacia</option>';
                                }
                            ?>
                        </select>
                        <input type="hidden" name="id_capa" value="<?php echo $capacitacion['id'] ?>">
                        <button type="submit">Agregar</button>
                    </form>
                    <div class="contenedor_subcategorias">
                        <?php
                            $registros_sub_capa=$conn->query("SELECT * FROM  subcategoria_capa WHERE id_capa=$id");
                            if($registros_sub_capa->num_rows>0)
                            {
                                while($sub=$registros_sub_capa->fetch_assoc())
                                {
                                    $sub_categoria_registro=$conn->query("SELECT * FROM subcategorias WHERE id={$sub['id_subcategoria']} ");
                                    $sub_categoria=$sub_categoria_registro->fetch_assoc();
                                    echo '<a style="box-shadow:0 0 20px'.$sub_categoria['color'].';border-color:'.$sub_categoria['color'].'; background:#fff; color:'.$sub_categoria['color'].';" href="eliminar_capa_sub.php?id='.$sub['id'].'">'.$sub_categoria['subcategoria'].'</a>';
                                }
                            }
                            else
                            {
                        
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>