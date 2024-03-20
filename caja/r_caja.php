<?php  

include('../config/dbconnect.php');

$codigo = $_POST['codigo'];
$saldo = $_POST['saldo'];
$estado = 'APERTURADO';

$sqlcant = "SELECT count(id_caj) as total FROM caja WHERE  cier_caj IS NULL"; 

$f = mysqli_query($cn, $sqlcant);

$r = mysqli_fetch_assoc($f); 

date_default_timezone_set('America/Lima');
$fechaHora = date("Y-m-d H:i:s");


if($r['total'] > 0){
    header('location: ../principal.php');
} else {
    $sqlcaja = "INSERT INTO caja (aper_caj, cier_caj, sal_inicial, tot_caj, estado, id_us) VALUES ('$fechaHora',null, '$saldo', '0', '$estado', '$codigo')";
    $fcargo = mysqli_query($cn, $sqlcaja);

    if($fcargo){
        header('location: ../principal.php');
    } else {
        echo "Error al crear la caja: " . mysqli_error($cn);
    }
}

?>
