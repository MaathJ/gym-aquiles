<?php
session_start();
include('../config/dbconnect.php');


$id = $_POST['txt_id'];
try {
  $sql_select = "SELECT nombre_me FROM membresia WHERE id_me = $id";
  $result = mysqli_query($cn, $sql_select);

  if ($result && $row = mysqli_fetch_assoc($result)) {
    $nombre_membresia = $row['nombre_me'];

    $sql_delete = "DELETE FROM membresia WHERE id_me = '$id'";
    mysqli_query($cn, $sql_delete);

    $_SESSION['deleted_me'] = "membresia eliminada: $nombre_membresia";
  } else {
    $_SESSION['deleted_me'] = "No se pudo obtener la información de la membresia: $id";
  }
} catch (Exception $e) {
  $_SESSION['error_me'] = "Error la membresia: $nombre_membresia";
}

header('location: ../membresia.php');
