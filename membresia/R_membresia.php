<?php
session_start();
include('../config/dbconnect.php');

$nombre = $_POST['txt_nomb'];
$duracion = $_POST['txt_dura'];
$precio = $_POST['txt_prec'];
$estado = "ACTIVO";
$serv = $_POST['lst_serv'];

$sql="INSERT INTO membresia(nombre_me, duracion_me, precio_me, estado_me, id_se) values ('$nombre', $duracion, $precio, '$estado', $serv)";
$fmen=mysqli_query($cn,$sql);
if ($fmen) {

    $_SESSION['success_message'] = 'Se ha registrado exitosamente la membresia: ' . $nombre;
    
      
}else{
    $_SESSION['alert_message'] = 'Error al preparar la consulta';
}
mysqli_close($cn);
header('location: ../membresia.php');




?>