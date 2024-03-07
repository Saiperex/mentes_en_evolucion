<?php
// Incluir el archivo de conexión a la base de datos
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
    <title>MENTES EN EVOLUCION</title>
</head>
<body>
    <?php include('menu_curso.php') ?>
    <main class="principal">
        <div class="contenido_padre">
            <div class="contenido_hijo">
                <div class="contenido_planes contenido_clase">
                        <?php
                            if(isset($_GET['id_clase']))
                            {
                                $id_clase = $_GET['id_clase'];
                                // Consultar el registro de la tabla clases que coincida con el ID
                                $sql = "SELECT * FROM clases WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $id_clase);
                                $stmt->execute();
                                $resultado = $stmt->get_result();
                                $clase;
                                // Verificar si se encontraron resultados
                                if ($resultado->num_rows > 0) {
                                    // Obtener el registro de la clase
                                    $clase = $resultado->fetch_assoc();
                                } else 
                                {
                                    // Si no se encontraron resultados, mostrar un mensaje o realizar alguna acción
                                    echo "No se encontraron registros para el ID proporcionado.";
                                }
                                echo '<h2>'.$clase['titulo'].'</h2>';
                                // Obtener la ruta de la carpeta de archivos
                                echo '<div class="archivos_clase">';
                                $ruta_archivos = '../../clases/' . $clase['id_capa'] . '/' . $clase['id_modulo'] . '/' . $id_clase . '/';
                                                        
                                // Verificar si la carpeta existe
                                if (is_dir($ruta_archivos)) 
                                {
                                    // Obtener y mostrar los archivos de la carpeta
                                    $archivos = scandir($ruta_archivos);
                                    foreach ($archivos as $archivo) 
                                    {
                                        // Excluir los directorios '.' y '..'
                                        if ($archivo != '.' && $archivo != '..') 
                                        {
                                            // Verificar si es un archivo de imagen
                                            if (preg_match("/\.(jpg|jpeg|png|gif)$/i", $archivo)) {
                                                echo '<img src="' . $ruta_archivos . $archivo . '" alt="' . $archivo . '">';
                                            }
                                            // Verificar si es un archivo de video
                                            elseif (preg_match("/\.(mp4|avi|mov)$/i", $archivo)) {
                                                echo '<video controls><source src="' . $ruta_archivos . $archivo . '" type="video/mp4"></video>';
                                            }
                                            // Si no es ni imagen ni video, mostrar un enlace para abrirlo
                                            else {
                                                echo '<a href="' . $ruta_archivos . $archivo . '" target="_blank">' . $archivo . '</a><br>';
                                            }
                                        }
                                    }
                                } 
                                else 
                                {
                                    echo "Esta clase no posee archivos";
                                }
                                
                            }
                            else
                            {
                                echo 'bienvenido';
                            }
                            echo '</div>';
                        ?>
                        
                </div>
                <div class="contenido_planes ver_planes">
                    <p>
                        
                        <?php 
                            if(isset($_GET['id_clase']))
                            {
                                $id_clase = $_GET['id_clase'];
                                // Consultar el registro de la tabla clases que coincida con el ID
                                $sql = "SELECT * FROM clases WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $id_clase);
                                $stmt->execute();
                                $resultado = $stmt->get_result();
                                $clase;
                                // Verificar si se encontraron resultados
                                if ($resultado->num_rows > 0) {
                                    // Obtener el registro de la clase
                                    $clase = $resultado->fetch_assoc();
                                } else 
                                {
                                    // Si no se encontraron resultados, mostrar un mensaje o realizar alguna acción
                                    echo "No se encontraron registros para el ID proporcionado.";
                                }
                                echo $clase['contenido'];
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../js/slider.js"></script>
</html>