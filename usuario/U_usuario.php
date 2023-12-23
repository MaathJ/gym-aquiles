<?php 
include('../config/dbconnect.php');

 $id = $_POST['id_us'];
 $usuario = $_POST['txtusuario'];
 $pass = $_POST['txtpass'];
 $nombre = $_POST['txtnombre'];
 $telefono = $_POST['txttelefono'];
 $rol = $_POST['id_rol_seleccionado'];
 $estado = $_POST['lstestado'];
 
 echo $id .' ;'. $usuario.' -'.$rol;  

 
$sql = "UPDATE  usuario set 
        usuario_us = '$usuario',
        password_us = '$pass',
        nombre_us='$nombre',
        telefono_us='$telefono',
        estado_us='$estado',
        id_ro = $rol
    
        WHERE id_us = '$id'
        
        ";

mysqli_query($cn, $sql);
	
	header('location:../usuario.php');

?>