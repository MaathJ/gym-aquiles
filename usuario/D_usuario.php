<?php 
 include('../config/dbconnect.php');

  $codigo = $_GET['cod'];

  $sql = "DELETE from usuario WHERE id_us=$codigo";
  mysqli_query($cn,$sql);

  header('location:../usuario.php')
?>