<?php
session_start();
include('../config/dbconnect.php');

$id = $_POST['cod_rol2'];

try {
    $sql_select = "SELECT nombre_us FROM usuario WHERE id_us = $id";
    $result = mysqli_query($cn, $sql_select);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nombre_usuario = $row['nombre_us'];

        $sql_delete = "DELETE FROM usuario WHERE id_us = '$id'";
        mysqli_query($cn, $sql_delete);

        $_SESSION['deleted_us'] = "Usuario eliminado: $nombre_usuario";
    } else {
        $_SESSION['error_us'] = "No se pudo obtener la información del usuario: $id";
    }
} catch (Exception $e) {
    $_SESSION['error_us'] = "Error en: $nombre_usuario";
}

header('location: ../usuario.php');
?>
