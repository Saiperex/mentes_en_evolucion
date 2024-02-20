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
$registros_capas=$conn->query("SELECT * FROM capacitaciones");
if(isset($_POST['cargar_modulo']))
{
    $capa=$_POST['capa'];
    $titulo=$_POST['titulo'];
    $subtitulo=$_POST['subtitulo'];

    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO modulo (id_capa, titulo, subtitulo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Enlazar los parámetros
    $stmt->bind_param("iss", $capa, $titulo, $subtitulo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: cargar_modulos');
        exit;
    } else {
        // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
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
                    <form action="cargar_modulos.php" class="entrada" method="post">
                        <h2>Agregar modulos</h2>
                        <label for="capa">Seleccione capa</label>
                        <select name="capa" id="capa">
                            <?php
                                if($registros_capas->num_rows>0)
                                {
                                    while($capas=$registros_capas->fetch_assoc())
                                    {
                                        echo '<option value="'.$capas['id'].'">'.$capas['titulo'].'</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="-1">Sin categorias</option>';
                                }
                            ?>
                        </select>
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo">
                        <label for="subtitulo">Subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo">
                        
                        <button type="submit" class="cargar_capa" name="cargar_modulo">Agregar Capa</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM capacitaciones");
                        if($registros->num_rows>0)
                        {
                            while($capacitacion=$registros->fetch_assoc())
                            {
                                echo '<form action="cargar_clases.php"  method="get" class="plan">';
                                    echo '<h2>'.$capacitacion['titulo'].'</h2>';
                                    $registro=$conn->query("SELECT * FROM categorias WHERE id={$capacitacion['id_categoria']} ");
                                    if($registro->num_rows>0)
                                    {
                                        $categoria=$registro->fetch_assoc();
                                        echo '<h3 style="color:'.$categoria['color'].';" >'.$categoria['categoria'].'</h3>';
                                    }
                                    else
                                    {
                                        echo '<h3>Sin categoria</h3>';
                                    }
                                    $registro_modulo=$conn->query("SELECT * FROM modulo WHERE id_capa={$capacitacion['id']}");
                                    if($registro_modulo->num_rows>0)
                                    {
                                         echo '<h3> posee ' . $registro_modulo->num_rows . ' modulo(s)</h3>';
                                    }
                                    else
                                    {
                                        echo '<h3>No posee modulos</h3>';
                                    }
                                    echo '<input type="hidden" name="id" value="'.$capacitacion['id'].'">';
                                    echo '<button type="submit">Comenzar</button>';
                                echo '</form>';
                            }
                        }
                        else
                        {
                            echo '<form action="capacitacion.php"  method="post" class="plan">';
                                    echo '<h2>No Posee Planes</h2>';
                                    
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