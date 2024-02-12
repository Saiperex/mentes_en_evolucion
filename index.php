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
$resultado_video = $conn->query("SELECT * FROM video_inicio");
$video = $resultado_video->fetch_assoc();
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
                    <h1>¡Explora tu potencial!</h1>
                    <p>Descubre cursos y capacitaciones que impulsarán tu crecimiento en Mentes en Evolución.</p>
                    <div class="conteiner_cards_inicio">
                        <div class="card_inicio">
                            <i class="graduation fas fa-graduation-cap"></i>
                            <h2>Cursos Variados</h2>
                            <p>Explora nuestra amplia variedad de cursos para impulsar tu aprendizaje en diferentes áreas.</p>
                        </div>
                        <div class="card_inicio">
                            <i class="teacher fas fa-chalkboard-teacher"></i>
                                <h2>Profesores Expertos</h2>
                                <p>Aprende de profesionales altamente calificados que guiarán tu camino hacia el conocimiento.</p>
                        </div>
                        <div class="card_inicio">
                            <i class="globe fas fa-globe"></i>
                            <h2>Acceso Global</h2>
                            <p>Disfruta de nuestros cursos desde cualquier lugar del mundo, sin límites geográficos.</p>
                        </div>
                        <div class=" card_inicio">
                            <i class="clock fas fa-clock"></i>
                            <h2>Aprendizaje Flexible</h2>
                            <p>Adapta tus horarios con nuestros cursos flexibles diseñados para tu comodidad.</p>
                        </div>
                        <div class="card_inicio">
                            <i class="users fas fa-users"></i>
                            <h2>Comunidad Activa</h2>
                            <p>Únete a una vibrante comunidad de estudiantes y profesionales compartiendo conocimientos.</p>
                        </div>
                    </div>
                </div>
                <div class="inicio_der">
                    <object data="img/recursos/inicio.svg" type="image/svg+xml"></object>
                </div>
            </div>
            <div class="path1"></div>
        </section>
        <section class="seccion nosotros">
            <div class="seccion_centrado nosotros_centrado">
                <div class="nosotros_izq">
                    <video src="<?php echo $video['video_url'] ?>" controls></video>
                </div>
                <div class="nosotros_der">
                    <h2>Forjando un Futuro de Conocimiento"</h2>
                    <p>En Mentes en Evolución, creemos en el poder transformador de la educación. Nuestra misión es proporcionar un espacio donde la curiosidad se encuentra con la excelencia, y donde cada mente tiene el potencial de evolucionar y crecer. Nos enorgullece ser una plataforma de aprendizaje que no solo enseña, sino que inspira, conecta y construye comunidades de conocimiento. Descubre una experiencia educativa única, diseñada para impulsar tu desarrollo personal y profesional. Bienvenido a Mentes en Evolución, donde el aprendizaje es más que un acto, es un viaje continuo hacia el descubrimiento y la evolución constante.</p>
                    <a href="#">Nuestra metodologia</a>
                </div>
                <div class="nosotros_mid">
                    <div class="nosotros_card">
                        <i class="fas fa-lightbulb"></i>
                        <h3>Nuestra Misión</h3>
                        <p>Guiar a las mentes curiosas hacia la luz del conocimiento, inspirando el aprendizaje continuo y la evolución personal.</p>
                    </div>

                    <div class="nosotros_card">
                        <i class="fas fa-users"></i>
                        <h3>Nuestra Comunidad</h3>
                        <p>Construir una comunidad vibrante donde el intercambio de conocimientos y la colaboración florezcan entre nuestros estudiantes y profesores.</p>
                    </div>

                    <div class="nosotros_card">
                        <i class="fas fa-rocket"></i>
                        <h3>Nuestra Visión</h3>
                        <p>Impulsar el crecimiento y el progreso, siendo la plataforma líder que cataliza la evolución constante de las mentes ávidas de aprender.</p>
                    </div>
                </div>
            </div>
            <div class="path2"></div>
        </section>
        <section class="seccion destacados">
            <div class="seccion_centrado destacados_centrado">
                <div class="destacados_mid destacado1">
                    <h3>Cursos Destacados</h3>
                    <h2>Explora Nuestros Cursos Más Populares</h2>
                    <p>Descubre una amplia selección de cursos diseñados para inspirar, educar y transformar. Desde tecnología hasta negocios, tenemos algo para cada interes.</p>
                </div>
                <div class="destacados_mid destacado2">
                    <a href="" class="card_curso"></a>
                    <a href="" class="card_curso"></a>
                    <a href="" class="card_curso"></a>
                    <a href="" class="card_curso"></a>
                    <a href="" class="card_curso"></a>
                    <a href="" class="card_curso"></a>
                    <a href="" class="card_curso ver_cursos">
                        <h2>Ver +</h2>
                    </a><!--Ver mas cursos-->
                </div>
            </div>
        </section>
        <section class="seccion testimonios">
            <div class="seccion_centrado testimonios_Centrado">
                <div class="testimonios_izq">
                    <h2>¡Todos hablan sobre nosotros!</h2>
                    <h3>Descubre lo que dicen nuestros estudiantes</h3>
                    <p>Mentes en Evolución ha sido una experiencia transformadora para muchos estudiantes. Nuestros cursos son excelentes y los profesores están siempre dispuestos a ayudar. Pero no solo lo decimos nosotros, ¡escucha lo que nuestros estudiantes tienen que decir sobre su experiencia con nosotros!</p>
                    <p>Sumérgete en los testimonios auténticos y descubre cómo Mentes en Evolución ha impactado positivamente la vida de nuestros estudiantes, ayudándoles a alcanzar sus metas y avanzar en sus carreras.</p>
                </div>
                <div class="testimonios_der">
                    <div class="testimonio_card">
                        <h2>Nombre del alumno</h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi ipsam ipsa eligendi quis nesciunt animi sed quibusdam libero eum? Ex perferendis dolores architecto, ut nihil iure officiis dicta distinctio ullam.</p>
                    </div>
                    <div class="testimonio_card">
                        <h2>Nombre del alumno</h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi ipsam ipsa eligendi quis nesciunt animi sed quibusdam libero eum? Ex perferendis dolores architecto, ut nihil iure officiis dicta distinctio ullam.</p>
                    </div>
                    <div class="testimonio_card">
                        <h2>Nombre del alumno</h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi ipsam ipsa eligendi quis nesciunt animi sed quibusdam libero eum? Ex perferendis dolores architecto, ut nihil iure officiis dicta distinctio ullam.</p>
                    </div>
                    <div class="testimonio_card">
                        <h2>Nombre del alumno</h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nisi ipsam ipsa eligendi quis nesciunt animi sed quibusdam libero eum? Ex perferendis dolores architecto, ut nihil iure officiis dicta distinctio ullam.</p>
                    </div>
                </div>
            </div>
            <div class="path1"></div>
        </section>
        <section class="seccion planes">
            <div class="seccion_centrado testimonio_centrado">
                <div class="planes_mid">
                    <h3>Planes</h3>
                    <h2>Puedes comenzar ahora a prepararte para el futuro</h2>
                    <p>Elige el plan que mas te guste y se amolde a tus necesidades</p>
                </div>
                <div class="planes_mid contenedor_planes">
                    <?php
                        $registros=$conn->query("SELECT * FROM planes");
                        if($registros->num_rows>0)
                        {
                            while($plan=$registros->fetch_assoc())
                            {
                                echo '<div class="plan">';
                                    echo '<h2>'.$plan['titulo'].'</h2>';
                                    echo '<p>'.$plan['subtitulo'].'</p>';
                                    echo '<h3>'.$plan['precio'].'</h3>';
                                    echo '<ol>';
                                        echo '<li><i class="fa-solid fa-check"></i>'.$plan['d1'].'</li>';
                                        echo '<li><i class="fa-solid fa-check"></i>'.$plan['d2'].'</li>';
                                        echo '<li><i class="fa-solid fa-check"></i>'.$plan['d3'].'</li>';
                                        echo '<li><i class="fa-solid fa-check"></i>'.$plan['d4'].'</li>';
                                        echo '<li><i class="fa-solid fa-check"></i>'.$plan['d5'].'</li>';
                                    echo '</ol>';
                                    echo '<a href="https://api.whatsapp.com/send?phone=+54'.$redes['whatsapp'].'&text=Estoy interesado en adquirir el plan: '.$plan['titulo'].'">Obtener Plan</a>';
                                echo '</div>';
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