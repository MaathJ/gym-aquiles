<?php  

include('../config/dbconnect.php');


$codigo = $_GET['cod'];

$sql = "delete from caja where id_caj = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../cajas.php');
?>