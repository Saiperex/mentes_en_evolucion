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

$registro=$conn->query("SELECT * FROM usuarios WHERE id={$_POST['id']} ");
$datos=$registro->fetch_assoc();
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
                    <form action="usuario.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Usuario</h2>
                        <label for="usuario"><?php echo $datos['usuario'] ?></label>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros = $conn->query("SELECT * FROM cursos_asignados WHERE id_alumno = {$datos['id']}");
                        if($registros->num_rows>0)
                        {
                            while($cursos=$registros->fetch_assoc())
                            {
                                echo '<form action="eliminar_curso.php"  method="post" class="plan">';
                                $reg_curso=$conn->query("SELECT * FROM capacitaciones WHERE id={$cursos['id_curso']}");
                                $nombre_curso=$reg_curso->fetch_assoc();
                                    echo '<h2>Curso: '.$nombre_curso['titulo'].'</h2>';
                                    
                                    echo '<input type="hidden" name="id_curso" value="'.$cursos['id'].'">';
                                    echo '<button type="submit">Eliminar</button>';
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