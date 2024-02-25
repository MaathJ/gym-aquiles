<?php
include('../config/dbconnect.php');

$nombre = $_POST['txt_nomb'];

$sql="insert into servicio(nombre_se) values ('$nombre')";

mysqli_query($cn,$sql);

header('location: ../servicio.php');
?>