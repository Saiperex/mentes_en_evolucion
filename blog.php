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
        <section class="seccion inicio">
            <div class="seccion_centrado inicio_centrado">
                <div class="inicio_izq">
                <h1>¡Enterate de todas nuestras novedades!</h1>
                <p>Descubre los últimos artículos y publicaciones en nuestra sección de blogs.</p>
                <div class="conteiner_cards_inicio">
                    <div class="card_inicio">
                        <i class="graduation fas fa-graduation-cap"></i>
                        <h2>Últimos Artículos</h2>
                        <p>Explora nuestra colección de los últimos artículos y publicaciones en una variedad de temas.</p>
                    </div>
                    <div class="card_inicio">
                        <i class="teacher fas fa-chalkboard-teacher"></i>
                        <h2>Escritos por Expertos</h2>
                        <p>Lee los artículos redactados por profesionales y expertos en diversos campos y disciplinas.</p>
                    </div>
                    <div class="card_inicio">
                        <i class="globe fas fa-globe"></i>
                        <h2>Disponibles en Todo el Mundo</h2>
                        <p>Accede a nuestros artículos desde cualquier lugar del mundo, sin restricciones geográficas.</p>
                    </div>
                    <div class="card_inicio">
                        <i class="clock fas fa-clock"></i>
                        <h2>A Tu Propio Ritmo</h2>
                        <p>Disfruta de nuestros artículos en cualquier momento y en cualquier lugar, adaptándose a tu horario.</p>
                    </div>
                    <div class="card_inicio">
                        <i class="users fas fa-users"></i>
                        <h2>Comunidad de Lectores</h2>
                        <p>Conéctate con otros lectores y comparte ideas en nuestra activa comunidad de lectores.</p>
                    </div>
                </div>
                </div>
                <div class="inicio_der">
                    <object data="img/recursos/blog.svg" type="image/svg+xml"></object>
                </div>
            </div>
        </section>
        <section class="seccion destacados">
            <div class="seccion_centrado destacados_centrado">
                <div class="destacados_mid destacado1">
                    <h2>Nuestros Articulos</h2>
                    <p>Descubre que novedades tenemos, que tenemos para decirte y que opinan los demas</p>
                </div>
                <div class="destacados_mid destacado2">
                    <?php
                        $registro_entradas = $conn->query("SELECT * FROM entrada ORDER BY fecha DESC ");
                        if($registro_entradas->num_rows>0)
                        {
                            while($entrada=$registro_entradas->fetch_assoc())
                            {
                                echo '<a href="entrada.php?id='.$entrada['id'].'" class="card_curso">';
                                    echo '<h2>'.$entrada['titulo'].'</h2>';
                                    echo '<h3>'.$entrada['fecha'].'</h3>';
                                    echo '<p>'.$entrada['subtitulo'].'</p>';
                                    echo '<legend> VER</legend>';
                                echo '</a>';
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
        <section class="seccion contacto">
            <div class="seccion_centrado contacto_centrado">
                <div class="contacto_izq">
                <!-- Formulario de contacto -->
                <form action="enviar.php" method="post">
                    <h2>Escribenos</h2>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>

                    <button type="submit">Enviar</button>
                </form>
                </div>
                <div class="contacto_der">
                <!-- Enlaces a redes sociales -->
                <ul class="redes_sociales">
                    <li class="facebook"><a href="https://www.facebook.com/<?php echo $redes['facebook'] ?>"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="twitter"><a href="https://www.x.com/<?php echo $redes['twitter'] ?>"><i class="fab fa-twitter"></i></a></li>
                    <li class="instagram"><a href="https://www.instagram.com/<?php echo $redes['instagram'] ?>"><i class="fab fa-instagram"></i></a></li>
                    <!-- Agrega más enlaces según sea necesario -->
                </ul>
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