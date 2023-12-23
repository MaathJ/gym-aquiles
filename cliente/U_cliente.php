<?php  

include('../config/dbconnect.php');

$codigo = $_POST['txtcodigo2'];
$nombre = $_POST['txtnombre'];
$apellido = $_POST['txtapellido'];
$dni = $_POST['txtdni'];
$telefono = $_POST['txttelefono'];
$edad = $_POST['txtedad'];
$direccion = $_POST['txtdireccion'];
$genero = $_POST['lstgenero2'];
$enfermedad = $_POST['txtenfermedad'];
$estado = $_POST['txtestado'];

$archivo = $_FILES['foto2']["tmp_name"]; 
$nombres=$_FILES["foto2"]["name"];


if($archivo != null){


list($n,$e)=explode(".",$nombres);

if ($e=="png" || $e=="jpg") {

$sql2="UPDATE cliente set nombre_cli = '$nombre', apellido_cli = '$apellido', dni_cli='$dni', telefono_cli ='$telefono', edad_cli ='$edad',genero_cli = '$genero', direccion_cli = '$direccion', estado_cli ='$estado', enfermedad_cli ='$enfermedad' WHERE id_cli = '$codigo'";


mysqli_query($cn,$sql2);

    move_uploaded_file($archivo,"../assets/images/cliente/".$dni.".jpg");
    header('location: ../cliente.php');

    }else{
header('location:../cliente.php');

}

}else{
	
    $sql3="UPDATE cliente set nombre_cli = '$nombre', apellido_cli = '$apellido', dni_cli='$dni', telefono_cli ='$telefono', edad_cli ='$edad',genero_cli = '$genero', direccion_cli = '$direccion', estado_cli ='$estado', enfermedad_cli ='$enfermedad' WHERE id_cli = '$codigo'";

    $f = mysqli_query($cn, $sql3);
    header('location:../cliente.php');

}

?>