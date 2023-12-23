<?php  

include('../config/dbconnect.php');

$codigo = $_GET['d'];

$sql = "delete from asistencia_pago where id_asip = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../asistencia_dia.php');
?>
