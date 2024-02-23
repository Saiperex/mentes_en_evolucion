<?php
include ('php/conexion.php');
// Inicializar el array $redes
$redes = array(
    'facebook' => '',
    'twitter' => '',
    'instagram' => '',
    'whatsapp' => '',
    'telefono' => '',
    'correo' => ''
);

// Consultar los datos de las redes sociales
$resultado = $conn->query("SELECT * FROM redes");
if ($resultado->num_rows > 0) {
    // Si hay registros, obtener los datos y almacenarlos en el array $redes
    $redes = $resultado->fetch_assoc();
} else {
    // Si no hay registros, establecer valores predeterminados
    $redes = array(
        'facebook' => 'facebook',
        'twitter' => 'twitter',
        'instagram' => 'instagram',
        'whatsapp' => 'whatsapp',
        'telefono' => 'telefono',
        'correo' => 'correo'
    );
}
$id=$_GET['id'];
$registro_blog=$conn->query("SELECT * FROM entrada WHERE id= $id");
$entrada=$registro_blog->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--ICON-->
    <link rel="shortcut icon" href="img/recursos/logo2.png" type="image/x-icon">
    <!--ICONS-->
    <script src="https://kit.fontawesome.com/c8bf7962f3.js" crossorigin="anonymous"></script>
    <!--FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Open+Sans:wght@300&family=Raleway:wght@300&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="css/init.css">
    <link rel="stylesheet" href="css/estilos.css">
    <!--META-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTES EN EVOLUCION - PREPARANDOTE PARA EL FUTURO</title>
</head>
<body>
    <header>
        <?php include ("elementos/menu.php")?>
    </header>
    <main>
    <section class="seccion destacados">
            <div class="seccion_centrado destacados_centrado">
                <div class="destacados_mid destacado1">
                    <h3><?php echo $entrada['fecha'] ?></h3>
                    <h2><?php echo $entrada['titulo'] ?></h2>
                    <h2><?php echo $entrada['subtitulo'] ?></h2>
                    <p><?php echo $entrada['contenido'] ?></p>
                </div>
                <div class="destacados_mid destacado2 entrada">
                    <?php
                        $ubicacion="entradas/".$entrada['id'];
                        // Obtener la lista de archivos en la carpeta
                        $archivos = scandir($ubicacion);
                        // Recorrer cada archivo y generar el HTML correspondiente
                        foreach ($archivos as $archivo) {
                            // Ignorar los directorios "." y ".."
                            if ($archivo == "." || $archivo == "..") {
                                continue;
                            }

                            // Obtener la extensión del archivo
                            $extension = pathinfo($ubicacion . "/" . $archivo, PATHINFO_EXTENSION);

                            // Generar el HTML según el tipo de archivo
                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                // Es una imagen
                                echo '<img src="' . $ubicacion . '/' . $archivo . '" alt="' . $archivo . '">';
                            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'mkv'])) {
                                // Es un video
                                echo '<video controls>';
                                echo '<source src="' . $ubicacion . '/' . $archivo . '" type="video/mp4">';
                                echo 'Tu navegador no soporta el formato de video.';
                                echo '</video>';
                            } else {
                                // Es otro tipo de archivo
                                echo '<a href="' . $ubicacion . '/' . $archivo . '" target="_blank"><i class="fa-solid fa-file"></i> ' . $archivo . '</a>';
                            }
                        }
                        
                    ?>
                </div>
            </div>
        </section>
    </main>
    <footer class="pie">
        <div class="pie_mid">
            <div class="pie_sector">
                <a class="logo_footer" href="index.php"><img src="img/recursos/logo2.png" alt="logo Mentes_En_Evolucion"></a>
                <p>En Mentes en Evolución, nos dedicamos a potenciar el aprendizaje continuo y el crecimiento personal y profesional. Con una amplia gama de cursos de alta calidad y una comunidad comprometida, estamos aquí para ayudarte a alcanzar tus metas y evolucionar hacia tu mejor versión. Únete a nosotros y comienza tu viaje hacia un futuro lleno de oportunidades y descubrimiento.</p>
                <h3>Sitio Web realizado</h3>
                <a class="logo_agnis" href="https://www.aginis.tech">AGNIS &copy</a>
            </div>
            <div class="pie_sector">
                <h3>Secciones</h3>
                <a class="enlace" href="">Cursos</a>
                <a class="enlace" href="">Capacitaciones</a>
                <a class="enlace" href="">Planes</a>
                <a class="enlace" href="">Blog</a>
                <a class="enlace" href="">Politicas de privacidad</a>
            </div>
            <div class="pie_sector">
                <h3>Contacto</h3>
                <a class="enlace" href="tel:<?php echo $redes['telefono'] ?>"><?php echo $redes['telefono'] ?></a>
                <a class="enlace" href="https://www.facebook.com/<?php echo $redes['facebook'] ?>">@MentesEnEvolucion</a>
                <a class="enlace" href="https://www.instagram.com/<?php echo $redes['instagram'] ?>">@MentesEnEvolucion</a>
                <a class="enlace" href="mailto:<?php echo $redes['correo'] ?>"><?php echo $redes['correo'] ?></a>
            </div>
        </div>
    </footer>
</body>
</html>