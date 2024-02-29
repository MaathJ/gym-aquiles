<?php 
session_start();
include('../config/dbconnect.php');

$id = $_POST['cargo_id'];
try {
    $sql_select = "SELECT nombre_ca FROM cargo WHERE id_ca = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_cargo = $row['nombre_ca'];

        $sql_delete = "DELETE FROM cargo WHERE id_ca = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_cycle'] = "Cargo eliminado: $nombre_cargo";
    } else {
        $_SESSION['deleted_cycle'] = "No se pudo obtener la información del periodo con ID: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_cycle'] = "Error al eliminar el cargo: $nombre_cargo";
}

header('location:../cargo.php');

?>