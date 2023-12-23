<?php
$cn=mysqli_connect("localhost","root","","gym_aquiles");


$id=$_POST['txt_id'];

$sql="delete from servicio
    where id_se = $id";

mysqli_query($cn,$sql);

header('location: ../servicio.php');
?>