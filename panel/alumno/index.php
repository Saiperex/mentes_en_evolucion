<?php
session_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) 
{
    header('Location: ../login');
    exit;
}
if ($_SESSION['rol'] != 2) 
    {
        header('Location: ../error');
        exit;
    }
include ('../../php/conexion.php');
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
    <title>PANEL AGENTE</title>
</head>
<body>
    <?php include('menu.php') ?>
    <main class="principal">
        <div class="contenido_padre">
            <div class="contenido_hijo">
                <div class="contenido_cursos">
                    <div class="mis_cursos">
                        <?php
                            $id=$_SESSION['id'];
                            $registro_asignados=$conn->query("SELECT * FROM cursos_asignados WHERE id_alumno=$id");
                            if($registro_asignados->num_rows>0)
                            {
					            while($curso=$registro_asignados->fetch_assoc())
                                {
                                    $registro_curso=$conn->query("SELECT * FROM capacitaciones WHERE id={$curso['id_curso']}");
                                    $datos_curso=$registro_curso->fetch_assoc();
                                    echo '<div style="border:solid 3px #fff" class="categoria">';
                                        echo '<h2>'.$datos_curso['titulo'].'</h2>';
                                        echo '<h4>'.$datos_curso['subtitulo'].'</h4>';
                                        echo '<p>'.$datos_curso['descripcion'].'</p>';
                                        $registro_categoria=$conn->query("SELECT * FROM categorias WHERE id={$datos_curso['id_categoria']}");
                                        $categoria=$registro_categoria->fetch_assoc();
                                        echo '<h5 style="color:'.$categoria['color'].'">Categoria: '.$categoria['categoria'].'</h5>';
                                        echo '<a href="estudiar.php?id1='.$datos_curso['id'].'">Ingresar</a>';
                                    echo '</div>';
                                }
                            }
                            else
                            {
                                echo '<div style="border:solid 3px #fff" class="categoria">';
                                    echo 'No posee cursos';
                                echo '</div>';
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