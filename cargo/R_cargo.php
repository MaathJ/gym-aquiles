<?php 
session_start();
include('../config/dbconnect.php');

$cargo = strtoupper($_POST['cargo'] );
$estado = 'ACTIVO';


$sqlcargo = "INSERT INTO cargo (nombre_ca,estado_ca) VALUES('$cargo','$estado')";
$fcargo=mysqli_query($cn, $sqlcargo);

if ($fcargo) {

    $_SESSION['success_message'] = 'Cargo registrado exitosamente';
    
      
}else{
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}
mysqli_close($cn);
header('location:../cargo.php');
?>