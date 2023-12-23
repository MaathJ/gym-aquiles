<?php  

include('../config/dbconnect.php');

$n =$_POST['txtnombre'];
$p =$_POST['txtprecio'];

	
	
$sql = "insert into tipo_rutina(nombre_tiru, precio_tiru) values ('$n', '$p')";

$r = mysqli_query($cn, $sql);
	
header("location: ../tipo_rutina.php");
?>