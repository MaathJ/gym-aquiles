<?php 
include('../config/dbconnect.php');

$cod=$_POST['u_cod'];
$estado = $_POST['u_estado'];
$nombre=  $_POST['u_cargo'];

// echo $cod .' -' .$estado.' -' .$nombre;

$sql = "UPDATE cargo 
set nombre_ca ='$nombre',
    estado_ca = '$estado'
    WHERE id_ca = $cod
 ";
 mysqli_query($cn,$sql);

 header('location:../cargo.php');

//  echo '<script>window.location.href = "../cargo.php";</script>';

?>