<?php
session_start();
$texto="";

if(!isset($_SESSION['id']) || empty($_SESSION['id']))
{
  $texto="Iniciar Sesión";
}
else
{
  $texto="Panel";
}
?>
<div class="slide_button">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
</div>
<nav class="cabecera">
    <a class="logo" href="index.php"><img src="img/recursos/logo2.png" alt="logo Mentes_En_Evolucion"></a>
    <ul>
        <div class="buscador">
            <form action="" method="post">
                <input type="text" name="buscador" id="buscador">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <li><a href="Cursos">Cursos</a></li>
        <li><a href="Capacitaciones">Capacitaciones</a></li>
        <li><a href="Planes">Planes</a></li>
        <li><a href="blog">blog</a></li>
        <li class="login"><a href="panel"><?php echo $texto?></a></li>
    </ul>
</nav>
<script>
  const slideButton = document.querySelector('.slide_button');
  const header = document.querySelector('header');

  slideButton.addEventListener('click', () => {
    // Cambiar las líneas para formar una X
    slideButton.classList.toggle('activado');
    validador();
  });

  function validador() {
    if (slideButton.classList.contains('activado')) { // Corrección aquí
        header.style.left = '0';
    } else {
        header.style.left = '-100%';
    }
  }

  // Llama a validador() para establecer la posición inicial al cargar la página
  validador();
  function verificarAncho() {
    const anchoPantalla = window.innerWidth;

    if (anchoPantalla > 1145) {
      // Haz algo cuando el ancho de la pantalla sea mayor a 1145 pixeles
      header.style.left = '0';
      // Puedes agregar aquí más acciones o llamadas a funciones según tus necesidades
    }
  }
  // Llama a verificarAncho al cargar la página
  verificarAncho();

  // Agrega un evento de cambio de tamaño de ventana
  window.addEventListener('resize', verificarAncho);
</script>