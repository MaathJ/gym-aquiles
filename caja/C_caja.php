<?php  
include('../config/dbconnect.php');

$codigo = $_POST['codigo'];
$e = $_POST['Efectivo'];
$y = $_POST['Yape'];
$p = $_POST['Plin'];
$t = $_POST['txt_total'];
$s = $_POST['sue_inicial'];


$sqlcant = "SELECT * FROM caja WHERE id_us = $codigo AND cier_caj IS NULL"; 

$f = mysqli_query($cn, $sqlcant);

$r = mysqli_fetch_assoc($f);

$codigocaja = $r['id_caj'];

date_default_timezone_set('America/Lima');
$fechaHora = date("Y-m-d H:i:s");

echo $fechaHora; 

$sqlcierre = "UPDATE caja SET 
cier_caj = '$fechaHora',
 yape_caj= '$y' , 
 plin_caj = '$p' ,
  ejec_caj = '$e' ,
   tot_caj = '$t',
   estado='FINALIZADO'
   
    WHERE id_caj = $codigocaja"; 

mysqli_query($cn, $sqlcierre);

if(mysqli_affected_rows($cn) > 0) {
    header('location: ../principal.php');
} else {
    echo "Error al cerrar la caja: " . mysqli_error($cn);
}

?>
