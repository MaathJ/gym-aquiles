<?php
include('../config/dbconnect.php');

$id=$_POST['txt_id'];
$nombre = $_POST['txt_nomb'];

$sql="update servicio set nombre_se ='$nombre'
    where id_se = $id";

mysqli_query($cn,$sql);

header('location: ../servicio.php');
?>