<?php
include('../config/dbconnect.php');


$id=$_POST['txt_id'];

$sql="delete from membresia
    where id_me = $id";

  try {
    mysqli_query($cn,$sql);

  } catch (\Throwable $e) {
    # code...
  }  

header('location: ../membresia.php');
?>