<?php 
include('../config/dbconnect.php');
$desc = $_POST['desc'];

$sql="INSERT INTO tipo_pago (desc_tp) VALUES ('$desc')";

mysqli_query($cn,$sql);

header("location: ../tipoPago.php");
?>