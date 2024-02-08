<?php
session_start();
if(!isset($_SESSION['id']) || empty($_SESSION['id']))
{
    
    exit; // Asegúrate de salir del script después de redirigir
}
else
{
    if(isset($_SESSION['id']) && !empty($_SESSION['id']))
    {
        if(isset($_SESSION['rol'])) 
        {
            switch($_SESSION['rol']) 
            {
                case 1:
                    header('Location: administrador/');
                    break;
                case 2:
                    header('Location: agente/');
                    break;
                case 3:
                    header('Location: alumno');
                    break;
                default:
                    header('Location: error.php');
                    break;
            }
        }
    }
}
?>
index