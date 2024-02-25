<?php

include('../config/dbconnect.php');

$nombre = $_POST['txt_nomb'];
$duracion = $_POST['txt_dura'];
$precio = $_POST['txt_prec'];
$estado = "ACTIVO";
$serv = $_POST['lst_serv'];

$sql="insert into membresia(nombre_me, duracion_me, precio_me, estado_me, id_se) values ('$nombre', $duracion, $precio, '$estado', $serv)";

$fmen=mysqli_query($cn,$sql);

header('location: ../membresia.php');




?>