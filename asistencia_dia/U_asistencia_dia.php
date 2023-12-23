<?php
    
include('../config/dbconnect.php');
 
    $c = $_POST['txtcod'];
    $n = $_POST['txtnombre'];
    $r = $_POST['txt_rutina'];

    $sql = "SELECT id_tiru FROM tipo_rutina WHERE nombre_tiru = '$r'";
    $result = mysqli_query($cn, $sql);

    $row = mysqli_fetch_assoc($result);
    $codigo_tiru = $row['id_tiru'];

    $sql3 = "UPDATE asistencia_pago SET nomb_asip = '$n', id_tiru = '$codigo_tiru' WHERE id_asip = '$c'";
    mysqli_query($cn, $sql3);

    header("location: ../asistencia_dia.php");
?>
