<?php  

include('../config/dbconnect.php');


$codigo = $_GET['cod'];

$sql = "delete from turno where id_tu = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../turno.php');


?>