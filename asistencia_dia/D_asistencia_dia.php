<?php  

include('../config/dbconnect.php');

$codigo = $_POST['txt_id'];

$sql = "delete from asistencia_pago where id_asip = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../asistencia_dia.php');
?>
