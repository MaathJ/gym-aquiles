<?php  
session_start();
include('../config/dbconnect.php');



$nombre = $_POST['txtnombre'];
$apellido = $_POST['txtapellido'];
$dni = $_POST['txtdni'];
$telefono = $_POST['txttelefono'];
$edad = $_POST['txtedad'];
$cargo = $_POST['lstcargo'];

$turno = $_POST['lstturno'];

$archivo = $_FILES['foto']["tmp_name"]; 
$nombres=$_FILES["foto"]["name"];

if($archivo !=null){


list($n,$e)=explode(".",$nombres);

if ($e=="png" || $e=="jpg" || $e=="jpeg") {
   
    
	$sql = "insert into operario(nombre_op,	apellido_op,  estado_op,	dni_op,	edad_op, telefono_op,	id_tu, id_ca) values 
    ('$nombre','$apellido','ACTIVO','$dni','$edad','$telefono','$turno','$cargo')";

	$fOpe = mysqli_query($cn, $sql);

	move_uploaded_file($archivo,"../assets/images/operario/".$dni.".jpg");
	header('location: ../operario.php');

        if ($fOpe) {

            $_SESSION['success_message'] = 'Operario registrado exitosamente';
            
            
        }else{
            $_SESSION['alert_message'] = 'Error al preparar la consulta';
        }
        mysqli_close($cn);
    header('location:../operario.php');
    }else{
    header('location:../operario.php');
}
}else{
    header('location:../operario.php');
}
	
?>