<?php  

include('../config/dbconnect.php');

$codigo = $_GET['d'];

$sql = "delete from cliente where id_cli = '$codigo'";

mysqli_query($cn, $sql);
	
	header('location: ../cliente.php');


?>