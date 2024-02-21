<?php
include('../config/dbconnect.php');

$sql_img = "SELECT * FROM configurador_historial where estado_conf = 'ACTIVO'";

$sqlCH=mysqli_query($cn, $sql_img);
$rsqlconfH = mysqli_fetch_assoc($sqlCH);
echo $rsqlconfH['foto_conf'];
?>