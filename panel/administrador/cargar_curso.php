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
if(isset($_POST['cargar_capa']))
{
    $tipo=$_POST['tipo'];
    $titulo=$_POST['titulo'];
    $subtitulo=$_POST['subtitulo'];
    $descripcion=$_POST['descripcion'];
    $id_categoria=$_POST['categoria'];

    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO capacitaciones (tipo, titulo, subtitulo, descripcion, id_categoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Enlazar los parámetros
    $stmt->bind_param("ssssi", $tipo, $titulo, $subtitulo, $descripcion, $id_categoria);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: cargar_curso');
        exit;
    } else {
        // Si hay un error en la inserción, mostrar un mensaje de error o manejarlo de acuerdo a tus necesidades
        header('Location: ../error');
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
$registros_categorias=$conn->query("SELECT * FROM categorias");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <label for="pregunta">Que quieres cargar?</label>
                        <label class="curso" for="curso">Curso</label>
                        <label class="capacitacion" for="capacitacion">Capacitacion</label>
                        <input class="tipo" class="tipo" type="hidden" name="tipo" value="Curso">
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" id="titulo">
                        <label for="subtitulo">Subtitulo</label>
                        <input type="text" name="subtitulo" id="subtitulo">
                        <label for="descripcion">Descripcion</label>
                        <br>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
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
                        <button type="submit" class="cargar_capa" name="cargar_capa">Agregar Capa</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM capacitaciones");
                        if($registros->num_rows>0)
                        {
                            while($capacitacion=$registros->fetch_assoc())
                            {
                                echo '<form action="capacitacion.php"  method="get" class="plan">';
                                    echo '<h2>'.$capacitacion['titulo'].'</h2>';
                                    echo '<h3>'.$capacitacion['tipo'].'</h3>';
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
                                    echo '<h3>'.$capacitacion['subtitulo'].'</h3>';
                                    echo '<h4>'.$capacitacion['descripcion'].'</h4>';
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
<script>
    document.addEventListener("DOMContentLoaded", function() 
    {
        const curso = document.querySelector('.curso');
        const capacitacion = document.querySelector('.capacitacion');
        const input_valor = document.querySelector('.tipo');
        
        curso.addEventListener("click", function() {
            input_valor.value = "Curso";
            sombra(); // Llama a la función sombra después de establecer el valor
        });
        
        capacitacion.addEventListener("click", function() {
            input_valor.value = "Capacitacion";
            sombra(); // Llama a la función sombra después de establecer el valor
        });
        
        function sombra() {
            if (input_valor.value === "Curso") {
                curso.style.boxShadow = "0 0 20px #00e8c1";
                capacitacion.style.boxShadow = "0 0 0px transparent";
            } else if (input_valor.value === "Capacitacion") {
                capacitacion.style.boxShadow = "0 0 20px #00e8c1";
                curso.style.boxShadow = "0 0 0px transparent";
            }
        }
    });
</script>

</html>