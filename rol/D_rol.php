<?php
session_start();
include('../config/dbconnect.php');

$id = $_POST['cod_rol2'];

try {
    $sql_select = "SELECT nombre_ro FROM rol WHERE id_ro = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_rol = $row['nombre_ro'];

        $sql_delete = "DELETE FROM rol WHERE id_ro = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_ro'] = "Rol eliminado: $nombre_rol";
    } else {
        $_SESSION['error_ro'] = "No se pudo obtener la información del rol: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_ro'] = "Error en: $nombre_rol";
}

header('location: ../roles.php');
?>
