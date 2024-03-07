
<script src="https://kit.fontawesome.com/c8bf7962f3.js" crossorigin="anonymous"></script>
<header class="menu">
    <div class="menu_alto">
        <div class="slide_button">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <img src="../../img/recursos/logo2.png" alt="Logo Mentes en Evolucion">
        <?php
            if(isset($_GET['id1']))
            {
                $reg_modulos=$conn->query("SELECT * FROM modulo WHERE id_capa={$_GET['id1']}");
                if($reg_modulos->num_rows>0)
                {
                    while($modulos=$reg_modulos->fetch_assoc())
                    {
                        echo '<ul>';
                            echo '<h2>'.$modulos['titulo'].'</h2>';
                            $reg_clases=$conn->query("SELECT * FROM clases WHERE id_capa={$_GET['id1']} AND id_modulo={$modulos['id']}");
                            if($reg_clases->num_rows>0)
                            {
                                while($clases=$reg_clases->fetch_assoc())
                                {
                                    echo '<li><a href="estudiar.php?id1='.$_GET['id1'].'&id_clase='.$clases['id'].'"><i class="fas fa-graduation-cap"></i> '.$clases['titulo'].'</a></li>';
                                }
                            }
                        echo '</ul>';
                    }
                }
            }
            else
            {
            }
        ?>
    </div>
    <div class="menu_bajo">
        <ul>
            <h2>Mis Datos</h2>
            <li><a href="../alumno"><i class="fa-solid fa-angles-left"></i> Volver a mis cursos</a></li>
            <li><a href="datos"><i class="fas fa-id-card"></i> Datos Personales</a></li>
            <li><a href="https://www.mentesenevolucion.com.ar"><i class="fas fa-undo-alt"></i> Volver</a></li>
            <li><a href="../exit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
        </ul>
    </div>
</header>
