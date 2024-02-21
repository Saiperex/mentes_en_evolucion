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
if(isset($_POST['cargar_usuario']))
{
    $usuario=$_POST['usuario'];
    $contraseña_sin_hash=$_POST['contraseña'];
    $rol=$_POST['rol'];
    // Generar el hash de la contraseña
    $hash_contraseña = password_hash($contraseña_sin_hash, PASSWORD_DEFAULT);
    // Preparar la consulta para insertar el nuevo plan
    $sql = "INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Enlazar los parámetros
    $stmt->bind_param("ssi", $usuario, $hash_contraseña, $rol);
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se inserta correctamente, redirigir a la página de planes
        header('Location: ../administrador');
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
                    <form action="index.php" method="post" class="entrada" enctype="multipart/form-data">
                        <h2>Nuevo Usuario</h2>
                        <label for="usuario">Usuario</label>
                        <input type="text" name="usuario" id="usuario">
                        <label for="contraseña">Contraseña</label>
                        <input type="text" name="contraseña" id="contraseña">
                        <label for="rol">Rol</label>
                        <select name="rol" id="rol">
                            <option value="0">Administrador</option>
                            <option value="1">Agente</option>
                            <option value="2">Alumno</option>
                        </select>
                        <button type="submit" name="cargar_usuario">Agregar Usuario</button>
                    </form>
                </div>
                <div class="contenido_planes ver_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM usuarios");
                        if($registros->num_rows>0)
                        {
                            while($usuarios=$registros->fetch_assoc())
                            {
                                echo '<form action="usuario.php"  method="post" class="plan">';
                                    echo '<h2>Usuario: '.$usuarios['usuario'].'</h2>';
                                    $user_rol;
                                    switch($usuarios['rol']) 
                                    {
                                        case 0:
                                            $user_rol="Administrador";
                                            break;
                                        case 1:
                                            $user_rol="Agente";
                                            break;
                                        case 2:
                                            $user_rol="Alumno";
                                            break;
                                        default:
                                            header('Location: error.php');
                                            break;
                                    }
                                    echo '<h3>Rol: '.$user_rol.'</h3>';
                                    echo '<input type="hidden" name="id" value="'.$usuarios['id'].'">';
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