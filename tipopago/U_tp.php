<?php
include('../config/dbconnect.php');
 
$id = $_POST['id'];
$desc = $_POST['desc'];

$sql = "UPDATE tipo_pago SET desc_tp = '$desc' WHERE id_tp = $id";

mysqli_query($cn,$sql);

header("location: ../tipoPago.php");
?>  