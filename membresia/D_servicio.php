<?php
include('../config/dbconnect.php');


$id=$_POST['txt_id'];

$sql="delete from servicio
    where id_se = $id";

mysqli_query($cn,$sql);

header('location: ../servicio.php');
?>