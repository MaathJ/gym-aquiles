<?php  

include('../config/dbconnect.php');

$n =$_POST['txt_nombre'];
$r =$_POST['txt_rutina'];

$sql = "insert into asistencia_pago(nomb_asip, id_tiru) values ('$n', '$r')";

$r = mysqli_query($cn, $sql);
	
header("location: ../asistencia.php");
?>