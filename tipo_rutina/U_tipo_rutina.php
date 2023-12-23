<?php
    
include('../config/dbconnect.php');
 
    $c = $_POST['txtcod'];
    $n = $_POST['txtnombre'];
    $p = $_POST['txtprecio'];

    $sql3 = "UPDATE tipo_rutina SET nombre_tiru = '$n', precio_tiru = '$p' WHERE id_tiru = '$c'";
    mysqli_query($cn, $sql3);

    header("location: ../tipo_rutina.php");
?>  
