<?php  
include('../config/dbconnect.php');

$codigo = $_POST['txt_id'];

$sql = "delete from tipo_pago where id_tp = $codigo";

// ELIMINAR RUTA DE LA IMAGEN
$ruta_fp="../assets/images/tipoPago/".$codigo.".jpg";
if (file_exists($ruta_fp)) {
    unlink($ruta_fp);
}

mysqli_query($cn, $sql);
	
header('location: ../tipoPago.php');
?>