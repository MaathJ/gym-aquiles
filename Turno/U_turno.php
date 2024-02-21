<?php
    
    include('../config/dbconnect.php');

 
    $n = $_POST['txtnombre'];
    $c = $_POST['txtid'];
    $e = $_POST['txtestado'];

    $sql3 = "UPDATE turno SET nombre_tu = '$n', estado_tu = '$e' WHERE id_tu = '$c'";
    mysqli_query($cn, $sql3);

    header("location: ../turno.php");
?>  
