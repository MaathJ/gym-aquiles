<?php 
 include('../config/dbconnect.php');

  $codigo = $_GET['cod'];

  try {
    $sql = "DELETE from matricula WHERE id_ma=$codigo";
    mysqli_query($cn,$sql);

  } catch (\Throwable $th) {
    
  }


  header('location:../matricula.php')
?>