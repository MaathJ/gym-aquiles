<?php
session_start();
include('../config/dbconnect.php');

$id = $_POST['id_us'];
$usuario = $_POST['txtusuario'];
$pass = $_POST['txtpass'];
$nombre = $_POST['txtnombre'];
$telefono = $_POST['txttelefono'];
$rol = $_POST['id_rol_seleccionado'];
$estado = $_POST['lstestado'];

$sql = "UPDATE usuario SET 
        usuario_us = '$usuario',
        password_us = '$pass',
        nombre_us = '$nombre',
        telefono_us = '$telefono',
        estado_us = '$estado',
        id_ro = '$rol'
        WHERE id_us = '$id'";

$resultado = mysqli_query($cn, $sql);

if ($resultado) {
    // La consulta de actualización fue exitosa
    $_SESSION['success_message'] = 'Se ha actualizado exitosamente el usuario con ID: ' . $id;
} else {
    // La consulta de actualización falló
    $_SESSION['error_us'] = 'Error al actualizar el usuario';
}

mysqli_close($cn);
header('location:../usuario.php');
?>
