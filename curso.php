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
$id_curso=$_GET['id'];
$registro=$conn->query("SELECT * FROM capacitaciones WHERE id= $id_curso");
$curso_info="";
if($registro->num_rows>0)
{
    $curso_info=$registro->fetch_assoc();
}
else
{
    header ('location: error');
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
</head>
<body>
    <header>
        <?php include ("elementos/menu.php")?>
    </header>
    <main>
        <section class="seccion inicio">
            <div class="seccion_centrado inicio_centrado">
                <div class="inicio_izq">
                    <h1><?php echo $curso_info['titulo'] ?></h1>
                    <h1><?php echo $curso_info['subtitulo'] ?></h1>
                    <p><?php echo $curso_info['descripcion'] ?></p>
                    <div class="conteiner_cards_inicio">
                        <?php
                            $registro_categoria=$conn->query("SELECT * FROM categorias WHERE id={$curso_info['id_categoria']} ");
                            if($registro_categoria->num_rows>0)
                            {
                                $categoria=$registro_categoria->fetch_Assoc();
                                echo 
                                '
                                <div class="card_inicio" style="border-color:#fff; box-shadow:0 0 30px '.$categoria['color'].',inset 0 0 30px '.$categoria['color'].'">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <h2>'.$categoria['categoria'].'</h2>
                                    <p>'.$categoria['aclaracion'].'</p>
                                </div>
                                ';
                            }
                            else
                            {
                                $categoria=$registro_categoria->fetch_Assoc();
                                echo 
                                '
                                <div class="card_inicio" style="border-color:#fff;">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <h2>No posee gategoria</h2>
                                </div>
                                ';
                            }
                            $registro_subcategoria=$conn->query("SELECT * FROM subcategoria_capa WHERE id_capa={$curso_info['id']} ");
                            if($registro_subcategoria->num_rows>0)
                            {
                                while($subcategoria=$registro_subcategoria->fetch_assoc())
                                {
                                    $sub=$conn->query("SELECT * FROM subcategorias WHERE id={$subcategoria['id_subcategoria'] }");
                                    $sub_result=$sub->fetch_assoc();
                                    echo 
                                    '
                                    <div class="card_inicio" style="border-color:#fff; box-shadow:0 0 30px '.$sub_result['color'].',inset 0 0 30px '.$sub_result['color'].'">
                                        <i class="fa-solid fa-diagram-next"></i>
                                        <h2>'.$sub_result['subcategoria'].'</h2>
                                        <p>'.$sub_result['aclaracion'].'</p>
                                    </div>
                                    ';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="inicio_der">
                    <object data="img/recursos/curso.svg" type="image/svg+xml"></object>
                </div>
            </div>
            <div class="path1"></div>
        </section>
        <section class="seccion contacto">
            <div class="seccion_centrado contacto_centrado">
                <div class="contacto_izq">
                <!-- Formulario de contacto -->
                <form action="enviar.php" method="post">
                    <h2>Te interesa este curso?</h2>
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