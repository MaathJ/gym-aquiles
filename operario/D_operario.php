<?php  
session_start();
include('../config/dbconnect.php');

$id = $_POST['Operario_id'];




try {
    $sql_select = "SELECT nombre_op FROM operario WHERE id_op = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_operario = $row['nombre_op'];

        $sql_delete = "DELETE from operario where id_op =  '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_cycle'] = "Cargo eliminado: $nombre_operario";
    } else {
        $_SESSION['deleted_cycle'] = "No se pudo obtener la información del periodo con ID: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_cycle'] = "Error al eliminar el Operario: $nombre_operario";
}

header('location:../operario.php');


?>