<?php  

include('../config/dbconnect.php');

$codigo = $_GET['d'];

$sql = "delete from operario where id_op = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../operario.php');


?>