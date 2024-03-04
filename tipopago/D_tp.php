<?php  
include('../config/dbconnect.php');

$codigo = $_POST['txt_id'];

$sql = "delete from tipo_pago where id_tp = $codigo";

mysqli_query($cn, $sql);
	
header('location: ../tipoPago.php');
?>