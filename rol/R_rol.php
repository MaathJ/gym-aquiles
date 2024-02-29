<?php 

session_start();
include('../config/dbconnect.php');

if (isset($_POST['rol'])) {
   
    $rol = strtoupper($_POST['rol']) ;
   

    $sqlrol ="INSERT INTO rol (nombre_ro) VALUES('$rol')";
    $fmen=mysqli_query($cn,$sqlrol);

    if ($fmen) {

        $_SESSION['success_message'] = 'Se ha registrado exitosamente el rol: ' . $rol;
        
          
    }else{
        $_SESSION['alert_message'] = 'Error al preparar la consulta';
    }
    mysqli_close($cn);
    header('location: ../roles.php');

}