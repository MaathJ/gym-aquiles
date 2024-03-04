<?php
session_start();
include('../config/dbconnect.php');
if (
    isset($_POST['txtusuario']) &&
    isset($_POST['txtpass']) &&
    isset($_POST['txtconfpass']) &&
    isset($_POST['txtnombre']) &&
    isset($_POST['txttelefono']) &&
    isset($_POST['lstrol'])
) {
    $user = strtoupper($_POST['txtusuario']);
    $pass = strtoupper($_POST['txtpass']);
    $confpass = strtoupper($_POST['txtconfpass']);
    $nombre = strtoupper($_POST['txtnombre']);
    $telefono = $_POST['txttelefono'];
    $rol = strtoupper($_POST['lstrol']);

    $sql = "INSERT INTO usuario (usuario_us, password_us, nombre_us, telefono_us, estado_us, id_ro) VALUES ('$user', '$pass', '$nombre','$telefono', 'ACTIVO', '$rol')";
    $f = mysqli_query($cn, $sql);

    if ($f) {

        $_SESSION['success_message'] = 'Se ha registrado exitosamente el usuario: ' . $nombre;
        
          
    }else{
        $_SESSION['alert_message'] = 'Error al preparar la consulta';
    }
    mysqli_close($cn);
    header('location: ../usuario.php');
}
?>