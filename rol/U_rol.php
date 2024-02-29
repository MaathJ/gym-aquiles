<?php
include('../config/dbconnect.php');

$id = $_POST['txtid'];
$rol = $_POST['txtnombre'];

$sql="UPDATE rol SET nombre_ro='$rol' WHERE id_ro='$id'";
mysqli_query($cn, $sql);

header("location: ../roles.php");

?>