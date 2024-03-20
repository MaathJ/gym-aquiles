<?php
    
    include('../config/dbconnect.php');

 
    $c = $_POST['txtcaja2'];
    $s = $_POST['txtsaldo'];
    $e = $_POST['txtestado'];

    $sql3 = "UPDATE caja SET sal_inicial = '$s', estado = '$e' WHERE id_caj = '$c'";
    mysqli_query($cn, $sql3);

    header("location: ../cajas.php");
?>  