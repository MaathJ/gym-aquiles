<?php 
include('../config/dbconnect.php');

$codigo = $_GET['cod'];

$sql = "DELETE FROM cargo WHERE id_ca = $codigo";


mysqli_query($cn,$sql);

echo '<script>window.location.href = "../cargo.php";</script>';
    






?>