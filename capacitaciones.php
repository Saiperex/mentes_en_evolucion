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
    <section class="seccion destacados">
            <div class="seccion_centrado destacados_centrado">
                <div class="destacados_mid destacado1">
                    <h3>Capacitaciones</h3>
                    <h2>Explora Nuestras Capacitaciones</h2>
                    <p>Descubre una amplia selección diseñada para inspirar, educar y transformar. Desde tecnología hasta negocios, tenemos algo para cada interes.</p>
                </div>
                <div class="destacados_mid destacado2">
                    <?php
                    $tipo="Capacitacion";
                        $registro_cursos = $conn->query("SELECT * FROM capacitaciones WHERE tipo='$tipo'");
                        if($registro_cursos->num_rows>0)
                        {
                            while($curso=$registro_cursos->fetch_assoc())
                            {
                                echo '<a href="curso.php?id='.$curso['id'].'" class="card_curso">';
                                    echo '<h2>'.$curso['titulo'].'</h2>';
                                    $registro_categoria=$conn->query("SELECT * FROM categorias WHERE id={$curso['id_categoria']}");
                                    if($registro_categoria->num_rows>0)
                                    {
                                        $categoria=$registro_categoria->fetch_assoc();
                                         echo '<h3 style="border:solid 1px #fff; box-shadow: 0 0 10px '.$categoria['color'].', inset 0 0 10px '.$categoria['color'].'">'.$categoria['categoria'].'</h3>';
                                    }
                                    $registros_subcategorias=$conn->query("SELECT * FROM subcategoria_capa WHERE id_capa={$curso['id'] }");
                                    if($registros_subcategorias->num_rows>0)
                                    {
                                        while($subcategoria=$registros_subcategorias->fetch_assoc())
                                        {
                                            $sub_reg=$conn->query("SELECT * FROM subcategorias WHERE id={$subcategoria['id_subcategoria']} ");
                                            $sub=$sub_reg->fetch_assoc();
                                            echo '<h4 style="border:solid 1px #fff; box-shadow:0 0 10px '.$sub['color'].',inset 0 0 10px '.$sub['color'].'">'.$sub['subcategoria'].'</h4>';
                                        }
                                    }
                                    echo '<p>'.$curso['descripcion'].'</p>';
                                echo '</a>';
                            }
                        }
                        else
                        {
                            echo '<div class="card_curso">
                            Proximamente nuevos Cursos
                            </div>';
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