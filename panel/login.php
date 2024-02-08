<?php
session_start();
if(isset($_SESSION['id']) && !empty($_SESSION['id']))
{
    header('Location: index.php');
    exit; // Asegúrate de salir del script después de redirigir
}
include ('validadores/validar_primer_user.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Open+Sans:wght@300&family=Raleway:wght@300&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="../css/init.css">
    <link rel="stylesheet" href="css/estilos.css">
    <!--META-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTES EN EVOLUCION - INCIO DE SESION</title>
</head>
<body class="principal_login">
    <div class="login">
        <form action="validadores/validar_usuario.php" method="post">
            <img src="../img/recursos/logo2.png" alt="Logo Mentes en Evolucion">
            <h2>INICIO DE SESION</h2>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario">
            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña">
            <button type="submit">Ingresar</button>
            <legend>
                <?php 
                    if(isset($_SESSION['mensaje']))
                    {
                        echo $_SESSION['mensaje'];
                    }
                ?>
            </legend>
        </form>
    </div>
</body>
</html>