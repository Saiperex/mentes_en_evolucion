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
if(isset($_POST['cargar_curso']))
{
    $id_usuario=$_POST['usuario'];
    $id_curso=$_POST['curso'];
    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO cursos_asignados (id_alumno,  id_curso) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    // Enlazar los parámetros
    $stmt->bind_param("ii", $id_usuario, $id_curso);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: asignar_curso');
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
    <title>PANEL AGENTE</title>
</head>
<body>
    <?php include('menu.php') ?>
    <main class="principal">
        <div class="contenido_padre">
            <div class="contenido_hijo">
            <div class="contenido_planes cargar_plan">
                    <form action="asignar_curso.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Asignar Cursos</h2>
                        <label for="usuario">Usuario</label>
                        <select name="usuario" id="usuario">
                            <?php
                                $registros_usuarios = $conn->query("SELECT * FROM usuarios WHERE rol = 2");
                                if($registros_usuarios->num_rows>0)
                                {
                                    while($user=$registros_usuarios->fetch_assoc())
                                    {
                                        
                                        echo '<option value="'.$user['id'].'">'.$user['usuario'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <label for="curso">Curso</label>
                        <select name="curso" id="curso">
                            <?php
                                $registros_capas = $conn->query("SELECT * FROM capacitaciones");
                                if($registros_capas->num_rows>0)
                                {
                                    while($capas=$registros_capas->fetch_assoc())
                                    {
                                        
                                        echo '<option value="'.$capas['id'].'">'.$capas['titulo'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <button type="submit" name="cargar_curso">Agregar Curso</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros = $conn->query("SELECT * FROM usuarios WHERE rol = 2");
                        if($registros->num_rows>0)
                        {
                            while($usuarios=$registros->fetch_assoc())
                            {
                                echo '<form action="modificar_asignados.php"  method="post" class="plan">';
                                    echo '<h2>Usuario: '.$usuarios['usuario'].'</h2>';
                                    echo '<input type="hidden" name="id" value="'.$usuarios['id'].'">';
                                    $reg_cursos=$conn->query("SELECT * FROM cursos_asignados WHERE id_alumno={$usuarios['id']}");
                                    if($reg_cursos->num_rows>0)
                                    {
                                        while($curso=$reg_cursos->fetch_assoc())
                                        {
                                            $reg_nombre=$conn->query("SELECT * FROM capacitaciones WHERE id={$curso['id_curso']}");
                                            $nombre=$reg_nombre->fetch_assoc();
                                            echo '<h2>'.$nombre['titulo'].'</h2>';
                                        }
                                        
                                    }
                                    else 
                                    {
                                        echo '<h2>No posee cursos asignados</h2>';
                                    }
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