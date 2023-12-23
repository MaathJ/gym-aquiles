<?php  

include('../config/dbconnect.php');

$codigo = $_GET['d'];

$sql = "delete from tipo_rutina where id_tiru = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../tipo_rutina.php');


?>