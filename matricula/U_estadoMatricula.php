<?php
include('config/dbconnect.php');
$sql_est="SELECT * FROM matricula";
$f_est=mysqli_query($cn, $sql_est);

date_default_timezone_set('America/Lima');
$fechaHoy = new DateTime();

while($r_est = mysqli_fetch_assoc($f_est)){
    $id=$r_est['id_ma'];

    $estado = $r_est['estado_ma'];
    $fechaFin = new DateTime($r_est['fechafin_ma']);
    $fechaIni = new DateTime($r_est['fechainicio_ma']);

    if($estado == "EN ESPERA" && $fechaHoy >= $fechaIni && $fechaHoy < $fechaFin){
        $estado = "ACTIVO";

        $sql_upd="UPDATE matricula set estado_ma = '$estado' WHERE id_ma = $id";
        mysqli_query($cn, $sql_upd);
    }elseif($estado == "ACTIVO" && $fechaHoy > $fechaFin){
        $estado = "CULMINADO";

        $sql_upd="UPDATE matricula set estado_ma = '$estado' WHERE id_ma = $id";
        mysqli_query($cn, $sql_upd);
    }
}
?>